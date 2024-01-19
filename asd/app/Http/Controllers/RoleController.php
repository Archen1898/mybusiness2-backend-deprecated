<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Exception;

//LOCAL IMPORT
use App\Traits\ResponseTraits;
use App\Repositories\RoleRepository;
use App\Http\Requests\RoleRequest;


class RoleController extends Controller
{
    protected RoleRepository $roleRepository;
    use ResponseTraits;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/roles/index",
     *     tags={"Roles"},
     *     summary="Get all roles",
     *     operationId="indexRoles",
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
    public function indexRoles(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Roles successfully fetched.', $this->roleRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, 'Something wrong happened, please try another time', [], $exception->getMessage());
        }
    }

    /**
     * * Get program grouping by ID
     * @OA\Get(
     *     path="/api/role/{id}",
     *     tags={"Roles"},
     *     operationId="showRole",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="BF9E2CB2-9599-4DCF-A3C8-96CEC471E9F0",
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
    public function showRole(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Role fetched successfully.', $this->roleRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, 'Something wrong happened, please try another time', [], $exception->getMessage());
        }
    }

    /**
     * Create role
     * @OA\Post (
     *     path="/api/role/add",
     *     tags={"Roles"},
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
     *                     "name":"Administrator",
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
    public function addRole(RoleRequest $request):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Role created successfully.', $this->roleRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, 'Something wrong happened, please try another time', [], $exception->getMessage());
        }
    }

    /**
     * Update role
     * @OA\Put (
     *     path="/api/role/update/{id}",
     *     tags={"Roles"},
     *     operationId="updateRole",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="String ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="BF9E2CB2-9599-4DCF-A3C8-96CEC471E9F0",
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
     *                     "name":"Administrator",
     *                     "guard_name":"api",
     *                     "created_at":"08/28/2023",
     *                     "updated_at":"08/28/2023"
     *                }
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
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function updateRole(string $id,RoleRequest $request):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Role updated successfully.', $this->roleRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, 'Something wrong happened, please try another time', [], $exception->getMessage());
        }
    }

    /**
     * Delete role
     * @OA\Delete(
     *     path="/api/role/delete/{id}",
     *     tags={"Roles"},
     *     operationId="deleteRole",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="BF9E2CB2-9599-4DCF-A3C8-96CEC471E9F0",
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
    public function deleteRole(string $id):JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Role deleted successfully.', $this->roleRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, 'Something wrong happened, please try another time', [], $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/roles/total",
     *     tags={"Roles"},
     *     summary="Obtain by role the user number and their avatars",
     *     operationId="getTotalUserRoleAvatars",
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
    public function getTotalUserRoleAvatars():JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Role deleted successfully.', $this->roleRepository->totalUserRoleAvatars(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, 'aaaa', [], $exception->getMessage());
        }
    }

}
