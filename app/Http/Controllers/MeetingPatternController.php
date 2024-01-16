<?php

namespace App\Http\Controllers;

//GLOBAL IMPORT
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Traits\ResponseTraits;
//use App\Http\Requests\MeetingPatternRequest;
use App\Repositories\MeetingPatternRepository;

class MeetingPatternController extends Controller
{
    protected MeetingPatternRepository $meetingPatternRepository;
    use ResponseTraits;

    public function __construct(MeetingPatternRepository $meetingPatternRepository)
    {
        $this->meetingPatternRepository = $meetingPatternRepository;
//        $this->middleware('auth');
    }

    /**
     * @OA\Get(
     *     path="/api/meeting_pattern/index",
     *     tags={"Meeting pattern"},
     *     summary="Get all Meeting patterns",
     *     operationId="indexMeetingPattern",
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
    public function indexMeetingPattern(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Meeting patterns successfully fetched.', $this->meetingPatternRepository->viewAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * * Get meeting pattern by ID
     * @OA\Get(
     *     path="/api/meeting_pattern/{id}",
     *     tags={"Meeting pattern"},
     *     operationId="showMeetingPattern",
     *     @OA\Parameter(
     *         name="day",
     *         in="path",
     *         description="String",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="Monday",
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="hour",
     *         in="path",
     *         description="String",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="19:00",
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="room id",
     *         in="path",
     *         description="Uuid",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="D9B7E73F-9E5B-4884-AF72-1FE5934A6E3A",
     *             type="string",
     *         )
     *     ),
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
     * @param string $day
     * @param string $hour
     * @param string $room_id
     * @return JsonResponse
     */
    public function showMeetingPattern(string $day, string $hour,string $room_id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Meeting pattern successfully fetched.', $this->meetingPatternRepository->viewByDayHourRoomId($day, $hour,$room_id), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Create meeting pattern
     * @OA\Post (
     *     path="/api/meeting_pattern/add",
     *     tags={"Meeting pattern"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="day",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="hour",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="room_id",
     *                          type="uuid"
     *                      )
     *                 ),
     *                 example={
     *                      "day": "Monday",
     *                      "hour": "19:00",
     *                      "room_id": "e8356132-0e8c-4448-b547-6254094ddd3b"
     *                }
     *             )
     *         )
     *      ),
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
    public function addMeetingPattern(Request $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Meeting pattern successfully created.', $this->meetingPatternRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Update meeting pattern
     * @OA\Put (
     *     path="/api/meeting_pattern/update/{id}",
     *     tags={"Meeting pattern"},
     *     @OA\Parameter(
     *         name="day",
     *         in="path",
     *         description="String",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="Monday",
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="hour",
     *         in="path",
     *         description="String",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="19:00",
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="room id",
     *         in="path",
     *         description="Uuid",
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
     *                          property="day",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="hour",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="room_id",
     *                          type="uuid"
     *                      )
     *                 ),
     *                 example={
     *                      "day": "Monday",
     *                      "hour": "19:00",
     *                      "room_id": "e8356132-0e8c-4448-b547-6254094ddd3b"
     *                }
     *             )
     *         )
     *      ),
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
    public function updateMeetingPattern(string $day, string $hour,string $room_id, MeetingPatternRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Meeting patter successfully updated.', $this->meetingPatternRepository->update($day,$hour,$room_id,$request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    /**
     * Delete meeting pattern by id
     * @OA\Delete(
     *     path="/api/meeting_pattern/delete/{id}",
     *     tags={"Meeting pattern"},
     *     operationId="deleteMeetingPattern",
     *     @OA\Parameter(
     *         name="day",
     *         in="path",
     *         description="String",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="Monday",
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="hour",
     *         in="path",
     *         description="String",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="19:00",
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="room id",
     *         in="path",
     *         description="Uuid",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="D9B7E73F-9E5B-4884-AF72-1FE5934A6E3A",
     *             type="string",
     *         )
     *     ),
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
     * @param string $day
     * @param string $hour
     * @param string $room_id
     * @return JsonResponse
     */
    public function deleteMeetingPattern(string $day, string $hour,string $room_id): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, 'Meeting patter successfully deleted.', $this->meetingPatternRepository->delete($day,$hour,$room_id),null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

}
