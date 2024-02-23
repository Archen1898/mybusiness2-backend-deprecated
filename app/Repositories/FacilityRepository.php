<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Facility;
use App\Exceptions\ResourceNotFoundException;

class FacilityRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $facilities = Facility::where('gn.facilities.active','=',$status)->get();
            if ($facilities->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.facility.exceptionNotFoundByStatus'));
            }
            return $facilities;
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
            $facilities = Facility::with('building')->orderBy('name','desc')->get();
            if ($facilities->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.facility.exceptionNotFoundAll'));
            }
            return $facilities;
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
            $facility = Facility::find($id);
            if (!$facility){
                throw new ResourceNotFoundException(trans('messages.facility.exceptionNotFoundById'));
            }
            return $facility;
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
            $facility = new Facility();
            $newFacility = $this->dataFormat($request,$facility);
            $newFacility->save();
            return $newFacility;
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
            $facility = $this->viewById($id);
            if (!$facility){
                throw new ResourceNotFoundException(trans('messages.facility.exceptionNotFoundById'));
            }
            $newFacility = $this->dataFormat($request,$facility);
            $newFacility->update();
            return $newFacility;
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
            $facility = $this->viewById($id);
            if (!$facility){
                throw new ResourceNotFoundException(trans('messages.facility.exceptionNotFoundById'));
            }
            $facility->delete();
            return $facility;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, Facility $facility):object|null
    {
        $facility->name = $request['name'];
        $facility->capacity = $request['capacity'];
        $facility->building_id = $request['building_id'];
        $facility->active = $request['active'];
        return $facility;
    }
}
