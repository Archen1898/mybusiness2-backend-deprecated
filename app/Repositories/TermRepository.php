<?php

namespace  App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\ActiveInterface;
use App\Interfaces\CrudInterface;
use App\Models\Term;
use App\Exceptions\ResourceNotFoundException;


class TermRepository implements CrudInterface,ActiveInterface {

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $terms = Term::orderBy('name', 'desc')->get();
            if ($terms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundAll'));
            }
            return $terms;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $terms = Term::where('ac.terms.active','=',$status)->get();
            if ($terms->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundByStatus'));
            }
            return $terms;
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
            $term = Term::find($id);
            if (!$term){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundById'));
            }
            return $term;
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
            $term = new Term();
            $newTerm = $this->dataForTerm($request,$term);
            $newTerm->save();
            return $newTerm;
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function update($id, $request): object|null
    {
        try {
            $term = $this->viewById($id);
            if (!$term){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundById'));
            }
            $newTerm = $this->dataForTerm($request,$term);
            $newTerm->update();
            return $newTerm;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|null
    {
        try {
            $term = $this->viewById($id);
            if ($term->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.term.exceptionNotFoundById'));
            }
            $term->delete();
            return $term;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataForTerm(array $request, Term $term):object|null
    {
        $term->name = $request['name'];
        $term->semester = $request['semester'];
        $term->year = $request['year'];
        $term->academic_year = $request['academic_year'];
        $term->description = $request['description'];
        $term->fiu_academic_year = $request['fiu_academic_year'];
        $term->description_short = $request['description_short'];
        $term->begin_dt_for_apt = $request['begin_dt_for_apt'];
        $term->begin_dt = $request['begin_dt'];
        $term->end_dt = $request['end_dt'];
        $term->close_end_dt = $request['close_end_dt'];
        $term->fas_begin_dt = $request['fas_begin_dt'];
        $term->fas_end_dt = $request['fas_end_dt'];
        $term->session = $request['session'];
        $term->academic_year_full = $request['academic_year_full'];
        $term->fiu_grade_date = $request['fiu_grade_date'];
        $term->fiu_grade_date_a = $request['fiu_grade_date_a'];
        $term->fiu_grade_date_b = $request['fiu_grade_date_b'];
        $term->fiu_grade_date_c = $request['fiu_grade_date_c'];
        $term->p180_status_term_id = $request['p180_status_term_id'];
        $term->active = $request['active'];
        return $term;
    }
}


