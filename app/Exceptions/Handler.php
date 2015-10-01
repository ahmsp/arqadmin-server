<?php

namespace ArqAdmin\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $debug = config('app.debug', true);

        if (!$debug) {

            if($e instanceof HttpException) {

//                switch ($e->getStatusCode()) {
//                    case 404:
//                        $message = $e->getMessage();
//                        break;
//                    case 400:
//                        $message = $e->getMessage();
//                        break;
//                    default:
//                        $message = 'Não foi possível completar a operação. Consulte um admnistrador';
//                }
//
//                return response($message, $e->getStatusCode());
                return response($e->getMessage(), $e->getStatusCode());
            }


        }

        return parent::render($request, $e);
    }

}
