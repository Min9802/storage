<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use RedisException;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        RedisException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    private $statusCode;
    private $headers;
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            return $this->handleException($request, $exception);
        }

        return parent::render($request, $exception);
    }
    public function handleException($request, Exception $exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        if ($exception instanceof AuthorizationException) {
            $response = [
                'status' => 'error',
                'message' => "res.access_denied",
            ];
            return response()->json($response, 403);
        }
        if ($exception instanceof ValidationException) {
            $messageRaw = $exception->errors();
            $message = [];
            foreach ($messageRaw as $key => $value) {
                $valueNew = explode(".", $value[0]);
                $message[] = "res." . $valueNew[0] . "." . $key . "." . $valueNew[1];
            }
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, 422);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            $message = $exception->getMessage();
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof HttpException) {
            $message = $exception->getMessage();
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof NotFoundHttpException) {
            $message = 'res.notfound';
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
            $message = 'res.auth.unauthorized';
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, $statusCode);
        }
        if($exception instanceof OAuthServerException){
            $message = $exception->getMessage();
            $statusCode=401;
            $response = [
                'status' => 'error',
                'message' => "res.auth.unauthorized",
            ];
            return response()->json($response, $statusCode);
        }
        if ($exception instanceof ModelNotFoundException) {
            $message = $exception->getMessage();
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, $statusCode);
        }

        if ($exception instanceof RuntimeException) {
            $message = $exception->getMessage();
            $response = [
                'status' => 'error',
                'message' => $message,
            ];
            return response()->json($response, $statusCode);
        }

        $message = $exception->getMessage();
        $response = [
            'status' => 'error',
            'message' => 'res.serverError',
        ];
        return response()->json($response, $statusCode);

    }
}
