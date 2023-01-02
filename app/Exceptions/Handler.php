<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

   /**
    * Report or log an exception.
    *
    * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
    *
    * @param  \Throwable  $exception
    * @return void
    */
    public function report(Throwable $exception)
    {
       parent::report($exception);
    }

   /**
    * Render an exception into an HTTP response.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Throwable  $exception
    * @return \Illuminate\Http\Response
    */
    public function render($request, Throwable $exception)
    {
        // if ($exception instanceof ModelNotFoundException) {
        //     return response()->json(['error' => 'Data not found.']);
        // }

        if ($exception instanceof ModelNotFoundException) {
            // Do your stuff here
            // return response()->view('errors.'.'404');
            abort(404);
        // } elseif ($this->isHttpException($exception)) {
            // return $this->renderHttpException($exception);
        } else {
            return parent::render($request, $exception);
        }

       return parent::render($request, $exception);
    }
}
