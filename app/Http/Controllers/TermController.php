<?php

namespace App\Http\Controllers;


//GLOBAL IMPORT

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;

//LOCAL IMPORT
use App\Repositories\TermRepository;
use App\Http\Requests\TermRequest;
use App\Traits\ResponseTraits;

class TermController extends Controller
{
    protected TermRepository $termRepository;
    use ResponseTraits;

    public function __construct(TermRepository $termRepository)
    {
        $this->termRepository = $termRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/term/index",
     *     tags={"Term"},
     *     summary="Get all term",
     *     operationId="indexTerm",
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
    public function indexTerm(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Terms successfully fetched.', $this->termRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get terms by status
     * @OA\Get(
     *     path="/api/term/status/{id}",
     *     tags={"Term"},
     *     operationId="showTermByStatus",
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
    public function showTermByStatus(int $status): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Terms successfully fetched.', $this->termRepository->viewAllByStatus($status), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get term by ID
     * @OA\Get(
     *     path="/api/term/{id}",
     *     tags={"Term"},
     *     operationId="showTerm",
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
    public function showTerm(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Term successfully fetched.', $this->termRepository->viewById($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create term
     * @OA\Post (
     *     path="/api/term/add",
     *     tags={"Term"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="number",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="semester",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="year",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="academic_year",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_academic_year",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description_short",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="begin_dt_for_apt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="begin_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="end_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="close_end_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fas_begin_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fas_end_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="session",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="academic_year_full",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date_a",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date_b",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date_c",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="p180_status_term_id",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "number": "1248",
     *                      "semester": "Fall",
     *                      "year": "2023",
     *                      "academic_year": "2015-2016",
     *                      "fiu_academic_year": "2015-2016",
     *                      "description": "",
     *                      "description_short": "",
     *                      "begin_dt_for_apt": "2010/02/02",
     *                      "begin_dt": "2010/02/02",
     *                      "end_dt": "2010/02/02",
     *                      "close_end_dt": "2010/02/02",
     *                      "fas_begin_dt": "2010/02/02",
     *                      "fas_end_dt": "2010/02/02",
     *                      "session": "",
     *                      "academic_year_full": "",
     *                      "fiu_grade_date": "2010/02/02",
     *                      "fiu_grade_date_a": "2010/02/02",
     *                      "fiu_grade_date_b": "2010/02/02",
     *                      "fiu_grade_date_c": "2010/02/02",
     *                      "p180_status_term_id": "",
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
     * )
     */
    public function addTerm(TermRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Term successfully created.', $this->termRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update term
     * @OA\Put (
     *     path="/api/term/update/{id}",
     *     tags={"Term"},
     *     operationId="updateTerm",
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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="term",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="semester",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="year",
     *                          type="integer"
     *                      ),
     *                      @OA\Property(
     *                          property="academic_year",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_academic_year",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description_short",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="begin_dt_for_apt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="begin_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="end_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="close_end_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fas_begin_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fas_end_dt",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="session",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="academic_year_full",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date_a",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date_b",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="fiu_grade_date_c",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="p180_status_term_id",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="active",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "term": "2023",
     *                      "semester": "Fall",
     *                      "year": "2023",
     *                      "academic_year": "2015-2016",
     *                      "fiu_academic_year": "2015-2016",
     *                      "description": "",
     *                      "description_short": "",
     *                      "begin_dt_for_apt": "2010/02/02",
     *                      "begin_dt": "2010/02/02",
     *                      "end_dt": "2010/02/02",
     *                      "close_end_dt": "2010/02/02",
     *                      "fas_begin_dt": "2010/02/02",
     *                      "fas_end_dt": "2010/02/02",
     *                      "session": "",
     *                      "academic_year_full": "",
     *                      "fiu_grade_date": "2010/02/02",
     *                      "fiu_grade_date_a": "2010/02/02",
     *                      "fiu_grade_date_b": "2010/02/02",
     *                      "fiu_grade_date_c": "2010/02/02",
     *                      "p180_status_term_id": "",
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
     * )
     *
     * *
     * @param string $id
     * @param TermRequest $request
     * @return JsonResponse
     */
    public function updateTerm(string $id, TermRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Term successfully updated.', $this->termRepository->update($id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete term
     * @OA\Delete(
     *     path="/api/term/delete/{id}",
     *     tags={"Term"},
     *     operationId="deleteTerm",
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
    public function deleteTerm(string $id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Term successfully deleted.', $this->termRepository->delete($id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    /**
     * @OA\Get(
     *     path="/api/term/number_instructors_term",
     *     tags={"Term"},
     *     summary="Number of instructors per term",
     *     operationId="getNumberInstructorsPerTerm",
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
    public function getNumberInstructorsPerTerm(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Numbers of instructors successfully fetched.', $this->termRepository->numberInstructorsPerTerm(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    /**
     * @OA\Get(
     *     path="/api/term/term_details",
     *     tags={"Term"},
     *     summary="Term details and sections",
     *     operationId="getTermDetails",
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
    public function getTermDetails(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Term details successfully fetched.', $this->termRepository->termDetails(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/term/term_dates",
     *     tags={"Term"},
     *     summary="Term Dates and Duration",
     *     operationId="getTermDates",
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

    public function getTermDates(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Term dates successfully fetched.', $this->termRepository->termDates(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
    
}
