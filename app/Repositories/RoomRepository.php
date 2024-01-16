<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Room;
use App\Exceptions\ResourceNotFoundException;

class RoomRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $rooms = Room::where('gn.rooms.active','=',$status)->get();
            if ($rooms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.room.exceptionNotFoundByStatus'));
            }
            return $rooms;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $rooms = Room::orderBy('name','desc')->get();
            if ($rooms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.room.exceptionNotFoundAll'));
            }
            return $rooms;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById($id)
    {
        try {
            $room = Room::find($id);
            if (!$room){
                throw new ResourceNotFoundException(trans('messages.room.exceptionNotFoundById'));
            }
            return $room;
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
            $room = new Room();
            $newRoom = $this->dataFormat($request,$room);
            $newRoom->save();
            return $newRoom;
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $room = $this->viewById($id);
            if (!$room){
                throw new ResourceNotFoundException(trans('messages.room.exceptionNotFoundById'));
            }
            $newRoom = $this->dataFormat($request,$room);
            $newRoom->update();
            return $newRoom;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        try {
            $room = $this->viewById($id);
            if (!$room){
                throw new ResourceNotFoundException(trans('messages.room.exceptionNotFoundById'));
            }
            $room->delete();
            return $room;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, Room $room):object|null
    {
        $room->name = $request['name'];
        $room->capacity = $request['capacity'];
        $room->building_id = $request['building_id'];
        $room->active = $request['active'];
        return $room;
    }
}
