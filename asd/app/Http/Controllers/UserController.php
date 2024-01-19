<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Traits\ResponseTraits;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT


class UserController extends Controller
{
    protected UserRepository $userRepository;
    use ResponseTraits;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/user/index",
     *     tags={"User"},
     *     summary="Get all user with roles and permission",
     *     operationId="indexUsers",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function indexUser(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Users successfully fetched.', $this->userRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get user with roles and permission by user id
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     operationId="showUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1268A938-37DE-48C6-99C2-99840575104C",
     *             type="uuid"
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     *
     * @param string $id
     * @return JsonResponse
     */
    public function showUser(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User successfully fetched.', $this->userRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create user
     * @OA\Post (
     *     path="/api/user/add",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="user_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="first_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="last_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="middle_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="panther_id",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="avatar",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="instructor",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="student",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="department_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="roles",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"Instructor","Secretary."}),
     *                      ),
     *                      @OA\Property(
     *                          property="permissions",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"Delete a course.","List of program levels."}),
     *                      )
     *                 ),
     *                 example={
     *                      "name": "Demo",
     *                      "user_name": "demo",
     *                      "first_name": "first",
     *                      "last_name": "last",
     *                      "middle_name": "demos",
     *                      "email": "demo@fiu.edu",
     *                      "panther_id": "6447394",
     *                      "avatar": "./../avatar",
     *                      "instructor": 1,
     *                      "student": 1,
     *                      "email_verified_at": "",
     *                      "password":"123",
     *                      "active": "1",
     *                      "created_at": "2024-01-10T22:18:54.927000Z",
     *                      "updated_at": "2024-01-10T22:18:54.927000Z",
     *                      "department_id": null,
     *                      "roles": {"Instructor","Secretary."},
     *                      "permissions": {"Delete a course.","List of program levels."}
     *                }
     *             )
     *         )
     *      ),
     *     security={{"bearer":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      )
     * )
     */
    public function createUser(UserRequest $request):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User successfully created.', $this->userRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST,  $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update user
     * @OA\Put (
     *     path="/api/user/update/{id}",
     *     tags={"User"},
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="String ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="D9B7E73F-9E5B-4884-AF72-1FE5934A6E3A",
     *             type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="user_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="first_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="last_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="middle_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="panther_id",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="avatar",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="instructor",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="student",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="department_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="roles",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"Instructor","Secretary."}),
     *                      ),
     *                      @OA\Property(
     *                          property="permissions",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"Delete a course.","List of program levels."}),
     *                      )
     *                 ),
     *                 example={
     *                      "name": "Demo",
     *                      "user_name": "demo",
     *                      "first_name": "first",
     *                      "last_name": "last",
     *                      "middle_name": "demos",
     *                      "email": "demo@fiu.edu",
     *                      "panther_id": "6447394",
     *                      "avatar": "./../avatar",
     *                      "instructor": 1,
     *                      "student": 1,
     *                      "email_verified_at": "",
     *                      "password":"123",
     *                      "active": "1",
     *                      "created_at": "2024-01-10T22:18:54.927000Z",
     *                      "updated_at": "2024-01-10T22:18:54.927000Z",
     *                      "department_id": null,
     *                      "roles": {"Instructor","Secretary."},
     *                      "permissions": {"Delete a course.","List of program levels."}
     *                }
     *             )
     *         )
     *      ),
     *     security={{"bearer":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      )
     * )
     *
     * *
     * @param string $id
     * @param TermRequest $request
     * @return JsonResponse
     */
    public function updateUser(string $id, UserRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User successfully updated.', $this->userRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    /**
     * Delete user
     * @OA\Delete(
     *     path="/api/user/delete/{id}",
     *     tags={"User"},
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="String ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="0C6A36BA-10E4-438F-BA86-0D5B68A2BB15",
     *             type="string",
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     *
     * @param string $id
     * @return JsonResponse
     */
    public function deleteUser(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User successfully disabled.', $this->userRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
