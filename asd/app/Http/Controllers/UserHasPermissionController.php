<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use App\Http\Requests\UserHasPermissionRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
Use Exception;

//LOCAL IMPORT
use App\Traits\ResponseTraits;
use App\Repositories\UserHasPermissionRepository;

class UserHasPermissionController extends Controller
{
    protected UserHasPermissionRepository $userHasPermissionRepository;
    use ResponseTraits;

    public function __construct(UserHasPermissionRepository $userHasPermissionRepository)
    {
        $this->userHasPermissionRepository = $userHasPermissionRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/user_permission/index",
     *     tags={"User has permission"},
     *     summary="Get all user and permissions",
     *     operationId="indexUserHasPermission",
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
    public function indexUserHasPermission(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User permissions successfully fetched.', $this->userHasPermissionRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get permissions by user ID
     * @OA\Get(
     *     path="/api/user_permission/{id}",
     *     tags={"User has permission"},
     *     operationId="showPermissionsByUserId",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="bde0046b-83c0-4fda-9a81-05a4faf06b79",
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
    public function showPermissionsByUserId(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'User permissions successfully fetched.', $this->userHasPermissionRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Assign permissions to user by user id
     * @OA\Put (
     *     path="/api/user_permission/add/{id}",
     *     tags={"User has permission"},
     *     operationId="assignPermissionToUserById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="bde0046b-83c0-4fda-9a81-05a4faf06b79",
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
     *                          property="permissions",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"List of Program groupings.","Search program grouping by ID."}),
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
     * @param UserHasPermissionRequest $request
     * @return JsonResponse
     */
    public function assignPermissionToUserById(UserHasPermissionRequest $request,string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Roles successfully aggregated.', $this->userHasPermissionRepository->assignPermissions($request,$id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Revoke permissions to user by user id
     * @OA\Put (
     *     path="/api/user_permission/delete/{id}",
     *     tags={"User has permission"},
     *     operationId="deletePermissionToUserById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="bde0046b-83c0-4fda-9a81-05a4faf06b79",
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
     *                          property="permissions",
     *                          type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items(type="string", format="string", example={"List of Program groupings.","Search program grouping by ID."}),
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
     * @param UserHasPermissionRequest $request
     * @return JsonResponse
     */
    public function deletePermissionToUserById(UserHasPermissionRequest $request,string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permissions successfully revoked.', $this->userHasPermissionRepository->deletePermissions($request,$id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
