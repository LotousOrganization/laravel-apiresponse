# Standardizing API Responses and Handling All Exceptions


## 👋 Introduction

Hi, I'm **Sobhan Aali** — thank you for choosing this package!

This package helps you standardize all your API JSON responses and handle exceptions gracefully across your Laravel project, including:

- ✅ Consistent and customizable **API Response formatting**
    
- ✅ Centralized **Exception handling** with meaningful JSON outputs
    
- ✅ Easy-to-use **Traits** and response classes to speed up development
    

---
## Installation:

```bash
composer require sobhan-aali/laravel-apiresponse
```

## What’s Next?

Two files will be automatically created for you to customize:

- `Responses/ApiResponse.php`
    
- `Traits/Exceptions.php`
    

---
## How to Enable Exception Handling

Add the following code to your `bootstrap/app.php` file to automatically handle exceptions using the package’s trait:

```php
use App\Helpers\Exceptions;

$app->withExceptions(function ($exceptions) {
    
    $exceptions->renderable(function (Throwable $exception, $request) use ($handler) {
        return Exceptions::render($exception, $request);
    });
});
```
