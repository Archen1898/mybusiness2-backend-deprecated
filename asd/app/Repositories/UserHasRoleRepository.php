<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

//LOCAL IMPORT
use App\Models\User;
use App\Models\Role;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\UserHasRoleRequest;


class UserHasRoleRepository
{

    /**
     * @throws Exception
     */
    public function viewAll(): JsonResponse
    {
        try {
            $users = User::all();
            $roles = Role::all();
            if (!$users || !$roles) {
                throw new ResourceNotFoundException(trans('messages.userHasRole.exceptionNotFoundAll'));
            }
            return response()->json([$users, $roles]);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById(string $id): JsonResponse
    {
        try {
            $roles = $this->viewUserById($id)->getRoleNames();
            if (!$roles){
                throw new ResourceNotFoundException(trans('messages.userHasRole.exceptionNotFoundById'));
            }
            return response()->json($roles);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function assignRoles(UserHasRoleRequest $request, string $id): string
    {
        try {
            if(!$this->viewUserById($id)->syncRoles($request['roles'])){
                throw new ResourceNotFoundException(trans('messages.userHasRole.syncRolesWrong'));
            }
            return trans('messages.userHasRole.syncRolesOk');
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function deleteRoles(UserHasRoleRequest $request, string $id): string
    {
        try {
            $value = "";
            foreach ($request['roles'] as $role) {
                if(!$this->viewUserById($id)->removeRole($role)){
                    throw new ResourceNotFoundException(trans('messages.userHasRole.revokeRolesWrong'));
                }
                $value = trans('messages.userHasRole.revokeRolesOk');
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
                throw new ResourceNotFoundException(trans('messages.userHasRole.exceptionNotFoundById'));
            }
            return $user;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
