<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Always return JSON for API routes
        if ($request->is('api/*')) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => method_exists($exception, 'errors') ? $exception->errors() : null,
                'status' => $exception->getCode() ?: 400,
            ], $exception->getCode() ?: 400);
        }

        return parent::render($request, $exception);
    }
}
