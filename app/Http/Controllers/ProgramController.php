<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\ProgramRequest;
use App\Repositories\ProgramRepository;
use App\Traits\ResponseTraits;

class ProgramController extends Controller
{
    protected ProgramRepository $programRepository;
    use ResponseTraits;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/program/index",
     *     tags={"Program"},
     *     summary="Get all program",
     *     operationId="indexProgram",
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
    public function indexProgram(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully fetched.', $this->programRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program by ID
     * @OA\Get(
     *     path="/api/program/{id}",
     *     tags={"Program"},
     *     operationId="showProgram",
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
    public function showProgram(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully fetched.', $this->programRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program by status
     * @OA\Get(
     *     path="/api/program/status/{id}",
     *     tags={"Program"},
     *     operationId="showProgramByStatus",
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
    public function showProgramByStatus(int $status): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully fetched.', $this->programRepository->viewAllByStatus($status), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program by code
     * @OA\Get(
     *     path="/api/program/code/{code}",
     *     tags={"Program"},
     *     operationId="existProgramCode",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         description="String Code",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="Demo",
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
     * @param string $code
     * @return JsonResponse
     */
    public function existProgramCode(string $code): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully fetched.', $this->programRepository->validateCodeExist($code), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create program
     * @OA\Post (
     *     path="/api/program/add",
     *     tags={"Program"},
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
     *                          property="degree",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="offering",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="program_level_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="program_grouping_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="term_effective",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="term_discontinue",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="fte",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "Code": "MSG",
     *                      "Name": "Master",
     *                      "degree": "Degree details",
     *                      "offering": "offering details",
     *                      "program_level_id": "df0665be-d14f-426e-bfb3-066abe4ae02e",
     *                      "program_grouping_id": "df0665be-d14f-426e-bfb3-066abe4ae02e",
     *                      "term_effective": "2023",
     *                      "term_discontinue": "2023",
     *                      "fte": "1",
     *                      "active": "1"
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
    public function addProgram(ProgramRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully created.', $this->programRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update program
     * @OA\Put (
     *     path="/api/program/update/{id}",
     *     tags={"Program"},
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
     *                          property="degree",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="offering",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="program_level_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="program_grouping_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="term_effective",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="term_discontinue",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="fte",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "code": "MSG",
     *                      "name": "Master",
     *                      "degree": "Degree details",
     *                      "offering": "offering details",
     *                      "program_level_id": "df0665be-d14f-426e-bfb3-066abe4ae02e",
     *                      "program_grouping_id": "df0665be-d14f-426e-bfb3-066abe4ae02e",
     *                      "term_effective": "2023",
     *                      "term_discontinue": "2023",
     *                      "fte": "1",
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
    public function updateProgram(string $id, ProgramRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully updated.', $this->programRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete program by id
     * @OA\Delete(
     *     path="/api/program/delete/{id}",
     *     tags={"Program"},
     *     operationId="deleteProgram",
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
    public function deleteProgram(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program successfully deleted.', $this->programRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
