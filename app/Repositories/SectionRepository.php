<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Models\Section;
use App\Interfaces\CrudInterface;
use App\Models\delete\InstructorSection;
use App\Models\Instructor;
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
            })->with('term', 'course', 'instructorMode', 'campus', 'program', 'meetingPatterns')
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

    /**
     * @throws Exception
     */
    
    public function create(array $request): ?object
    {
        DB::beginTransaction();
        try {
            // Find all existing sections with the same data, except sec_code and sec_number
            $existingSections = Section::where('caps', $request['caps'])
                ->where('term_id', $request['term_id'])
                ->where('course_id', $request['course_id'])
                ->where('cap', $request['cap'])
                ->where('instructor_mode_id', $request['instructor_mode_id'])
                ->where('campus_id', $request['campus_id'])
                ->where('starting_date', $request['starting_date'])
                ->where('ending_date', $request['ending_date'])
                ->where('program_id', $request['program_id'])
                ->where('cohorts', $request['cohorts'])
                ->where('status', $request['status'])
                ->where('combined', false)
                ->get();

            // Update the combined field to true for all sessions found
            foreach ($existingSections as $existingSection) {
                $existingSection->combined = true;
                $existingSection->save();
            }

            // Create the new section
            $section = new Section();
            $newSection = $this->dataFormatSection($request, $section);
            $existingSections->count()>0? $newSection->combined = true: $newSection->combined = false;
            $newSection->save();

            // Create the Meeting Patterns
            $this->createMeetingPattern($request, $newSection->id);

            DB::commit();
            return $newSection;
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        DB::beginTransaction();
        try {
            $section = Section::find($id);
            if (!$section){
                throw new ResourceNotFoundException(trans('messages.section.exceptionNotFoundById'));
            }
            $newSection = $this->dataFormatSection($request,$section);
            $newSection->update();
            $newSection->meetingPatterns()->delete();
            $this->createMeetingPattern($request,$newSection->id);
            DB::commit();
            return $this->viewById($id);
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

    /**
     * @throws Exception
     */
    public function duplicateSections(array $request): string
    {
        DB::beginTransaction();
        try {
            // Counter for duplicate sections
            $numberDuplicateSections = 0;

            $idTermOrigin = 'id_del_termino_origen';
            $idTermDestination = 'id_del_termino_destino';

            $instructor = true;
            $user_id = 'id';

            // Get all sections of the origin term
            $sectionsOrigin = Section::where('term_id', $idTermOrigin)->with('meetingPatterns')->get();

            // Duplicate and save the sections in the destination term
            foreach ($sectionsOrigin as $section) {
                $newSection = $section->replicate(); // Clone the section
                $newSection->term_id = $idTermDestination; // Assign the destination term
                $newSection->save(); // Save the new section

                // Duplicate and save the section meeting patterns
                foreach ($section->meetingPatterns as $meetingPattern) {
                    $nuevoMeetingPattern = $meetingPattern->replicate(); // Clone the meeting pattern
                    $nuevoMeetingPattern->section_id = $newSection->id; // Assign the  new section

                    // Change user_id if instructor=true and user_id is present
                    if ($instructor && $user_id) {
                        $nuevoMeetingPattern->user_id = $user_id;
                    }
                    $nuevoMeetingPattern->save(); // Save the new meeting pattern
                }
                //Increment duplicate section counter
                $numberDuplicateSections++;
            }

            DB::commit();
            return $numberDuplicateSections;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
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
        $section->combined = $request['combined'];
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
    public function dataFormatInstructor(array $request):array
    {
        $array = [];
        foreach ($request['instructors'] as $instructor){
            $instructorNew = new Instructor();
            $instructorNew->user_id = $instructor['user_id'];
            $instructorNew->primary_instructor = $instructor['primary_instructor'];
            $array[] = $instructorNew;
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
}
