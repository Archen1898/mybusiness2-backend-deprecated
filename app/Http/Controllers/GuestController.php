<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use App\Repositories\GuestRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseTraits;

class GuestController extends Controller
{
    protected GuestRepository $guestRepository;
    use ResponseTraits;

    public function __construct(GuestRepository $guestRepository)
    {
        $this->guestRepository = $guestRepository;
    }

    public function create(Request $request){
        try {
            return $this->response(response::HTTP_OK, 'Guest successfully created.', $this->guestRepository->create($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    public function update(Request $request){
        try{
            return $this->response(Response::HTTP_OK, "Guest successfully updated", $this->guestRepository->update($request->all()), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }

    public function getAll(){
        try{
            return $this->response(Response::HTTP_OK, "Guests successfully retrieved", $this->guestRepository->getAll(), null);
        } catch (Exception $exception) {
            return $this->response(Response::HTTP_BAD_REQUEST, $exception->getMessage(), [], $exception->getMessage());
        }
    }
}
