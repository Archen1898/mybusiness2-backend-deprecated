<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Carbon\Carbon;
use Exception;
use ErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Models\User;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\RequestException;


class UserRepository
{

    /**
     * @throws Exception
     */
    public function viewAll(): Collection|array
    {
        try {
            $users = User::with('roles','permissions')->get();
            if (!$users){
                throw new ResourceNotFoundException(trans('messages.user.exceptionNotFoundAll'));
            }
            return $users;
        } catch (ResourceNotFoundException $e){
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById($id): Model|Collection|Builder|array
    {
        try {
            $user = User::with('roles','permissions')->find($id);
            if(!$user){
                throw new ResourceNotFoundException(trans('messages.user.exceptionNotFoundById'));
            }
            return $user;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): array|Builder|Collection|Model
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $userNew = $this->dataFormat($request,$user);
            $userNew->save();
            DB::commit();
            return $this->viewById($userNew->id);
        } catch (RoleDoesNotExist|PermissionDoesNotExist $e){
            throw new Exception($e->getMessage(), response::HTTP_NOT_FOUND);
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            DB::rollBack();
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, array $request): object|null
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            if(!$user){
                throw new ResourceNotFoundException(trans('messages.user.exceptionNotFoundById'));
            }
            $userNew = $this->dataFormat($request,$user);
            $userNew->update();
            DB::commit();
            return $this->viewById($userNew->id);
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (RoleDoesNotExist|PermissionDoesNotExist $e){
            throw new Exception($e->getMessage(), response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            DB::rollBack();
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        try {
            $user = User::find($id);
            if(!$user){
                throw new ResourceNotFoundException(trans('messages.user.exceptionNotFoundById'));
            }
            $user->active = 0;
            $user->update();
            return $user;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function dataFormat(array $request, User $user): User
    {
        try {
            $user->name = $request['name'];
            $user->user_name = $request['user_name'];
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->middle_name = $request['middle_name'];
            $user->email = $request['email'];
            $user->panther_id = $request['panther_id'];
            $user->avatar = $request['avatar'];
            $user->instructor = $request['instructor'];
            $user->student = $request['student'];
            $user->password = Hash::make($request['password']);
            $user->created_at= Carbon::now()->format('m/d/y h:i:s');
            $user->updated_at= $request['updated_at'];
            $user->active = $request['active'];
            $user->department_id = $request['department_id'];
            $user->address = $request['address'];
            $user->phone = $request['phone'];
            $user->job_title = $request['job_title'];
            $user->work_phone = $request['work_phone'];
            $user->location = $request['location'];
            if(count($request['roles'])>0){
                $user->syncRoles($request['roles']);
            }
            if (count($request['permissions'])>0){
                $user->syncPermissions($request['permissions']);
            }
            return $user;
        } catch (RequestException $e){
            throw new RequestException($e->getMessage());
        }

    }
}
