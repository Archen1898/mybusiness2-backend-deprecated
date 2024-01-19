<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Models\Permission;
use App\Exceptions\ResourceNotFoundException;


class PermissionRepository implements CrudInterface
{

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $permission = Permission::orderBy('name', 'desc')->get();
            if ($permission->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.permission.exceptionNotFoundAll'));
            }
            return $permission;
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
            $permission = Permission::find($id);
            if (!$permission){
                throw new ResourceNotFoundException(trans('messages.permission.exceptionNotFoundById'));
            }
            return $permission;
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
            return Permission::create($this->dataFormat($request,"create"));
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
            $permission= $this->viewById($id);
            if (!$permission){
                throw new ResourceNotFoundException(trans('messages.permission.exceptionNotFoundById'));
            }
            $permission->update($this->dataFormat($request));
            return $permission;
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
            $permission = $this->viewById($id);
            if (!$permission){
                throw new ResourceNotFoundException(trans('messages.permission.exceptionNotFoundById'));
            }
            $permission->delete();
            return $permission;
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
