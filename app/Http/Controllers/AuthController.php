<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Http\JsonResponse;
use Exception;

//LOCAL IMPORT
use App\Traits\ResponseTraits;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;


class AuthController extends Controller
{
    use ResponseTraits;
    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @OA\POST(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login",
     *     description="Login to system.",
     *     operationId="login",
     *     @OA\RequestBody(
     *         description="User and password",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="User Email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string"
     *                 ),
     *                 required={"email", "password"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->login($request->all());
            return $this->response(Response::HTTP_OK,"Logged in successfully.",$data,null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_NOT_FOUND, $exception->getMessage(),[],null);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register",
     *     description="Register to system.",
     *     operationId="register",
     *     @OA\RequestBody(
     *         description="Register user",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="User Name",
     *                     type="string",
     *                     example="Salvador Gonzalez"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="User Email",
     *                     type="string",
     *                     example="demo@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string",
     *                     example="12345678"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     description="User confirm password",
     *                     type="string",
     *                     example="12345678"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->register($request->all());
            return $this->response(Response::HTTP_OK,"Registered in successfully.",$data,null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_NOT_FOUND, $exception->getMessage(),[],null);

        }
    }

    /**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Authentication"},
     *     summary="User profile",
     *     description="User profile",
     *     operationId="profile",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated"
     *     )
     * )
     */
    public function profile(): JsonResponse
    {
        try {
            $data = $this->auth->profile();
            return $this->response(Response::HTTP_OK,"User fetched successfully.",$data,null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_NOT_FOUND, $exception->getMessage(),[],null);

        }
    }

    /**
     * @OA\POST(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     description="User logout",
     *     operationId="logout",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::guard()->user()->token()->revoke();
            Auth::guard()->user()->token()->delete();
            return $this->response(Response::HTTP_OK,"User logged out successfully.",[],null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_NOT_FOUND, $exception->getMessage(),[],null);

        }
    }

    public function verifyToken(Request $request): JsonResponse
    {
        try {
//            $token = $request->header('Authorization');
//            $data = $this->auth->verifyAuthenticatedToken($token);
            $data = $this->auth->verifyAuthenticatedToken($request);
            return $this->response(Response::HTTP_OK,"User fetched successfully.",$data,null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_NOT_FOUND, $exception->getMessage(),[],null);
        }
    }
}
