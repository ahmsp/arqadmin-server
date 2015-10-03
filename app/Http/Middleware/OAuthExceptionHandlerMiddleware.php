<?php

namespace ArqAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use League\OAuth2\Server\Exception\OAuthException;

/**
 * This is the exception handler middleware class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class OAuthExceptionHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (OAuthException $e) {

            switch ($e->errorType) {
                case "access_denied":
                    $message = 'Acesso negado.';
                    break;
                case "invalid_request":
                    $message = 'Dados de acesso inválidos. Verifique os parâmetros da requisição';
                    break;
                case "invalid_credentials":
                    $message = 'As credenciais estão incorretas ou o usuário não está cadastrado';
                    break;
                default:
                    $message = $e->errorType;
            }

            $data = [
                'error' => $e->errorType,
                'error_description' => $message,
            ];

            return new JsonResponse($data, $e->httpStatusCode, $e->getHttpHeaders());
        }
    }
}

