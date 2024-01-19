<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Building;
use App\Exceptions\ResourceNotFoundException;

class BuildingRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $buildings = Building::where('gn.buildings.active','=',$status)->get();
            if ($buildings->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.building.exceptionNotFoundByStatus'));
            }
            return $buildings;
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
            $buildings = Building::orderBy('name','desc')->get();
            if ($buildings->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.building.exceptionNotFoundAll'));
            }
            return $buildings;
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
            $building = Building::find($id);
            if (!$building){
                throw new ResourceNotFoundException(trans('messages.building.exceptionNotFoundById'));
            }
            return $building;
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
            $building = new Building();
            $newBuilding = $this->dataFormat($request,$building);
            $newBuilding->save();
            return $newBuilding;
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
            $building = $this->viewById($id);
            if (!$building){
                throw new ResourceNotFoundException(trans('messages.building.exceptionNotFoundById'));
            }
            $newBuilding = $this->dataFormat($request,$building);
            $newBuilding->update();
            return $newBuilding;
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
            $building = $this->viewById($id);
            if (!$building){
                throw new ResourceNotFoundException(trans('messages.building.exceptionNotFoundById'));
            }
            $building->delete();
            return $building;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, Building $building):object|null
    {
        $building->code = $request['code'];
        $building->name = $request['name'];
        $building->campus_id = $request['campus_id'];
        $building->active = $request['active'];
        return $building;
    }
}
