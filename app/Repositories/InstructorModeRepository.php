<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\InstructorMode;
use App\Exceptions\ResourceNotFoundException;

class InstructorModeRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $instructorModes = InstructorMode::where('ac.instructor_modes.active','=',$status)->get();
            if ($instructorModes->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.instructorModes.exceptionNotFoundByStatus'));
            }
            return $instructorModes;
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
            $instructorModes = InstructorMode::orderBy('name','desc')->get();
            if ($instructorModes->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.instructorMode.exceptionNotFoundAll'));
            }
            return $instructorModes;
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
            $instructorMode = InstructorMode::find($id);
            if (!$instructorMode){
                throw new ResourceNotFoundException(trans('messages.instructorMode.exceptionNotFoundById'));
            }
            return $instructorMode;
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
            $instructorMode = new InstructorMode();
            $newIM = $this->dataFormat($request,$instructorMode);
            $newIM->save();
            return $newIM;
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
            $instructorMode = $this->viewById($id);
            if (!$instructorMode){
                throw new ResourceNotFoundException(trans('messages.instructorMode.exceptionNotFoundById'));
            }
            $newIM = $this->dataFormat($request,$instructorMode);
            $newIM->update();
            return $newIM;
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
            $instructorMode = $this->viewById($id);
            if (!$instructorMode){
                throw new ResourceNotFoundException(trans('messages.instructorMode.exceptionNotFoundById'));
            }
            $instructorMode->delete();
            return $instructorMode;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, InstructorMode $instructorMode):object|null
    {
        $instructorMode->code = $request['code'];
        $instructorMode->name = $request['name'];
        $instructorMode->active = $request['active'];
        return $instructorMode;
    }
}
