<?php

namespace SobhanAali\ApiResponse;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Bootstrap\Exceptions;
use Throwable;

class ApiResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        app()->booted(function () {
            $this->extendExceptionHandler();
            $this->copyApiResponseStub();
        });
    }

    protected function extendExceptionHandler()
    {
        $exceptions = app(Exceptions::class);

        $exceptions->renderable(function (Throwable $exception, $request) {

            if (! ($request->expectsJson() || $request->is('api/*'))) {
                return null;
            }

            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return \App\Responses\ApiResponse::notFound('Record not found.');
            }

            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
                && $exception->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return \App\Responses\ApiResponse::notFound('Record not found.');
            }

            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $firstError = collect($exception->errors())->flatten()->first();
                return \App\Responses\ApiResponse::validationError($firstError, 422, $exception->errors());
            }

            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return \App\Responses\ApiResponse::unauthorized();
            }

            if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return \App\Responses\ApiResponse::forbidden('You do not have permission to perform this action.', 403);
            }

            $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
            return \App\Responses\ApiResponse::error($exception->getMessage() ?: 'Server error.', $statusCode);
        });
    }

    protected function copyApiResponseStub()
    {
        $destination = app_path('Responses/ApiResponse.php');

        if (!file_exists($destination)) {
            $this->createStub($destination);
        }
    }

    protected function createStub($destination)
    {
        $stubPath = __DIR__ . '/stubs/ApiResponse.stub';

        if (!file_exists(dirname($destination))) {
            mkdir(dirname($destination), 0755, true);
        }

        copy($stubPath, $destination);
    }
}
