<?php

namespace App\Http\Requests;

//GLOBAL IMPORT
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

//LOCAL IMPORT
use App\Traits\ResponseTraits;


class ApiFormRequest extends FormRequest
{
    use ResponseTraits;

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
//            $this->response((new ValidationException($validator))->errors(),"asd")
            $this->response(Response::HTTP_NOT_FOUND,"error",[],(new ValidationException($validator))->errors())
        );
    }
}
