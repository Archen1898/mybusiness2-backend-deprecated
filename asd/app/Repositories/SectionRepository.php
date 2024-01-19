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
            $sections = Section::with('meetingPatterns.instructors')->get();
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
            $section = Section::with('meetingPatterns.instructors')->find($id);
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
            $section = new Section();
            $newSection = $this->dataFormatSection($request,$section);
            $newSection->save();
            $this->updateMeetingInstructor($request,$newSection->id);
            DB::commit();
            return $newSection;
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            DB::rollback();
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
            $meetingPatterns = $section->meetingPatterns()->pluck('ac.meeting_patterns.id')->toArray();
            foreach ($meetingPatterns as $meetingPatternId){
                $meetingPattern = MeetingPattern::find($meetingPatternId);
                $meetingPattern->instructors()->delete();
            }
            $newSection->meetingPatterns()->delete();
            $this->updateMeetingInstructor($request,$newSection->id);
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
            if (count($request['terms_olds']) != 3 | count($request['terms_news']) != 3){
                throw new Exception("The number of terms must be 3");
            }
//            $sectionsTerm = Section::with('meetingPatterns.instructors')->orderBy('term', 'desc')->get();
            foreach ($request['terms_olds'] as $termId){
                //get all sections using term ids array
                $sectionsTerm = Section::with('meetingPatterns.instructors')->where('term_id', $termId)->get();
                foreach ($sectionsTerm as $index=>$section){
                    //duplicate section
                    $newSection = $section->replicate();
                    $newSection->term_id = $request['terms_news'][$index];
                    $newSection->save();

                    //duplicate meeting pattern associate to section
                    foreach ($section->meetingPatterns as $meetingPattern){
                        $newMeetingPattern = $meetingPattern->replicate();
                        $newMeetingPattern->section_id = $newSection->id;
                        $newMeetingPattern->save();
                        //duplicate instructor associate to meeting pattern
                        foreach ($newMeetingPattern->instructors as $instructor){
                            $newInstructor = $instructor->replicate();
                            $newInstructor->save();
                        }
                    }
//                    foreach ($section->instructorSections as $instructor){
//                        $newInstructor = $instructor->replicate();
//                        $newInstructor->section_id = $newSection->id;
//                        $newInstructor->save();
//                    }
                }
            }
            return "Good";
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
    public function dataFormatSection(array $request, Section $section):object|null
    {
        $section->status = $request['status'];
        $section->term_id = $request['term_id'];
        $section->caps = $request['caps'];
        $section->course_id = $request['course_id'];
        $section->session_id = $request['session_id'];
        $section->cap = $request['cap'];
        $section->instructor_mode_id = $request['instructor_mode_id'];
        $section->campus_id = $request['campus_id'];
        $section->starting_date = $request['starting_date'];
        $section->ending_date = $request['ending_date'];
        $section->program_id = $request['program_id'];
        $section->cohorts = $request['cohorts'];
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
            $meetingPattern->hour = $planning['hour'];
            $meetingPattern->section_id = $sectionId;
            $meetingPattern->room_id = $planning['room_id'];
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
    public function updateMeetingInstructor($request, $id): void
    {
        try {
        $arrayInstructorIds = [];
        $arrayMeetingPatternIds = [];
            $meetingPatterns = $this->dataFormatMeetingPattern($request,$id);
            foreach ($meetingPatterns as $item){
                $item->save();
                $arrayMeetingPatternIds[] = $item->id;
            }
            $instructors = $this->dataFormatInstructor($request);
            foreach ($instructors as $item){
                $item->save();
                $arrayInstructorIds[] = $item->id;
            }
            foreach ($arrayMeetingPatternIds as $meetingPatternId){
                $meetingPattern = MeetingPattern::find($meetingPatternId);
                $meetingPattern->instructors()->attach($arrayInstructorIds);
            }

        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }
}
