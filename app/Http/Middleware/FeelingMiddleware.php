<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;

class FeelingMiddleware
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
     
        return $next($request);
    }
}
