<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\College;
use App\Exceptions\ResourceNotFoundException;

class CollegeRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $colleges = College::where('gn.colleges.active','=',$status)->get();
            if ($colleges->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundByStatus'));
            }
            return $colleges;
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
            $colleges = College::orderBy('name','desc')->get();
            if ($colleges->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundAll'));
            }
            return $colleges;
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
            $college = College::find($id);
            if (!$college){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundById'));
            }
            return $college;
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
            $college = new College();
            $newCollege = $this->dataFormat($request,$college);
            $newCollege->save();
            return $newCollege;
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
            $college = $this->viewById($id);
            if (!$college){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundById'));
            }
            $newCollege = $this->dataFormat($request,$college);
            $newCollege->update();
            return $newCollege;
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
            $college = $this->viewById($id);
            if (!$college){
                throw new ResourceNotFoundException(trans('messages.college.exceptionNotFoundById'));
            }
            $college->delete();
            return $college;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function dataFormat(array $request, College $college):object|null
    {
        $college->code = $request['code'];
        $college->name = $request['name'];
        $college->url = $request['url'];
        $college->active = $request['active'];
        return $college;
    }
}
