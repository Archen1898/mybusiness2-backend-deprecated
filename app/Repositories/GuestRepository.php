<?php

namespace App\Repositories;

use Exception;
use App\Models\Guest;
use App\Exceptions\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class GuestRepository{


    /**
     * Create a new Guest
     * @OA\Post (
     *     path="/api/guest/add",
     *     tags={"Guest"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="user_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="first_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="last_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="middle_name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="visitorOfPID",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="guest_id",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone_number",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="student",
     *                          type="boolean"
     *                      )
     *                 ),
     *                 example={
     *                      "user_name": "guest1234",
     *                      "first_name": "John",
     *                      "middle_name": "Tom",
     *                      "last_name": "Doe",
     *                      "password": "1234",
     *                      "guest_id": "12345678",
     *                      "visitorOfPID": "6467890",
     *                      "email": "guest@fiu.edu",
     *                      "phone_number": "3053217654",
     *                      "password": "guest",
     *                      "student": "0",
     *                      
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
   
    public function create(array $request){

       
        try{
            $guest = new Guest();
            $guest = $this->guestData($request, $guest);
            $guest->save();
            return $guest;
        } catch (Exception $e){
            return new Exception(trans('messages.exception'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

    public function update($id, array $request){

        $guest = $this->viewById($id);
        if (!$guest){
            throw new ResourceNotFoundException("Specified Guest cannot be found");
        }
        $newGuest = $this->guestData($request, $guest);
        $newGuest->update();
        return $newGuest;
    }


    public function getAll(){
        return Guest::all();
    }

    public function guestData(array $request, Guest $guest): object|null{
        $guest->first_name = $request["first_name"];
        $guest->last_name = $request["last_name"];  
        $guest->middle_name = $request["middle_name"];
        $guest->user_name = $request["user_name"];
        $guest->visitorOfPID = $request["visitorOfPID"];
        $guest->student = $request["student"];
        $guest->password = $request["password"];
        $guest->email = $request["email"];
        $guest->phone = $request["phone"];

        return $guest;
    }

    public function viewById($id)
    {
        try {
            $guest = Guest::find($id);
            if (!$guest){
                throw new ResourceNotFoundException(trans('Specified Guest cannot be found'));
            }
            return $guest;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}