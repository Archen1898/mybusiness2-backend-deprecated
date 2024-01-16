<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\ProgramLevel;
use App\Exceptions\ResourceNotFoundException;

class ProgramLevelRepository implements CrudInterface,ActiveInterface
{
    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $programLevel = ProgramLevel::where('ac.program_levels.active','=',$status)->get();
            if ($programLevel->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.programLevel.exceptionNotFoundByStatus'));
            }
            return $programLevel;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $programLevel = ProgramLevel::orderBy('name', 'desc')->get();
            if ($programLevel->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.programLevel.exceptionNotFoundAll'));
            }
            return $programLevel;
        } catch (ResourceNotFoundException $e){
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewById($id)
    {
        try {
            $programLevel = ProgramLevel::find($id);
            if (!$programLevel){
                throw new ResourceNotFoundException(trans('messages.programLevel.exceptionNotFoundById'));
            }
            return $programLevel;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $exception){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): ?object
    {
        try {
            $programLevel = new ProgramLevel();
            $newProgramLevel = $this->dataForProgramLevel($request,$programLevel);
            $newProgramLevel->save();
            return $newProgramLevel;
        }  catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $programLevel = $this->viewById($id);
            if (!$programLevel){
                throw new ResourceNotFoundException(trans('messages.programLevel.exceptionNotFoundById'));
            }
            $newProgramLevel = $this->dataForProgramLevel($request,$programLevel);
            $newProgramLevel->update();
            return $newProgramLevel;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $exception){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        try {
            $programLevel = $this->viewById($id);
            if (!$programLevel){
                throw new ResourceNotFoundException(trans('messages.programLevel.exceptionNotFoundById'));
            }
            $programLevel->delete();
            return $programLevel;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $exception){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataForProgramLevel(array $request, ProgramLevel $programLevel):object|null
    {
        $programLevel->name = $request['name'];
        $programLevel->active = $request['active'];
        return $programLevel;
    }
}
