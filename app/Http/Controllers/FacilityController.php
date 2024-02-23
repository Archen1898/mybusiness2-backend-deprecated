<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\FacilityRequest;
use App\Repositories\FacilityRepository;
use App\Traits\ResponseTraits;

class FacilityController extends Controller
{
    protected FacilityRepository $facilityRepository;
    use ResponseTraits;

    public function __construct(FacilityRepository $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/facility/index",
     *     tags={"Facility"},
     *     summary="Get all facilities",
     *     operationId="indexFacility",
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
    public function indexFacility(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Facilities successfully fetched.', $this->facilityRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get facilities by status
     * @OA\Get(
     *     path="/api/facility/status/{id}",
     *     tags={"Facility"},
     *     operationId="showFacilityByStatus",
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         description="Boolean ID",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
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
     * @param int $status
     * @return JsonResponse
     */
    public function showFacilityByStatus(int $status): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Facilities successfully fetched.', $this->facilityRepository->viewAllByStatus($status), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get facility by ID
     * @OA\Get(
     *     path="/api/facility/{id}",
     *     tags={"Facility"},
     *     operationId="showFacility",
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
    public function showFacility(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Facility successfully fetched.', $this->facilityRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create facility
     * @OA\Post (
     *     path="/api/facility/add",
     *     tags={"Facility"},
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
     *                          property="capacity",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="building_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "name": "AB302",
     *                      "capacity": "50",
     *                      "building_id": "e8356132-0e8c-4448-b547-6254094ddd3b",
     *                      "active": "1"
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
     */
    public function addFacility(FacilityRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Facility successfully created.', $this->facilityRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update facility
     * @OA\Put (
     *     path="/api/facility/update/{id}",
     *     tags={"Facility"},
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
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="capacity",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="building_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "name": "AC302",
     *                      "capacity": "50",
     *                      "building_id": "e8356132-0e8c-4448-b547-6254094ddd3b",
     *                      "active": "1"
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
     */
    public function updateFacility(string $id, FacilityRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Facility successfully updated.', $this->facilityRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete facility by id
     * @OA\Delete(
     *     path="/api/facility/delete/{id}",
     *     tags={"Facility"},
     *     operationId="deleteFacility",
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
    public function deleteFacility(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Facility successfully deleted.', $this->facilityRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
