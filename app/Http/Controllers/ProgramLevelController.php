<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\ProgramLevelRequest;
use App\Repositories\ProgramLevelRepository;
use App\Traits\ResponseTraits;

class ProgramLevelController extends Controller
{
    protected ProgramLevelRepository $programLevelRepository;
    use ResponseTraits;

    public function __construct(ProgramLevelRepository $programLevelRepository)
    {
        $this->programLevelRepository = $programLevelRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/program_level/index",
     *     tags={"Program level"},
     *     summary="Get all program level",
     *     operationId="indexProgramLevel",
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
    public function indexProgramLevel(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program level successfully fetched.', $this->programLevelRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program level by status
     * @OA\Get(
     *     path="/api/program_level/status/{id}",
     *     tags={"Program level"},
     *     operationId="showProgramLevelByStatus",
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
    public function showProgramLevelByStatus(int $status): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program level successfully fetched.', $this->programLevelRepository->viewAllByStatus($status), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get program level by ID
     * @OA\Get(
     *     path="/api/program_level/{id}",
     *     tags={"Program level"},
     *     operationId="showProgramLevel",
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
    public function showProgramLevel(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program level successfully fetched.', $this->programLevelRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create program level
     * @OA\Post (
     *     path="/api/program_level/add",
     *     tags={"Program level"},
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
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "name": "Master",
     *                      "active": "1",
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
    public function addProgramLevel(ProgramLevelRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program level successfully created.', $this->programLevelRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update program level
     * @OA\Put (
     *     path="/api/program_level/update/{id}",
     *     tags={"Program level"},
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
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
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
    public function updateProgramLevel(string $id, ProgramLevelRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program level successfully updated.', $this->programLevelRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete program level by id
     * @OA\Delete(
     *     path="/api/program_level/delete/{id}",
     *     tags={"Program level"},
     *     operationId="deleteProgramLevel",
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
    public function deleteProgramLevel(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Program level successfully deleted.', $this->programLevelRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

}
