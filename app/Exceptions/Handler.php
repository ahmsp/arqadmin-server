<?php

namespace ArqAdmin\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
//dd($e);
//        $debug = config('app.debug', true);
//        if ($debug) {//...}

        if ($e instanceof HttpException) {
            $message = 'Não foi possível completar a operação. Consulte um administrador';

            $error = [
                'error_type' => '', //$e->errorType (property does not exists in HttpException),
                'error_description' => $e->getMessage(),
                'user_message' => $message
            ];

            return response($error, $e->getStatusCode());
        }

        if ($e instanceof OAuthException) {

            switch ($e->errorType) {
                case "access_denied":
                    $message = 'Acesso negado. O servidor recusou autorização para a requisição.';
                    break;
                case "invalid_credentials":
                    $message = 'As credenciais estão incorretas ou o usuário não está cadastrado';
                    break;
                default:
                    $message = 'Acesso negado. O servidor recusou autorização para a requisição.';
            }

            $error = [
                'error_type' => $e->errorType,
                'error_description' => $e->getMessage(),
                'user_message' => $message
            ];

//            $error = [
//                'code' => '401',
//                'status' => 'error', // success, error (400-499), failure (500-599)
//                'message' => 'token is invalid',
//                'data' => 'UnauthorizedException'
//                'errors' => [
//                    'code' => $code,
//                    'user_message' => 'Não foi possível completar a operação. Consulte um admnistrador',
//                    'internal_message' => $message,
//                    'moreInfo' => ''
//                ]
//            ];

            return response($error, $e->httpStatusCode, $e->getHttpHeaders());
        }

        if ($e instanceof ModelNotFoundException) {

            $message = 'O item solicitado não foi encontrado';

            $error = [
                'error_type' => '', //$e->errorType (property does not exists in HttpException),
                'error_description' => $e->getMessage(),
                'user_message' => $message
            ];

            return response($error, 404);
        }

//        dd($e);
        return parent::render($request, $e); // comentar
//        return response('Erro: consulte um administrador', 500);

//        return response($e->getMessage(), $e->getStatusCode());
    }

}
