<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\ProgramGroupingRequest;
use App\Repositories\ProgramGroupingRepository;
use App\Traits\ResponseTraits;

class ProgramGroupingController extends Controller
{
    protected ProgramGroupingRepository $programGroupingRepository;
    use ResponseTraits;

    public function __construct(ProgramGroupingRepository $programGroupingRepository)
    {
        $this->programGroupingRepository = $programGroupingRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/program_grouping/index",
     *     tags={"Program grouping"},
     *     summary="Get all program grouping",
     *     operationId="indexProgramGrouping",
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
    public function indexProgramGrouping(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program grouping successfully fetched.', $this->programGroupingRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program grouping by status
     * @OA\Get(
     *     path="/api/program_grouping/status/{id}",
     *     tags={"Program grouping"},
     *     operationId="showProgramGroupingByStatus",
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
    public function showProgramGroupingByStatus(int $status): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program grouping successfully fetched.', $this->programGroupingRepository->viewAllByStatus($status), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program grouping by ID
     * @OA\Get(
     *     path="/api/program_grouping/{id}",
     *     tags={"Program grouping"},
     *     operationId="showProgramGrouping",
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
    public function showProgramGrouping(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program grouping successfully fetched.', $this->programGroupingRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create program grouping
     * @OA\Post (
     *     path="/api/program_grouping/add",
     *     tags={"Program grouping"},
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
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "code": "MSG",
     *                      "name": "Master",
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
    public function addProgramGrouping(ProgramGroupingRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program grouping successfully created.', $this->programGroupingRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update program grouping
     * @OA\Put (
     *     path="/api/program_grouping/update/{id}",
     *     tags={"Program grouping"},
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
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "code": "MSG",
     *                      "name": "Master",
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
    public function updateProgramGrouping(string $id, ProgramGroupingRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program grouping successfully updated.', $this->programGroupingRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete program grouping by id
     * @OA\Delete(
     *     path="/api/program_grouping/delete/{id}",
     *     tags={"Program grouping"},
     *     operationId="deleteProgramGrouping",
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
    public function deleteProgramGrouping(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program grouping successfully deleted.', $this->programGroupingRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
