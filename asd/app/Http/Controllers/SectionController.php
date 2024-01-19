<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use App\Http\Requests\SectionDuplicateRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Http\Requests\SectionRequest;
use App\Repositories\SectionRepository;
use App\Traits\ResponseTraits;

class SectionController extends Controller
{
    protected SectionRepository $sectionRepository;
    use ResponseTraits;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/section/index",
     *     tags={"Section"},
     *     summary="Get all sections",
     *     operationId="indexSection",
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
    public function indexSection(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Sections successfully fetched.', $this->sectionRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get section by ID
     * @OA\Get(
     *     path="/api/section/{id}",
     *     tags={"Section"},
     *     operationId="showSection",
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
    public function showSection(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Section successfully fetched.', $this->sectionRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    public function addSection(SectionRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Section successfully created.', $this->sectionRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    public function updateSection(string $id, SectionRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Section successfully updated.', $this->sectionRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    public function deleteSection(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Section successfully deleted.', $this->sectionRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    public function duplicateSections(SectionDuplicateRequest $terms): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Duplication successfully.', $this->sectionRepository->duplicateSections($terms->all()),null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
