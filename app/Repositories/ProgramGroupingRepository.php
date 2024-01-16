<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\ActiveInterface;
use App\Interfaces\CrudInterface;
use App\Models\ProgramGrouping;
use App\Exceptions\ResourceNotFoundException;

class ProgramGroupingRepository implements CrudInterface, ActiveInterface
{
    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $programGroupings = ProgramGrouping::where('ac.program_groupings.active','=',$status)->get();
            if ($programGroupings->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.programGrouping.exceptionNotFoundByStatus'));
            }
            return $programGroupings;
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
            $programGroupings = ProgramGrouping::orderBy('name', 'desc')->get();
            if ($programGroupings->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.programGrouping.exceptionNotFoundAll'));
            }
            return $programGroupings;
        } catch (ResourceNotFoundException $e) {
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
            $programGrouping = ProgramGrouping::find($id);
            if (!$programGrouping){
                throw new ResourceNotFoundException(trans('messages.programGrouping.exceptionNotFoundById'));
            }
            return $programGrouping;
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
            $programGrouping = new ProgramGrouping();
            $newProgramGrouping = $this->dataForProgramGrouping($request,$programGrouping);
            $newProgramGrouping->save();
            return $newProgramGrouping;
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
            $programGrouping = $this->viewById($id);
            if (!$programGrouping){
                throw new ResourceNotFoundException(trans('messages.programGrouping.exceptionNotFoundById'));
            }
            $newProgramGrouping = $this->dataForProgramGrouping($request,$programGrouping);
            $newProgramGrouping->update();
            return $newProgramGrouping;
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
            $programGrouping = $this->viewById($id);
            if (!$programGrouping){
                throw new ResourceNotFoundException(trans('messages.programGrouping.exceptionNotFoundById'));
            }
            $programGrouping->delete();
            return $programGrouping;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataForProgramGrouping(array $request, ProgramGrouping $programGrouping):object|null
    {
        $programGrouping->code = $request['code'];
        $programGrouping->name = $request['name'];
        $programGrouping->active = $request['active'];
        return $programGrouping;
    }
}
