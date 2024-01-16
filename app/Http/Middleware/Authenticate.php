<?php

namespace App\Http\Middleware;

//GLOBAL IMPORT
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\Middleware\Authorize as MiddlewareAuthorize;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Closure;

//LOCAL IMPORT
use App\Traits\ResponseTraits;

class Authenticate extends Middleware
{
    use ResponseTraits;
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()){
            return $this->response(response::HTTP_UNAUTHORIZED,"Unauthenticated access.",[],null);
        }
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param $request
     * @param array $guards
     * @return void
     *
     */
    protected function  unauthenticated($request, array $guards): void
    {
        throw new HttpResponseException(
            $this->response(response::HTTP_UNAUTHORIZED,"Unauthenticated access.",[],null)
        );
    }
}
