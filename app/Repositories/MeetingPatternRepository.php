<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Models\MeetingPattern;
use App\Exceptions\ResourceNotFoundException;

class MeetingPatternRepository
{
    /**
     * @throws Exception
     */
    public function viewAll(): Collection
    {
        try {
            $meetingPatterns = MeetingPattern::all();
            if ($meetingPatterns->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.meetingPattern.exceptionNotFoundAll'));
            }
            return $meetingPatterns;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewByDayHourRoomId($day,$hour,$room_id)
    {
        try {
            $meetingPattern = MeetingPattern::where('day',$day)->where('hour',$hour)->where('room_id',$room_id)->first();
            if (!$meetingPattern){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundByDayHourRoom'));
            }
            return $meetingPattern;
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
        try {
            $meeting = new MeetingPattern();
            $newMeeting = $this->dataFormat($request,$meeting);
            $newMeeting->save();
            return $newMeeting;
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($day,$hour,$room_id,$request)
    {
        try {
            $meetingPattern = $this->viewById($day,$hour,$room_id);
            if (!$meetingPattern){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundByDayHourRoom'));
            }
            $meetingAux = $this->dataFormat($request,$meetingPattern);
            $meetingAux->save();
            return $meetingAux;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($day,$hour,$room_id): object|null
    {
        try {

            $meetingPattern = $this->viewById($day,$hour,$room_id);
            if (!$meetingPattern){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundByDayHourRoom'));
            }
            $meetingPattern->delete();
            return $meetingPattern;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, MeetingPattern $meeting):object|null
    {
        $meeting->day=$request['day'];
        $meeting->hour=$request['hour'];
        $meeting->room_id=$request['room_id'];
        return $meeting;
    }
}
