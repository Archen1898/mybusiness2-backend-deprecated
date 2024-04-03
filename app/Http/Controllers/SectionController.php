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
     * Create a new section
     * @OA\Post (
     *     path="/api/section/add",
     *     tags={"Section"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="caps",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="term_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="course_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="sec_code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="cap",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="instructor_mode_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="campus_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="starting_date",
     *                          type="datetime"
     *                      ),
     *                      @OA\Property(
     *                          property="program_id",
     *                          type="uuid"
     *                      ),
     *                      @OA\Property(
     *                          property="cohorts",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="status",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="combined",
     *                          type="boolean"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                      property="created_by",
     *                      type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="comment",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="internal_note",
     *                          type="string",
     *                      ),
     *                 ),
     *                 example={
     *                      "caps": "1",
     *                      "term_id": "2501",
     *                      "course_id": "3001",
     *                      "sec_code": "RVD",
     *                      "cap": "123",
     *                      "instructor_mode_id": "123",
     *                      "campus_id": "123",
     *                      "starting_date": "2024-01-10T22:18:54.927000Z",
     *                      "program_id": 123,
     *                      "cohorts": "exampleCohorts",
     *                      "status": "exampleStatus",
     *                      "combined":"1",
     *                      "comment": "exampleComment",
     *                      "created_at": "2024-01-10T22:18:54.927000Z",
     *                      "updated_at": "2024-01-10T22:18:54.927000Z",
     *                      "created_by": "exampleCreated_by",
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
    public function duplicateSections(SectionDuplicateRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Duplication successfully.', $this->sectionRepository->duplicateSections($request),null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    public function quantitySection(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Number of sections per term successfully fetched.', $this->sectionRepository->termInstructorQuantity(),null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    public function getTermsInfo(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Info successfully fetched.', $this->sectionRepository->getTermsInfo(),null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    public function getSectionsByTermId(string $termId, $criteria): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Info successfully fetched.', $this->sectionRepository->viewAllSectionsByTermID($termId,$criteria),null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
