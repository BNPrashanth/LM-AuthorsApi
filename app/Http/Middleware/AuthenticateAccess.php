<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AuthenticateAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validateSecrets = explode(',', env('ACCEPTED_SECRETS'));
        if (in_array($request->header('Authorization'), $validateSecrets)) {
            return $next($request);
        }

        abort(Response::HTTP_UNAUTHORIZED);
    }
}
