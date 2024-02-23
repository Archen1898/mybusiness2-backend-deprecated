<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Models\AccessPeriod;
use App\Exceptions\ResourceNotFoundException;
class AccessPeriodRepository implements CrudInterface
{
    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $accessPeriods = AccessPeriod::with('term')->orderBy('term_id','desc')->get();
            if ($accessPeriods->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.accessPeriod.exceptionNotFoundAll'));
            }
            return $accessPeriods;
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
            $accessPeriod = AccessPeriod::find($id);
            if (!$accessPeriod){
                throw new ResourceNotFoundException(trans('messages.accessPeriod.exceptionNotFoundById'));
            }
            return $accessPeriod;
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
            $accessPeriod = new AccessPeriod();
            $newAccessPeriod = $this->dataFormat($request,$accessPeriod);
            $newAccessPeriod->save();
            return $newAccessPeriod;
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
            $accessPeriod = $this->viewById($id);
            if (!$accessPeriod){
                throw new ResourceNotFoundException(trans('messages.accessPeriod.exceptionNotFoundById'));
            }
            $newAccessPeriod = $this->dataFormat($request,$accessPeriod);
            $newAccessPeriod->update();
            return $newAccessPeriod;
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
            $accessPeriod = $this->viewById($id);
            if (!$accessPeriod){
                throw new ResourceNotFoundException(trans('messages.accessPeriod.exceptionNotFoundById'));
            }
            $accessPeriod->delete();
            return $accessPeriod;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, AccessPeriod $accessPeriod):object|null
    {
        $accessPeriod->term_id = $request['term_id'];
        $accessPeriod->admin_beginning_date = $request['admin_beginning_date'];
        $accessPeriod->admin_ending_date = $request['admin_ending_date'];
        $accessPeriod->admin_cancel_section_date = $request['admin_cancel_section_date'];
        $accessPeriod->depart_beginning_date = $request['depart_beginning_date'];
        $accessPeriod->depart_ending_date = $request['depart_ending_date'];
        return $accessPeriod;
    }
}
