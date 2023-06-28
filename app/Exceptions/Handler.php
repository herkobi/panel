<?php

namespace App\Exceptions;

use App\Enums\UserType;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
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

    // Panel Tarafının Hata Sayfalarını Özelleştirme
    protected function renderHttpException(HttpExceptionInterface $e): Response
    {
        $this->registerErrorViewPaths();

        $view = "errors::{$e->getStatusCode()}";

        if (request()->is('panel/*')) {
            $view = "errors::panel.{$e->getStatusCode()}";
        }

        if (view()->exists($view)) {
            return response()->view($view, [
                'errors' => new \Illuminate\Support\ViewErrorBag,
                'exception' => $e,
            ], $e->getStatusCode(), $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }
}
