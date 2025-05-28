<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
        $path = $request->path();

            if (str_starts_with($path, 'admin')) {
                return redirect()->guest(route('admin.login'))->with('error', 'セッションが切れました。再度ログインしてください。');
            }

            if (str_starts_with($path, 'owner')) {
                return redirect()->guest(route('owner.login'))->with('error', 'セッションが切れました。再度ログインしてください。');
            }

            return redirect()->guest(route('login'))->with('error', 'セッションが切れました。再度ログインしてください。');
        }

        if ($exception instanceof AuthenticationException) {
            $path = $request->path();

            if (str_starts_with($path, 'admin')) {
                return redirect()->guest(route('admin.login'));
            }

            if (str_starts_with($path, 'owner')) {
                return redirect()->guest(route('owner.login'));
            }

            return redirect()->guest(route('login'));
        }

        return parent::render($request, $exception);
    }
}
