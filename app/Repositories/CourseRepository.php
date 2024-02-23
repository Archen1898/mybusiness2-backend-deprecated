<?php

namespace App\Repositories;

//GLOBAL IMPORT
use Exception;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Interfaces\CrudInterface;
use App\Interfaces\ActiveInterface;
use App\Models\Course;
use App\Exceptions\ResourceNotFoundException;

class CourseRepository implements CrudInterface,ActiveInterface
{

    /**
     * @throws Exception
     */
    public function viewAllByStatus($status)
    {
        try {
            $courses = Course::where('ac.courses.active','=',$status)->get();
            if ($courses->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.course.exceptionNotFoundByStatus'));
            }
            return $courses;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function findByCodeNameOrReference($searchTerm)
    {
        try {
            $courses = Course::where('code', $searchTerm)
                ->orWhere('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('references_number', $searchTerm)
                ->first();
            if (!$courses){
                throw new ResourceNotFoundException(trans('messages.course.exceptionNotFoundByStatus'));
            }
            return $courses;
        }catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @throws Exception
     */
    public function viewAll()
    {
        try {
            $courses = Course::with('department', 'program')->orderBy('code','desc')->get();
            if ($courses->isEmpty()){
                throw new ResourceNotFoundException(trans('messages.course.exceptionNotFoundAll'));
            }
            return $courses;
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
            $course = Course::find($id);
            if (!$course){
                throw new ResourceNotFoundException(trans('messages.course.exceptionNotFoundById'));
            }
            return $course;
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
            $course = new Course();
            $newCourse = $this->dataFormat($request,$course);
            $newCourse->save();
            return $newCourse;
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
            $course = $this->viewById($id);
            if (!$course){
                throw new ResourceNotFoundException(trans('messages.course.exceptionNotFoundById'));
            }
            $newCourse = $this->dataFormat($request,$course);
            $newCourse->update();
            return $newCourse;
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
            $course = $this->viewById($id);
            if (!$course){
                throw new ResourceNotFoundException(trans('messages.course.exceptionNotFoundById'));
            }
            $course->delete();
            return $course;
        } catch (ResourceNotFoundException $e) {
            throw new ResourceNotFoundException($e->getMessage(),$e->getCode());
        } catch (Exception $e){
            throw new Exception(trans('messages.exception'), response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataFormat(array $request, Course $course):object|null
    {
        $course->code = $request['code'];
        $course->references_number = $request['references_number'];
        $course->name = $request['name'];
        $course->credit = $request['credit'];
        $course->hour = $request['hour'];
        $course->description = $request['description'];
        $course->department_id = $request['department_id'];
        $course->program_id = $request['program_id'];
        $course->active = $request['active'];
        return $course;
    }
}
