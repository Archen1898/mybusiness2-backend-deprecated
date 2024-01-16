<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use App\Http\Requests\RoleHasPermissionRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

//LOCAL IMPORT
use App\Traits\ResponseTraits;
use App\Repositories\RoleHasPermissionRepository;

class RoleHasPermissionController extends Controller
{
    protected RoleHasPermissionRepository $roleHasPermissionRepository;
    use ResponseTraits;

    public function __construct(RoleHasPermissionRepository $roleHasPermissionRepository)
    {
        $this->roleHasPermissionRepository = $roleHasPermissionRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/role_permission/index",
     *     tags={"Role has permissions"},
     *     summary="Get all roles and permissions",
     *     operationId="indexRoleHasPermission",
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
    public function indexRoleHasPermission(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Roles and Permission successfully fetched.', $this->roleHasPermissionRepository->viewAllRolesPermission()->original, null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get permissions by role ID
     * @OA\Get(
     *     path="/api/role_permission/{id}",
     *     tags={"Role has permissions"},
     *     operationId="showPermissionsByRoleId",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="14ee4ec5-4b4d-4f26-aaa5-c6adf6b72cd9",
     *             type="uuid",
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
    public function showPermissionsByRoleId(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permission by Role Id successfully fetched.', $this->roleHasPermissionRepository->viewPermissionsByRoleId($id)->original, null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Assign permissions to role by role id
     * @OA\Put (
     *     path="/api/role_permission/add/{id}",
     *     tags={"Role has permissions"},
     *     operationId="assignPermissionToRoleByRoleId",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="14ee4ec5-4b4d-4f26-aaa5-c6adf6b72cd9",
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
     * @param RoleHasPermissionRequest $request
     * @return JsonResponse
     */
    public function assignPermissionToRoleByRoleId(RoleHasPermissionRequest $request,string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permissions successfully aggregated.', $this->roleHasPermissionRepository->assignPermissionToRoleByRoleId($request,$id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete permissions to role by role id
     * @OA\Delete (
     *     path="/api/role_permission/delete/{id}",
     *     tags={"Role has permissions"},
     *     operationId="deletePermissionToRoleByRoleId",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="14ee4ec5-4b4d-4f26-aaa5-c6adf6b72cd9",
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
     * @param RoleHasPermissionRequest $request
     * @return JsonResponse
     */
    public function deletePermissionToRoleByRoleId(RoleHasPermissionRequest $request,string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permissions successfully revoked.', $this->roleHasPermissionRepository->deletePermissionToRoleByRoleId($request,$id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
