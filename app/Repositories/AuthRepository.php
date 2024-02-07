<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

//LOCAL IMPORT
use App\Models\User;
use App\Http\Requests\LoginRequest;


class AuthRepository
{
    /**
     * @throws Exception
     */

    public function login(array $data): array
    {
        $user = $this->getUserByEmail($data['email']);
        if (!$user) {
            throw new Exception("Sorry, user does not exist.", response::HTTP_NOT_FOUND);
        }
        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, password does not match.", response::HTTP_UNAUTHORIZED);
        }
        $permissions = $user->getPermissionNames();
        $roles = $user->getRoleNames()->first();

        $tokenInstance = $this->createAuthToken($user);
        return $this->getAuthData($user, $tokenInstance, $roles, $permissions);
    }

    /**
     * @throws Exception
     */
    public function register(array $data): array
    {
        $user = User::create($this->dataForRegister($data));
        if (!$user) {
            throw new Exception("Sorry, user does not registered. Please try again.", response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $tokenInstance = $this->createAuthToken($user);
        return $this->getAuthData($user, $tokenInstance,null,null);
    }
    /**
     * @throws Exception
     */
    public function profile():?Object
    {
        $data = Auth::guard()->user();
        if (!$data){
            throw new Exception("Sorry, something is wrong. Please try again.", response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $data;
    }

    /**
     * @throws Exception
     */
    public function getUserByEmail(string $email): ?User
    {
        try {
            return User::where('email', $email)
                ->where('active','=', true)
                ->first();
        }catch (Exception $exception){
//            throw new Exception("Disabled user!", response::HTTP_LOCKED);
            throw new Exception($exception->getMessage(), response::HTTP_LOCKED);
        }

    }

    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    public function createAuthToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('authToken');
    }

    public function getAuthData(User $user, PersonalAccessTokenResult $tokenInstance, $roles, $permission): array
    {
        return [
            'user'         => $user,
            'roles'        => $roles,
            'permissions'  => $permission,
            'access_token' => $tokenInstance->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString()
        ];
    }
    public function dataForRegister(array $data): array
    {
        return [
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'panther_id'=>$data['panther_id'],
            'avatar'=>$data['avatar'],
            'active'=>$data['active']
        ];
    }

    /**
     * @throws Exception
     */
    public function verifyAuthenticatedToken($request)
    {
        $user = User::where('id', optional(Auth::guard('api')->user())->id)->first();
        if (!$user){
            throw new Exception("Sorry, something is wrong. Please try again.", response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $roles = $user->getRoleNames();
        if ($roles){
            $user->role= $roles[0];
        }
        $permissions = $user->getPermissionNames();
        $user->permissions = $permissions;
        $user->accessToken = str_replace('Bearer ', '', $request->header('Authorization'));
        return $user;
    }

}

