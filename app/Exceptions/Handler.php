<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof NotFoundHttpException)
        {
            return response()->json([
                'error' => 'La ruta a la que intenta acceder no existe',
                'error_code' => 404
            ]);
        }

        if(env('APP_DEBUG')==false) {
            return response()->json([
                'error' => $exception->getMessage(),
                'error_type' => 'FatalErrorException',
                'error_file' => $exception->getFile(),
                'error_line' => $exception->getLine(),
            ]);
        } else {
            return parent::render($request, $exception);
        }
    }
}
