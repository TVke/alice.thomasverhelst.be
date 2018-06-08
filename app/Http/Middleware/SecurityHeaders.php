<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
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
        $response = $next($request);

//        $response->header('strict-transport-security', 'max-age=31536000; includeSubDomains; preload');
//        $response->header('x-frame-options', 'SAMEORIGIN');
//        $response->header('X-XSS-Protection', '1; mode=block');
//        $response->header('Referrer-Policy', 'strict-origin');
//        $response->header('Server', '');
//        $response->header('Expect-CT', 'enforce;max-age=3600');

        return $response;
    }
}
