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
        $destination = base_path('Traits/Exceptions.php');

        if (!file_exists($destination)) {
            $this->createStub($destination , 'Exceptions');
        }
    }

    protected function copyApiResponseStub()
    {
        $destination = base_path('Responses/ApiResponse.php');

        if (!file_exists($destination)) {
            $this->createStub($destination , 'ApiResponse');
        }
    }

    protected function createStub($destination , $stub)
    {
        $stubPath = __DIR__ . '/stubs/'.$stub.'.stub';

        if (!file_exists(dirname($destination))) {
            mkdir(dirname($destination), 0755, true);
        }

        copy($stubPath, $destination);
    }
}
