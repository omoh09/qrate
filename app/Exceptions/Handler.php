<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

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
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['status' => 'error', 'message' => 'url does not exist'], 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['status' => 'error', 'message' => 'wrong request method, rectify that (check the request method used)'], 400);
        }
        if ($exception instanceof AccessDeniedHttpException || $exception instanceof UnauthorizedHttpException || $exception instanceof AuthenticationException || $exception instanceof BadRequestHttpException || $exception instanceof UnprocessableEntityHttpException || $exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }
        if (getenv('APP_ENV') == 'local') {
            return parent::render($request, $exception);
        } else {

            return response()->json(['status' => 'error', 'message' => 'internal server error'], 500);
        }
    }
}
