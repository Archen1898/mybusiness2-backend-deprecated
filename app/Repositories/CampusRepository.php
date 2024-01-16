<?php

namespace App\Repositories;

//GLOBAL IMPORT
use ErrorException;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Campus;
use App\Exceptions\ResourceNotFoundException;
class CampusRepository implements CrudInterface,ActiveInterface
{
    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $campus = Campus::where('gn.campuses.active','=',$status)->get();
            if ($campus->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.campus.exceptionNotFoundByStatus'));
            }
            return $campus;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $campus = Campus::orderBy('name', 'desc')->get();
            if ($campus->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.campus.exceptionNotFoundAll'));
            }
            return $campus;
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
            $campus = Campus::find($id);
            if (!$campus){
                throw new ResourceNotFoundException(trans('messages.campus.exceptionNotFoundById'));
            }
            return $campus;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $exception){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): ?object
    {
        try {
            $campus = new Campus();
            $newCampus = $this->dataFormat($request,$campus);
            $newCampus->save();
            return $newCampus;
        }  catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $campus = $this->viewById($id);
            if (!$campus){
                throw new ResourceNotFoundException(trans('messages.campus.exceptionNotFoundById'));
            }
            $newCampus = $this->dataFormat($request,$campus);
            $newCampus->update();
            return $newCampus;
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
            $campus = $this->viewById($id);
            if (!$campus){
                throw new ResourceNotFoundException(trans('messages.campus.exceptionNotFoundById'));
            }
            $campus->delete();
            return $campus;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     */
    public function dataFormat(array $request, Campus $campus):object|null
    {
        $campus->code = $request['code'];
        $campus->name = $request['name'];
        $campus->active = $request['active'];
        return $campus;
    }
}
