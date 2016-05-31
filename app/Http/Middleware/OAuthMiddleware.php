<?php

/*
 * Override OAuthMiddleware
 *
 * This file is part of OAuth 2.0 Laravel.
 *
 * (c) Luca Degasperi <packages@lucadegasperi.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ArqAdmin\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use League\OAuth2\Server\Exception\InvalidScopeException;
use LucaDegasperi\OAuth2Server\Authorizer;

/**
 * This is the oauth middleware class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class OAuthMiddleware
{
    /**
     * The Authorizer instance.
     *
     * @var \LucaDegasperi\OAuth2Server\Authorizer
     */
    protected $authorizer;

    /**
     * Whether or not to check the http headers only for an access token.
     *
     * @var bool
     */
    protected $httpHeadersOnly = false;

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new oauth middleware instance.
     *
     * @param \LucaDegasperi\OAuth2Server\Authorizer $authorizer
     * @param Guard $auth
     * @param bool $httpHeadersOnly
     */
    public function __construct(Authorizer $authorizer, Guard $auth, $httpHeadersOnly = false)
    {
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $scopesString
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $scopesString = null)
    {
        $scopes = [];

        if (!is_null($scopesString)) {
            $scopes = explode('+', $scopesString);
        }

        $this->authorizer->setRequest($request);

        $this->authorizer->validateAccessToken($this->httpHeadersOnly);
        $this->validateScopes($scopes);

        // Log the given user ID into the application for a single request without sessions or cookies
        $this->auth->onceUsingId($this->authorizer->getResourceOwnerId());

        return $next($request);
    }

    /**
     * Validate the scopes.
     *
     * @param $scopes
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     */
    public function validateScopes($scopes)
    {
        if (!empty($scopes) && !$this->authorizer->hasScope($scopes)) {
            throw new InvalidScopeException(implode(',', $scopes));
        }
    }
}
