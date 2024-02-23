<?php

namespace App\Repositories;

//GLOBAL IMPORT
use App\Interfaces\ActiveInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Models\Program;
use App\Exceptions\ResourceNotFoundException;

class ProgramRepository implements CrudInterface,ActiveInterface
{
    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $programs = Program::where('ac.programs.active','=',$status)->get();
            if ($programs->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.program.exceptionNotFoundByStatus'));
            }
            return $programs;
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
            $programs = Program::with('programLevel', 'programGrouping', 'termEffective', 'termDiscontinue')->get();
            if ($programs->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.program.exceptionNotFoundAll'));
            }
            return $programs;
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
            $program = Program::find($id);
            if (!$program){
                throw new ResourceNotFoundException(trans('messages.program.exceptionNotFoundById'));
            }
            return $program;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function validateCodeExist($code)
    {
        try {
            $program = Program::where('ac.programs.code','=', $code)->first();
            if (!$program){
                throw new ResourceNotFoundException(trans('messages.program.exceptionNotFoundByCode'));
            }
            return $program;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $request): ?object
    {
        try {
            $program = new Program();
            $newProgram = $this->dataForProgram($request,$program);
            $newProgram->save();
            return $newProgram;
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
            $program = $this->viewById($id);
            if (!$program){
                throw new ResourceNotFoundException(trans('messages.program.exceptionNotFoundById'));
            }
            $newProgram = $this->dataForProgram($request,$program);
            $newProgram->update();
            return $newProgram;
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
            $program = $this->viewById($id);
            if (!$program){
                throw new ResourceNotFoundException(trans('messages.program.exceptionNotFoundById'));
            }
            $program->delete();
            return $program;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e) {
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataForProgram(array $request, Program $program):object|null
    {
        $program->code = $request['code'];
        $program->name = $request['name'];
        $program->degree = $request['degree'];
        $program->offering = $request['offering'];
        $program->program_level_id = $request['program_level_id'];
        $program->program_grouping_id = $request['program_grouping_id'];
        $program->term_effective_id = $request['term_effective_id'];
        $program->term_discontinue_id = $request['term_discontinue_id'];
        $program->fte = $request['fte'];
        $program->active = $request['active'];
        return $program;
    }
}
