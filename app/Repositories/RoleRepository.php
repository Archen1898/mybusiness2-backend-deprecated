<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Models\Role;
use App\Interfaces\CrudInterface;
use App\Exceptions\ResourceNotFoundException;


class RoleRepository implements CrudInterface
{

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $roles =  Role::orderBy('name', 'desc')->get();
            if ($roles->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.role.exceptionNotFoundAll'));
            }
            return $roles;
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
            $role = Role::find($id);
            if (!$role){
                throw new ResourceNotFoundException(trans('messages.role.exceptionNotFoundById'));
            }
            return $role;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): object|null
    {
        try {
            return Role::create($this->dataFormat($request,"create"));
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, array $request): object|null
    {
        try {
            $role= $this->viewById($id);
            if (!$role){
                throw new ResourceNotFoundException(trans('messages.role.exceptionNotFoundById'));
            }
            $role->update($this->dataFormat($request));
            return $role;
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
            $role = $this->viewById($id);
            if(!$role){
                throw new ResourceNotFoundException(trans('messages.role.exceptionNotFoundById'));
            }
            $role->delete();
            return $role;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $data,string $type = null): array
    {
        if ($type){
            return [
                'name'=>$data['name'],
                'guard_name'=>$data['guard_name'],
                'created_at'=>Carbon::now()->format('m/d/y h:i:s'),
                'updated_at'=>null,
            ];
        }
        return [
            'name'=>$data['name'],
            'guard_name'=>$data['guard_name'],
            'created_at'=>$data['created_at'],
            'updated_at'=>Carbon::now()->format('m/d/y h:i:s'),
        ];
    }
}
