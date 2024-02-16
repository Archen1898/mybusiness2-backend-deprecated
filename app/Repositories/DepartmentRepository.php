<?php

namespace App\Repositories;

//GLOBAL IMPORT
use App\Exceptions\ResourceNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Department;

class DepartmentRepository implements CrudInterface,ActiveInterface
{
    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $departments = Department::where('gn.departments.active','=',$status)->get();
            if ($departments->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.department.exceptionNotFoundByStatus'));
            }
            return $departments;
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
            $departments = Department::with('college')->orderBy('name','desc')->get();
            if ($departments->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.department.exceptionNotFoundAll'));
            }
            return $departments;
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
            $department = Department::find($id);
            if (!$department){
                throw new ResourceNotFoundException(trans('messages.department.exceptionNotFoundById'));
            }
            return $department;
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
            $department = new Department();
            $newDepartment = $this->dataFormat($request,$department);
            $newDepartment->save();
            return $newDepartment;
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
            $department = $this->viewById($id);
            if (!$department){
                throw new ResourceNotFoundException(trans('messages.department.exceptionNotFoundById'));
            }
            $newDepartment = $this->dataFormat($request,$department);
            $newDepartment->update();
            return $newDepartment;
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
            $department = $this->viewById($id);
            if (!$department){
                throw new ResourceNotFoundException(trans('messages.department.exceptionNotFoundById'));
            }
            $department->delete();
            return $department;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, Department $department):object|null
    {
        $department->code = $request['code'];
        $department->name = $request['name'];
        $department->description = $request['description'];
        $department->college_id = $request['college_id'];
        $department->active = $request['active'];
        return $department;
    }
}
