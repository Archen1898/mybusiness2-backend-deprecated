<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

//LOCAL IMPORT
use App\Models\Section;
use App\Interfaces\CrudInterface;
use App\Models\MeetingPattern;
use App\Exceptions\ResourceNotFoundException;
class SectionRepository implements CrudInterface
{
    /**
     * @throws Exception
     */
    public function viewAll(): Model|Collection|null|array
    {
        try {
            $currentYear = date('Y');
            $twoYearsAgo = $currentYear - 2;
            $twoYearsLater = $currentYear + 2;

            $sections = Section::whereHas('term', function ($query) use ($twoYearsAgo, $twoYearsLater) {
                $query->where('year', '>=', $twoYearsAgo)
                    ->where('year', '<=', $twoYearsLater);
            })->with('term', 'course.department', 'instructorMode', 'campus', 'program','meetingPatterns.facility','meetingPatterns.user')
                ->get();

            if ($sections->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
            }
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
            $pattern1['facility_id'] === $pattern2['facility_id'] &&
            $pattern1['user_id'] === $pattern2['user_id'] &&
            $pattern1['primary_instructor'] === strval($pattern2['primary_instructor']);
    }
    /**
     * @throws Exception
     */
    public function create(array $request): object|array|null
    {
        try {
            $combinedState = false;

            // Step 1: Get the number of meeting patterns in the request
            $requestMeetingPatterns = $request['meeting_patterns'];

            // Step 2: Find duplicate sections that have the same meeting_patterns
            $duplicatedSections = Section::with('meetingPatterns')
                ->where('caps', $request['caps'])
                ->where('term_id', $request['term_id'])
                ->where('course_id', $request['course_id'])
                ->where('sec_code', $request['sec_code'])
                ->where('sec_number', $request['sec_number'])
                ->where('cap', $request['cap'])
                ->where('instructor_mode_id', $request['instructor_mode_id'])
                ->where('campus_id', $request['campus_id'])
                ->where('starting_date', $request['starting_date'])
                ->where('ending_date', $request['ending_date'])
                ->where('program_id', $request['program_id'])
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

                // Step 8: If we find at least one section (it will always be 1), we change the value of combined to true for the duplicate section and the updated section
                if ($duplicatedSections->count()>0 && count($duplicatedSections->first()->meetingPatterns) === count($request['meeting_patterns'])){
                    $user = Auth::user();
                    $duplicatedSections->first()->updated_by = $user->user_name;
                    $duplicatedSections->first()->combined=true;
                    $duplicatedSections->first()->save();
                    $updatedSection->combined=true;
                    $updatedSection->save();
                    $updatedSection->meetingPatterns()->delete();
                    $this->createMeetingPattern($request,$updatedSection->id);
                }
            }
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

    public function verifyAccessDates(Section $section): bool
    {

    }

}
