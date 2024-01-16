<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

//LOCAL IMPORT
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\RoleHasPermissionRequest;
use App\Exceptions\ResourceNotFoundException;

class  RoleHasPermissionRepository
{
    /**
     * @throws Exception
     */
    public function viewAllRolesPermission(): JsonResponse
    {
        try {
            $role = Role::all();
            $permission = Permission::all();
            if (!$role || !$permission) {
                throw new ResourceNotFoundException(trans('messages.roleHasPermission.exceptionNotFoundAll'));
            }
            return response()->json([$role, $permission]);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewPermissionsByRoleId(string $id): JsonResponse
    {
        try {
            $permission = $this->viewRoleById($id)->getPermissionNames();
            if (!$permission) {
                throw new ResourceNotFoundException(trans('messages.roleHasPermission.exceptionNotFoundById'));
            }
            return response()->json($permission);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function assignPermissionToRoleByRoleId(RoleHasPermissionRequest $request, $id): string
    {
        try {
            if(!$this->viewRoleById($id)->syncPermissions($request['permissions'])){
                throw new ResourceNotFoundException(trans('messages.roleHasPermission.syncPermissionsWrong'));
            }
            return trans('messages.roleHasPermission.syncPermissionsOk');
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function deletePermissionToRoleByRoleId(RoleHasPermissionRequest $request, $id): string
    {
        try {
            if(!$this->viewRoleById($id)->revokePermissionTo($request['permissions'])){
                throw new ResourceNotFoundException(trans('messages.roleHasPermission.revokePermissionsWrong'));
            }
            return trans('messages.roleHasPermission.revokePermissionsOk');
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewRoleById(string $id):?object
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                throw new ResourceNotFoundException(trans('messages.roleHasPermission.exceptionNotFoundById'));
            }
        return $role;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
