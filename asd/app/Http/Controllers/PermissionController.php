<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Exception;

//LOCAL IMPORT
use App\Traits\ResponseTraits;
use App\Repositories\PermissionRepository;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    protected PermissionRepository $permissionRepository;
    use ResponseTraits;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/permission/index",
     *     tags={"Permission"},
     *     summary="Get all permissions",
     *     operationId="indexPermissions",
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
    public function indexPermissions(): JsonResponse
    {
//        $this->authorize("List of permissions.");
        try {
            return $this->response(Response::HTTP_OK, 'Permissions successfully fetched.', $this->permissionRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get permission by ID
     * @OA\Get(
     *     path="/api/permission/{id}",
     *     tags={"Permission"},
     *     operationId="showPermission",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Int ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="27E6947C-92E1-4D6E-BE78-D9A15E7B75CF",
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
    public function showPermission(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permission successfully fetched.', $this->permissionRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create permission
     * @OA\Post (
     *     path="/api/permission/add",
     *     tags={"Permission"},
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
     *                          property="guard_name",
     *                          type="string"
     *                      ),
     *                     @OA\Property(
     *                          property="created_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="date"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"List of Program groupings.",
     *                     "guard_name":"api",
     *                     "created_at":"08/28/2023",
     *                     "updated_at":"08/28/2023"
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
    public function addPermission(PermissionRequest $request):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permission successfully created.', $this->permissionRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST,  $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update permission
     * @OA\Put (
     *     path="/api/permission/update/{id}",
     *     tags={"Permission"},
     *     operationId="updatePermission",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="String ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="8b6cfc16-78d4-41fb-a8bc-b8694a6b52eb",
     *             type="uuid",
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
     *                          property="guard_name",
     *                          type="string"
     *                      ),
     *                     @OA\Property(
     *                          property="created_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="date"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"List of Program groupings.",
     *                     "guard_name":"api",
     *                     "created_at":"08/28/2023",
     *                     "updated_at":"08/28/2023"
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
     * @param PermissionRequest $request
     * @return JsonResponse
     */
    public function updatePermission(string $id,PermissionRequest $request):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permission successfully updated.', $this->permissionRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete permission
     * @OA\Delete(
     *     path="/api/permission/delete/{id}",
     *     tags={"Permission"},
     *     operationId="deletePermission",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="8b6cfc16-78d4-41fb-a8bc-b8694a6b52eb",
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
    public function deletePermission(string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Permission successfully deleted.', $this->permissionRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
