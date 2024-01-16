<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\UserHasRoleRequest;
use App\Repositories\UserHasRoleRepository;
use App\Traits\ResponseTraits;


class UserHasRoleController extends Controller
{
    protected UserHasRoleRepository $userHasRoleRepository;
    use ResponseTraits;

    public function __construct(UserHasRoleRepository $userHasRoleRepository)
    {
        $this->userHasRoleRepository = $userHasRoleRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/user_role/index",
     *     tags={"User has role"},
     *     summary="Get all users and roles",
     *     operationId="indexUserHasRole",
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
    public function indexUserHasRole(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Users and Roles successfully fetched.', $this->userHasRoleRepository->viewAll()->original, null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get roles by user ID
     * @OA\Get(
     *     path="/api/user_role/{id}",
     *     tags={"User has role"},
     *     operationId="showUserHasRole",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="9204c379-79ac-401a-b617-ba27cb36a556",
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
    public function showUserHasRole(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User roles successfully fetched.', $this->userHasRoleRepository->viewById($id)->original, null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Assign role
     * @OA\Put (
     *     path="/api/user_role/add/{id}",
     *     tags={"User has role"},
     *     operationId="assignUserHasRole",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1268a938-37de-48c6-99c2-99840575104c",
     *             type="uuid",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="roles",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"Admin","Secretary","Professor"}),
     *                      )
     *                 )
     *             )
     *         )
     *      ),
     *      security={{"bearer":{}}},
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
     * @param UserHasRoleRequest $request
     * @return JsonResponse
     */
    public function assignUserHasRole(UserHasRoleRequest $request,string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Roles successfully aggregated.', $this->userHasRoleRepository->assignRoles($request,$id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Revoke role
     * @OA\Delete (
     *     path="/api/user_role/delete/{id}",
     *     tags={"User has role"},
     *     operationId="deleteUserHasRole",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1268a938-37de-48c6-99c2-99840575104c",
     *             type="uuid",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="roles",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"Admin","Secretary","Professor"}),
     *                      )
     *                 )
     *             )
     *         )
     *      ),
     *      security={{"bearer":{}}},
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
     * @param UserHasRoleRequest $request
     * @return JsonResponse
     */
    public function deleteUserHasRole(UserHasRoleRequest $request,string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Roles successfully revoked.', $this->userHasRoleRepository->deleteRoles($request,$id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
