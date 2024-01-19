<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

//LOCAL IMPORT
use App\Models\User;
use App\Models\Permission;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\UserHasPermissionRequest;

class UserHasPermissionRepository
{
    /**
     * @throws Exception
     */
    public function viewAll(): JsonResponse
    {
        try {
            $users = User::all();
            $permissions = Permission::all();
            if (!$users || !$permissions) {
                throw new ResourceNotFoundException(trans('messages.userHasPermission.exceptionNotFoundAll'));
            }
            return response()->json([$users, $permissions]);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @throws Exception
     */
    public function viewById($id): JsonResponse
    {
        try {
            $permissions = $this->viewUserById($id)->getDirectPermissions();
            if (!$permissions){
                throw new ResourceNotFoundException(trans('messages.userHasPermission.exceptionNotFoundById'));
            }
            return response()->json($permissions);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function assignPermissions(UserHasPermissionRequest $request, string $id): string
    {
        try {
            if(!$this->viewUserById($id)->syncPermissions($request['permissions'])){
                throw new ResourceNotFoundException(trans('messages.userHasPermission.syncPermissionsWrong'));
            }
            return trans('messages.userHasPermission.syncPermissionsOk');
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function deletePermissions(UserHasPermissionRequest $request, string $id): string
    {
        try {
            $value = "";
            foreach ($request['permissions'] as $role) {
                if(!$this->viewUserById($id)->revokePermissionTo($role)){
                    throw new ResourceNotFoundException(trans('messages.userHasPermission.revokePermissionsWrong'));
                }
                $value =trans('messages.userHasPermission.revokePermissionsOk');
            }
            return $value;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewUserById(string $id):?object
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new ResourceNotFoundException(trans('messages.userHasPermission.exceptionNotFoundById'));
            }
            return $user;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
