<?php

namespace App\Repositories\deleted;

//GLOBAL IMPORT
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

//LOCAL IMPORT
use App\Models\Term;
use App\Models\Section;
use App\Interfaces\CrudInterface;
use App\Models\MeetingPattern;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\SectionDuplicateRequest;
class SectionRepository implements CrudInterface
{
    /**
     * @throws Exception
     */
    public function viewAll(): Model|Collection|null|array
    {
        try {

            // Step 1: Get the last 5 terms stored in the database
            $latestTerms = Term::orderByDesc('number')->take(5)->pluck('id');
            if ($latestTerms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
            }

            // Step 2: Get the sections associated with the last 5 terms
            $sections = Section::whereIn('term_id', $latestTerms)
                ->with('term', 'course.department', 'instructorMode', 'campus', 'program','meetingPatterns.facility','meetingPatterns.user')
                ->get();

            if ($sections->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
            }

            // Step 3: Return the sections
            return $sections;

        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById($id): Model|Collection|null
    {
        try {
            $section = Section::with(['term', 'course', 'instructorMode', 'campus', 'program', 'meetingPatterns'])->find($id);
            if (!$section){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundById'));
            }
            return $section;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function comparePatterns($pattern1, $pattern2): bool
    {
        return $pattern1['day'] === $pattern2['day'] &&
            date('H:i', strtotime($pattern1['start_time'])) === $pattern2['start_time'] &&
            date('H:i', strtotime($pattern1['end_time'])) === $pattern2['end_time'] &&
            strtolower($pattern1['facility_id']) === strtolower($pattern2['facility_id']) &&
            strtolower($pattern1['user_id']) === strtolower($pattern2['user_id']) &&
            $pattern1['primary_instructor'] === strval($pattern2['primary_instructor']);
    }

    /**
     * @throws Exception
     */
    public function create(array $request): object|array|null
    {
        try {
            // Step 1: Get the number of meeting patterns in the request
            $requestMeetingPatterns = $request['meeting_patterns'];
            $combinedState = false;

            // Step 2: Find duplicate sections that have the same meeting_patterns
            $duplicatedSections = Section::with('meetingPatterns')
                ->where('caps', $request['caps'])
                ->where('term_id', strtolower($request['term_id']))
                ->where('course_id', strtolower($request['course_id']))
                ->where('sec_code', $request['sec_code'])
                ->where('sec_number', $request['sec_number'])
                ->where('cap', $request['cap'])
                ->where('instructor_mode_id', strtolower($request['instructor_mode_id']))
                ->where('campus_id', strtolower($request['campus_id']))
                ->where('starting_date', $request['starting_date'])
                ->where('ending_date', $request['ending_date'])
                ->where('program_id', strtolower($request['program_id']))
                ->where('cohorts', $request['cohorts'])
                ->where('status', $request['status'])
                ->get();

            if ($duplicatedSections->count()>0){
                // Step 2: Update duplicate sections
                foreach ($duplicatedSections as $section) {
                    foreach ($section->meetingPatterns as $patternIndex => $pattern) {
                        foreach ($requestMeetingPatterns as $requestPatternIndex => $requestPattern) {
                            if ($this->comparePatterns($pattern, $requestPattern) && count($section->meetingPatterns) === count($requestMeetingPatterns)) {
                                $section->combined = true;
                                $combinedState = true;
                                $section->save();
                            }
                        }
                    }
                }
            }

            // Step 3: Create a new section
            $section = new Section();
            $newSection = $this->dataFormatSection($request, $section);
            $user = Auth::user();
            $newSection->created_by = $user->user_name;
            $newSection->combined = $combinedState;

            // Step 4: Save the new section
            $newSection->save();

            // Step 5: Assign the mating pattern to the new section
            $this->createMeetingPattern($request, $newSection->id);

            // Step 6: Return the new created section
            return $newSection;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $isDifferent = true;

            // Step 1: Search the section by its ID
            $section = Section::with('meetingPatterns')->find($id);
            if (!$section) {
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundById'));
            }

            // Step 2: Compare the values of the request with the values of the section to update
            if(((int)$section->caps===1? true: false) === $request['caps'] &&
                $section->term_id === $request['term_id'] &&
                $section->course_id === $request['course_id'] &&
                $section->sec_code === $request['sec_code'] &&
                $section->sec_number === $request['sec_number'] &&
                $section->cap === strval($request['cap']) &&
                $section->instructor_mode_id === $request['instructor_mode_id'] &&
                $section->campus_id === $request['campus_id'] &&
                $section->starting_date === $request['starting_date'] &&
                $section->ending_date === $request['ending_date'] &&
                $section->program_id === $request['program_id'] &&
                $section->cohorts === $request['cohorts'] &&
                $section->status === $request['status']
            ){
                foreach ($section->meetingPatterns as $patternIndex => $pattern) {
                    foreach ($request['meeting_patterns'] as $requestPatternIndex => $requestPattern) {
                        if ($this->comparePatterns($pattern, $requestPattern) && count($section->meetingPatterns) === count($request['meeting_patterns'])) {
                            $isDifferent=false;
                        }
                    }
                }
            }

            // Step 3: If the request is equal to the values of the section to be edited, the same section is returned
            if(!$isDifferent){
                return $section;
            } else {

                // Step 4: If the request is different, duplicate sections must be searched using the section we found by id
                $duplicatedSections = $this->getDuplicateSections($section, $id);

                // Step 5: If there is only one section equal to the one we found by id, the combined value must be changed to false
                if ($duplicatedSections->count()===1){
                    $user = Auth::user();
                    $duplicatedSections->first()->updated_by = $user->user_name;
                    $duplicatedSections->first()->combined=false;
                    $duplicatedSections->first()->save();
                }

                // Step 6: We update the section found by the id with the new values from the request
                $updatedSection = $this->dataFormatSection($request, $section);

                // Step 7: We search again to see if there is any section equal to the one we are going to update
                $duplicatedSections = $this->getDuplicateSections($updatedSection, $id);

                // Step 8: If we find at least one section (it will always be 1), we change the value of combined to true for the duplicate section
                if ($duplicatedSections->count()>0 && count($duplicatedSections->first()->meetingPatterns) === count($request['meeting_patterns'])){
                    $user = Auth::user();
                    $duplicatedSections->first()->updated_by = $user->user_name;
                    $duplicatedSections->first()->combined=true;
                    $duplicatedSections->first()->save();
                    $updatedSection->combined=true;
                }
            }

            // Step 9: I update the meeting patterns and save the changes to the database
            $updatedSection->meetingPatterns()->delete();
            $this->createMeetingPattern($request,$updatedSection->id);
            $updatedSection->save();

            // Step 10: Return the updated section
            return $updatedSection;

        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function duplicateSections(SectionDuplicateRequest $request): int
    {
        try {
            DB::beginTransaction();

            // Step 1: Declare the duplicate section counter
            $numberDuplicateSections = 0;

            // Step 2: Get all sections of the origin term
            $sectionsOrigin = Section::with('meetingPatterns')
                ->where('term_id', $request['term_id_origin'])
                ->get();

            if ($sectionsOrigin->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
            }

            // Step 3: Duplicate and save the sections in the destination term
            foreach ($sectionsOrigin as $section) {
                $newSection = $section->replicate(); // Clone the section
                $newSection->term_id = $request['term_id_destination']; // Assign the destination term
                $newSection->save(); // Save the new section

                // Duplicate and save the section meeting patterns
                foreach ($section->meetingPatterns as $meetingPattern) {
                    $nuevoMeetingPattern = $meetingPattern->replicate(); // Clone the meeting pattern
                    $nuevoMeetingPattern->section_id = $newSection->id; // Assign the new section

                    // Change user_id if instructor=true and user_id is present
                    if ($request['instructor'] && $request['user_id']) {
                        $nuevoMeetingPattern->user_id = $request['user_id'];
                    }
                    $nuevoMeetingPattern->save(); // Save the new meeting pattern
                }
                //Increment duplicate section counter
                $numberDuplicateSections++;
            }
            DB::commit();

            // Step 4: Return the number of duplicate sections
            return $numberDuplicateSections;

        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            DB::rollback();
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        DB::beginTransaction();
        try {
            $section = $this->viewById($id);
            if (!$section){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundById'));
            }
            $value = $section->meetingPatterns();
            $meetingPatterns = $value->pluck('ac.meeting_patterns.id')->toArray();
            foreach ($meetingPatterns as $meetingPatternId){
                $meetingPattern = MeetingPattern::find($meetingPatternId);
                $meetingPattern->instructors()->delete();
            }
            $value->delete();
            $section->delete();
            DB::commit();
            return $section;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            DB::rollback();
        }
    }

    public function dataFormatSection(array $request, Section $section):object|null
    {
        $section->caps = $request['caps'];
        $section->term_id = $request['term_id'];
        $section->course_id = $request['course_id'];
        $section->sec_code = $request['sec_code'];
        $section->sec_number = $request['sec_number'];
        $section->cap = $request['cap'];
        $section->instructor_mode_id = $request['instructor_mode_id'];
        $section->campus_id = $request['campus_id'];
        $section->starting_date = $request['starting_date'];
        $section->ending_date = $request['ending_date'];
        $section->program_id = $request['program_id'];
        $section->cohorts = $request['cohorts'];
        $section->status = $request['status'];
        $section->comment = $request['comment'];
        $section->internal_note = $request['internal_note'];
        return $section;
    }

    public function dataFormatMeetingPattern(array $request, string $sectionId): array
    {
        $array = [];
        foreach ($request['meeting_patterns'] as $planning){
            $meetingPattern = new MeetingPattern();
            $meetingPattern->day = $planning['day'];
            $meetingPattern->start_time = $planning['start_time'];
            $meetingPattern->end_time = $planning['end_time'];
            $meetingPattern->facility_id = $planning['facility_id'];
            $meetingPattern->section_id = $sectionId;
            $meetingPattern->user_id = $planning['user_id'];
            $meetingPattern->primary_instructor = $planning['primary_instructor'];
            $array[] = $meetingPattern;
        }
        return $array;
    }

    /**
     * @throws Exception
     */
    public function createMeetingPattern($request, $id): void
    {
        try {
            $meetingPatterns = $this->dataFormatMeetingPattern($request,$id);
            foreach ($meetingPatterns as $item){
                $item->save();
            }
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param Model|Collection|Builder|array|null $section
     * @param $id
     * @return Builder[]|Collection
     */
    public function getDuplicateSections(Model|Collection|Builder|array|null $section, $id): array|Collection
    {
        return Section::with('meetingPatterns')
            ->where([
                'caps' => $section->caps,
                'term_id' => $section->term_id,
                'course_id' => $section->course_id,
                'sec_code' => $section->sec_code,
                'sec_number' => $section->sec_number,
                'cap' => $section->cap,
                'instructor_mode_id' => $section->instructor_mode_id,
                'campus_id' => $section->campus_id,
                'starting_date' => $section->starting_date,
                'ending_date' => $section->ending_date,
                'program_id' => $section->program_id,
                'cohorts' => $section->cohorts,
                'status' => $section->status,
            ])
            ->whereHas('meetingPatterns', function ($query) use ($section) {
                $query->where([
                    'day' => $section->meetingPatterns->pluck('day')->toArray(),
                    'start_time' => $section->meetingPatterns->pluck('start_time')->toArray(),
                    'end_time' => $section->meetingPatterns->pluck('end_time')->toArray(),
                    'facility_id' => $section->meetingPatterns->pluck('facility_id')->toArray(),
                    'user_id' => $section->meetingPatterns->pluck('user_id')->toArray(),
                    'primary_instructor' => $section->meetingPatterns->pluck('primary_instructor')->toArray(),
                ]);
            })
            ->where('id', '!=', $id)
            ->get();
    }

    /**
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    // TODO: I must review this method with Samantha because I don't know how she controls access by dates.
    public function verifyAccessDates(string $termId): bool
    {
        try {
            // Step 1: Search the term by its ID
            $term = Term::with('accessPeriod')->find($termId);
            $hasAccess = false;
            if (!$term) {
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundById'));
            }

            // Step 2: Get the current date
            $now = Carbon::now();

            // Step 3: Compare whether the current date is greater than or equal to the administration start date and the department start date
            $adminBeginningDate = Carbon::parse($term->accessPeriod->admin_beginning_date);
            $departBeginningDate = Carbon::parse($term->accessPeriod->depart_beginning_date);

            if ($now->greaterThanOrEqualTo($adminBeginningDate) && $now->greaterThanOrEqualTo($departBeginningDate)) {

                // Step 4: // Compare whether the current date is less than or equal to the administration end date and the department end date
                $adminEndingDate = Carbon::parse($term->accessPeriod->admin_ending_date);
                $departEndingDate = Carbon::parse($term->accessPeriod->depart_ending_date);

                if ($now->lessThanOrEqualTo($adminEndingDate) && $now->lessThanOrEqualTo($departEndingDate)) {
                    // La fecha actual está dentro del período de acceso
                    $hasAccess= true;
                }
            }
            return $hasAccess;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

//    /**
//     * @throws ResourceNotFoundException
//     * @throws Exception
//     */
//    public function termInstructorQuantity(): array
//    {
//        try {
//            // Step 1: Get the last 5 terms stored in the database
//            $latestTerms = Term::with('sections.meetingPatterns.user')->orderByDesc('number')->take(6)->get();
//            if ($latestTerms->isEmpty()){
//                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
//            }
//
//            // Step 2: Initialize arrays to store the results
//            $totals = [];
//            $semesters = [];
//
//            // Step 3: For each term, obtain the associated sections and calculate the number of instructors
//            foreach ($latestTerms as $term) {
//                $semester = Str::upper(Str::substr($term->semester, 0, 2)) . $term->year;
//                $instructorCount = 0;
//
//                foreach ($term->sections as $section) {
//                    // Step 4 Add the number of unique instructors across all sections of the term
//                    $instructorCount += $section->meetingPatterns->pluck('user')->unique('id')->count();
//                }
//
//                // Step 5: Add data to arrays
//                $semesters[] = $semester;
//                $totals[] = $instructorCount;
//            }
//
//            // Step 6: Return arrays
//            return [
//                "series" => [
//                    [
//                        "name" => "Instructors",
//                        "data" => $totals
//                    ]
//                ],
//                "categories" => $semesters
//            ];
//
//        } catch (ResourceNotFoundException $e) {
//            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
//        } catch (Exception $e) {
//            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
//
//    /**
//     * @throws ResourceNotFoundException
//     * @throws Exception
//     */
//    public function getTermsInfo(): array
//    {
//        try {
//            //Step 1: Get the current date
//            $currentDate = Carbon::now();
//            $data = [];
//
//            //Step 2: Get the last 6 terms ordered by semester and year
//            $latestTerms = Term::orderByDesc('number')->take(6)->get();
//            if ($latestTerms->isEmpty()){
//                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
//            }
//
//            foreach ($latestTerms as $key => $term) {
//                //Step 3: Calculate the name of the term
//                $termName = ucfirst($term->semester) . $term->year;
//                $termStartDate = date('m/d/y', strtotime($term->begin_dt));
//                $termEndDate = date('m/d/y', strtotime($term->end_dt));
//
//                //Step 4: Count the number of sections in the term
//                $sectionsCount = $term->sections()->count();
//
//                //Step 5: Get all sections of the term
//                $sections = $term->sections()->with('meetingPatterns')->get();
//
//                //Step 6: Initialize a set to store unique instructors
//                $uniqueInstructors = collect();
//
//                //Step 7: Initialize an array to count the states
//                $statesCount = [];
//
//                foreach ($sections as $section) {
//                    //Step 8: Get the meetings associated with the section
//                    $meetingPatterns = $section->meetingPatterns;
//
//                    //Step 9: Increment the status counter
//                    $sectionState = $section->status;
//                    if (array_key_exists($sectionState, $statesCount)) {
//                        $statesCount[$sectionState]++;
//                    } else {
//                        $statesCount[$sectionState] = 1;
//                    }
//
//                    foreach ($meetingPatterns as $meetingPattern) {
//                        //Step 10: Add the instructor ID to the set of unique instructors
//                        $uniqueInstructors->add($meetingPattern->user_id);
//                    }
//                }
//                //Step 11:Eliminate duplicate ids
//                $collectionNoRepeats = $uniqueInstructors->unique();
//
//                //Step 12: Count the number of unique instructors
//                $instructorsCount = $collectionNoRepeats->count();
//
//                //Step 13: Get the corresponding previous term
//                $previousTerm = $latestTerms->get($key + 1);
//
//                $sectionsIncrease = 0;
//                $increase = false;
//
//                //Step 14: Inside the foreach loop to buy the sections quantities
//                if ($term->sections->count() > 0) {
//                    //Step 15: Get the data from the previous term of the same type (same season and previous year)
//                    $previousTerm = Term::where('semester', $term->semester)
//                        ->where('year', $term->year - 1)
//                        ->first();
//
//                    if ($previousTerm) {
//                        $previousSectionsCount = $previousTerm->sections()->count();
//                        $sectionsIncrease = max(($sectionsCount-$previousSectionsCount),0);
//                        $increase = $sectionsCount-$previousSectionsCount>0;
//                    }
//                }
//
//                //Step 16: Calculate days elapsed from begin_dt to today and days between begin_dt and end_dt
//                $beginDate = Carbon::parse($term->begin_dt);
//                $daysPassed = $beginDate->diffInDays($currentDate);
//                $endDate = Carbon::parse($term->end_dt);
//                $daysBetweenStartAndEnd = $beginDate->diffInDays($endDate);
//
//                //Step 17: Create the array for the current term
//                $termData = [
//                    'name' => $termName,
//                    'startDate' => $termStartDate,
//                    'endDate' => $termEndDate,
//                    'daysPassed'=> $daysPassed,
//                    'totalDays' => $daysBetweenStartAndEnd,
//                    'current' => $currentDate->greaterThanOrEqualTo($term->begin_dt) && $currentDate->lessThanOrEqualTo($term->end_dt),
//                    'sections' => $sectionsCount,
//                    'instructors' => $instructorsCount,
//                    'states' => $statesCount,
//                    'quantity' => [
//                        'value' => $sectionsIncrease,
//                        'increase' => $increase
//                    ]
//                ];
//
//                //Step 18: Add the term array to the main array
//                $data[] = $termData;
//            }
//            return $data;
//        } catch (ResourceNotFoundException $e) {
//            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
//        } catch (Exception $e) {
//            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
}
