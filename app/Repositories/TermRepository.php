<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\ActiveInterface;
use App\Interfaces\CrudInterface;
use App\Models\Term;
use App\Exceptions\ResourceNotFoundException;


class TermRepository implements CrudInterface,ActiveInterface {

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $terms = Term::orderBy('number', 'desc')->get();
            if ($terms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundAll'));
            }
            return $terms;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $terms = Term::where('ac.terms.active','=',$status)->get();
            if ($terms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundByStatus'));
            }
            return $terms;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById($id)
    {
        try {
            $term = Term::find($id);
            if (!$term){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundById'));
            }
            return $term;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): ?object
    {
        try {
            $term = new Term();
            $newTerm = $this->dataForTerm($request,$term);
            $newTerm->save();
            return $newTerm;
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $term = $this->viewById($id);
            if (!$term){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundById'));
            }
            $newTerm = $this->dataForTerm($request,$term);
            $newTerm->update();
            return $newTerm;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        try {
            $term = $this->viewById($id);
            if ($term->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundById'));
            }
            $term->delete();
            return $term;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataForTerm(array $request, Term $term):object|null
    {
        $term->number = $request['number'];
        $term->semester = $request['semester'];
        $term->year = $request['year'];
        $term->academic_year = $request['academic_year'];
        $term->description = $request['description'];
        $term->fiu_academic_year = $request['fiu_academic_year'];
        $term->description_short = $request['description_short'];
        $term->begin_dt_for_apt = $request['begin_dt_for_apt'];
        $term->begin_dt = $request['begin_dt'];
        $term->end_dt = $request['end_dt'];
        $term->close_end_dt = $request['close_end_dt'];
        $term->fas_begin_dt = $request['fas_begin_dt'];
        $term->fas_end_dt = $request['fas_end_dt'];
        $term->session = $request['session'];
        $term->academic_year_full = $request['academic_year_full'];
        $term->fiu_grade_date = $request['fiu_grade_date'];
        $term->fiu_grade_date_a = $request['fiu_grade_date_a'];
        $term->fiu_grade_date_b = $request['fiu_grade_date_b'];
        $term->fiu_grade_date_c = $request['fiu_grade_date_c'];
        $term->p180_status_term_id = $request['p180_status_term_id'];
        $term->active = $request['active'];
        return $term;
    }

    /**
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function numberInstructorsPerTerm(): array
    {
        try {
            // Step 1: Get the last 5 terms stored in the database
            $latestTerms = Term::with('sections.meetingPatterns.user')->orderByDesc('number')->take(6)->get();
            if ($latestTerms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
            }

            // Step 2: Initialize arrays to store the results
            $totals = [];
            $semesters = [];

            // Step 3: For each term, obtain the associated sections and calculate the number of instructors
            foreach ($latestTerms as $term) {
                $semester = Str::upper(Str::substr($term->semester, 0, 2)) . $term->year;
                $instructorCount = 0;

                foreach ($term->sections as $section) {
                    // Step 4 Add the number of unique instructors across all sections of the term
                    $instructorCount += $section->meetingPatterns->pluck('user')->unique('id')->count();
                }

                // Step 5: Add data to arrays
                $semesters[] = $semester;
                $totals[] = $instructorCount;
            }

            // Step 6: Return arrays
            return [
                "series" => [
                    [
                        "name" => "Instructors",
                        "data" => $totals
                    ]
                ],
                "categories" => $semesters
            ];

        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws ResourceNotFoundException
     * @throws Exception
     */

    public function termDetails(): array
    {
        try {
            //Step 1: Get the current date
            $currentDate = Carbon::now();
            $data = [];

            //Step 2: Get the last 6 terms ordered by semester and year
            $latestTerms = Term::orderByDesc('number')->take(6)->get();
            if ($latestTerms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundAll'));
            }

            foreach ($latestTerms as $key => $term) {
                //Step 3: Calculate the name of the term
                $termName = ucfirst($term->semester) . $term->year;
                $termStartDate = date('m/d/y', strtotime($term->begin_dt));
                $termEndDate = date('m/d/y', strtotime($term->end_dt));

                //Step 4: Count the number of sections in the term
                $sectionsCount = $term->sections()->count();

                //Step 5: Get all sections of the term
                $sections = $term->sections()->with('meetingPatterns')->get();

                //Step 6: Initialize a set to store unique instructors
                $uniqueInstructors = collect();

                //Step 7: Initialize an array to count the states
                $statesCount = [];
                $states = [];

                foreach ($sections as $section) {
                    //Step 8: Get the meetings associated with the section
                    $meetingPatterns = $section->meetingPatterns;

                    //Step 9: Increment the status counter
                    $sectionState = $section->status;
                    if (array_key_exists($sectionState, $statesCount)) {
                        $statesCount[$sectionState]++;
                    } else {
                        $statesCount[$sectionState] = 1;
                    }

                    foreach ($meetingPatterns as $meetingPattern) {
                        //Step 10: Add the instructor ID to the set of unique instructors
                        $uniqueInstructors->add($meetingPattern->user_id);
                    }
                }
                //Step 11:Eliminate duplicate ids
                $collectionNoRepeats = $uniqueInstructors->unique();

                //Step 12: Count the number of unique instructors
                $instructorsCount = $collectionNoRepeats->count();

                //Step 13: Get the corresponding previous term
                $previousTerm = $latestTerms->get($key + 1);

                $sectionsIncrease = 0;
                $increase = false;

                //Step 14: Inside the foreach loop to buy the sections quantities
                if ($term->sections->count() > 0) {
                    //Step 15: Get the data from the previous term of the same type (same season and previous year)
                    $previousTerm = Term::where('semester', $term->semester)
                        ->where('year', $term->year - 1)
                        ->first();

                    if ($previousTerm) {
                        $previousSectionsCount = $previousTerm->sections()->count();
                        $sectionsIncrease = max(($sectionsCount-$previousSectionsCount),0);
                        $increase = $sectionsCount-$previousSectionsCount>0;
                    }
                }

                //Step 16: Calculate days elapsed from begin_dt to today and days between begin_dt and end_dt
                $beginDate = Carbon::parse($term->begin_dt);
                $daysPassed = $beginDate->diffInDays($currentDate);
                $endDate = Carbon::parse($term->end_dt);
                $daysBetweenStartAndEnd = $beginDate->diffInDays($endDate);

                //Step 17: Create the array for states
                $statesArray = [];
                foreach ($statesCount as $state => $count) {
                    $statesArray[] = ['name' => $state, 'value' => $count];
                }

                //Step 18: Create the array for the current term
                $termData = [
                    'name' => $termName,
                    'semester' =>strtolower(substr($term->semester, 0, 2)),
                    'startDate' => $termStartDate,
                    'endDate' => $termEndDate,
                    'daysPassed'=> $daysPassed,
                    'totalDays' => $daysBetweenStartAndEnd,
                    'current' => $currentDate->greaterThanOrEqualTo($term->begin_dt) && $currentDate->lessThanOrEqualTo($term->end_dt),
                    'sections' => $sectionsCount,
                    'instructors' => $instructorsCount,
                    'states' => $statesArray,
                    'quantity' => [
                        'value' => $sectionsIncrease,
                        'increase' => $increase
                    ]
                ];

                //Step 19: Add the term array to the main array
                $data[] = $termData;
            }

            // Reorder $data to have the term with 'current' = true in the first position
            usort($data, function ($a, $b) {
                return $b['current'] <=> $a['current'];
            });

            return $data;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}


