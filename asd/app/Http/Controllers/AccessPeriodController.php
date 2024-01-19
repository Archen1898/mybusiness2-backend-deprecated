<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\AccessPeriodRequest;
use App\Repositories\AccessPeriodRepository;
use App\Traits\ResponseTraits;

class AccessPeriodController extends Controller
{
    protected AccessPeriodRepository $accessPeriodRepository;
    use ResponseTraits;

    public function __construct(AccessPeriodRepository $accessPeriodRepository)
    {
        $this->accessPeriodRepository = $accessPeriodRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/access_period/index",
     *     tags={"Access period"},
     *     summary="Get all access periods",
     *     operationId="indexAccessPeriod",
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
    public function indexAccessPeriod(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Access periods successfully fetched.', $this->accessPeriodRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get access period by ID
     * @OA\Get(
     *     path="/api/access_period/{id}",
     *     tags={"Access period"},
     *     operationId="showAccessPeriod",
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
    public function showAccessPeriod(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Access period successfully fetched.', $this->accessPeriodRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create access period
     * @OA\Post (
     *     path="/api/access_period/add",
     *     tags={"Access period"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="term_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="admin_beginning_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="admin_ending_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="admin_cancel_section_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="depart_beginning_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="depart_ending_date",
     *                          type="date"
     *                      )
     *                 ),
     *                 example={
     *                      "term_id": "e8356132-0e8c-4448-b547-6254094ddd3b",
     *                      "admin_beginning_date": "2010/02/02",
     *                      "admin_ending_date": "2010/02/02",
     *                      "admin_cancel_section_date": "2010/02/02",
     *                      "depart_beginning_date": "2010/02/02",
     *                      "depart_ending_date": "2010/02/02"
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
     */
    public function addAccessPeriod(AccessPeriodRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Access period successfully created.', $this->accessPeriodRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update access period
     * @OA\Put (
     *     path="/api/access_period/update/{id}",
     *     tags={"Access period"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="D9B7E73F-9E5B-4884-AF72-1FE5934A6E3A",
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
     *                          property="term_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="admin_beginning_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="admin_ending_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="admin_cancel_section_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="depart_beginning_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="depart_ending_date",
     *                          type="date"
     *                      )
     *                 ),
     *                 example={
     *                      "term_id": "e8356132-0e8c-4448-b547-6254094ddd3b",
     *                      "admin_beginning_date": "2010/02/02",
     *                      "admin_ending_date": "2010/02/02",
     *                      "admin_cancel_section_date": "2010/02/02",
     *                      "depart_beginning_date": "2010/02/02",
     *                      "depart_ending_date": "2010/02/02"
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
     */
    public function updateAccessPeriod(string $id, AccessPeriodRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Access period successfully  updated.', $this->accessPeriodRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete access period by id
     * @OA\Delete(
     *     path="/api/access_period/delete/{id}",
     *     tags={"Access period"},
     *     operationId="deleteAccessPeriod",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid",
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
    public function deleteAccessPeriod(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Access period successfully deleted.', $this->accessPeriodRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
