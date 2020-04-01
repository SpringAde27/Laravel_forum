<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Validation\ValidationException::class,
        \lluminate\Database\Eloquent\ModelNotFoundException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {        
        if( app()->environment('production') ) {
            $statusCode = 400;
            $title = '죄송합니다 :(';
            $description = '에러가 발생했습니다.';

            if( $exception instanceof ModelNotFoundException or
                $exception instanceof NotFoundHttpException ) {
                $statusCode = 404;
                $description = $exception->getMessage() ?: '요청하신 페이지가 없습니다.';
            }

            return response(view('errors.404',[
                'title' => $title,
                'description' => $description
            ]), $statusCode);
        }
         
        return parent::render($request, $exception);
    }
}
