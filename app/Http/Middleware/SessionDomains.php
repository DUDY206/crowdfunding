<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        config([
            'session.domain' => '.'.env('SITE_URL')
        ]);
        return $next($request);
    }
}
