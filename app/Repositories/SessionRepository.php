<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Session;
use App\Exceptions\ResourceNotFoundException;

class SessionRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $sessions = Session::where('ac.sessions.active','=',$status)->get();
            if ($sessions->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.session.exceptionNotFoundByStatus'));
            }
            return $sessions;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $sessions = Session::orderBy('code','desc')->get();
            if ($sessions->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.session.exceptionNotFoundAll'));
            }
            return $sessions;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById($id)
    {
        try {
            $session = Session::find($id);
            if (!$session){
                throw new ResourceNotFoundException(trans('messages.session.exceptionNotFoundById'));
            }
            return $session;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): ?object
    {
        try {
            $session = new Session();
            $newSession = $this->dataFormat($request,$session);
            $newSession->save();
            return $newSession;
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $session = $this->viewById($id);
            if (!$session){
                throw new ResourceNotFoundException(trans('messages.session.exceptionNotFoundById'));
            }
            $newSession = $this->dataFormat($request,$session);
            $newSession->update();
            return $newSession;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        try {
            $session = $this->viewById($id);
            if (!$session){
                throw new ResourceNotFoundException(trans('messages.session.exceptionNotFoundById'));
            }
            $session->delete();
            return $session;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, Session $session):object|null
    {
        $session->code = $request['code'];
        $session->active = $request['active'];
        return $session;
    }
}
