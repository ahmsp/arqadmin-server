<?php

namespace ArqAdmin\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use League\OAuth2\Server\Exception\InvalidCredentialsException;
use League\OAuth2\Server\Exception\InvalidRequestException;
use League\OAuth2\Server\Exception\OAuthException;
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
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (!$request->is('authenticate', 'api/*')) {
            return parent::render($request, $e);
        }

        $debug = config('app.debug', true);

        if ($e instanceof HttpException) {

            switch ($e->getStatusCode()) {
                case 404:
                    $message = 'Recurso não encontrado';
                    break;
                case 400:
                    $message = $e->getMessage();
                    break;
                default:
                    $message = 'Não foi possível completar a operação. Consulte um administrador';
            }

            $error = ($debug) ? $e->getMessage() : $message;

            return response($error, $e->getStatusCode());
        }

        if ($e instanceof OAuthException) {

            switch ($e->errorType) {
                case "access_denied":
                    $message = 'Acesso negado.';
                    break;
                case "invalid_credentials":
                    $message = 'As credenciais estão incorretas ou o usuário não está cadastrado';
                    break;
                case "invalid_request":
                case "grant_type":
                    $message = 'Houve um erro de acesso. Se o problema persistir, consulte um administrador';
                    break;
                default:
                    $message = 'Atenção, Se o problema persistir, consulte um administrador.';
            }

            $error = [
                'error' => $e->errorType,
                'error_description' => ($debug) ? $e->getMessage() : $message,
            ];

            return response($error, $e->httpStatusCode, $e->getHttpHeaders());
        }

        return response($e->getMessage(), $e->getStatusCode());
    }

}
