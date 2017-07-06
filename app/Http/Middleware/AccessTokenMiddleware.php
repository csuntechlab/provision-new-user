<?php

namespace App\Http\Middleware;

use Closure;

class AccessTokenMiddleware
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
       // only allow the action to be handled if the user has an OAuth
       // access token
       if(!session('access_token')) {
          return redirect(route('oauth.authorize'));
       }

       return $next($request);
    }
}
