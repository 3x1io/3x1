<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeveloperMiddleware
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
        if(config('3x1.developer') == "1" && auth('admin')->user() && auth('admin')->user()->id == 1){
            return $next($request);
        }
        else {
            return redirect('admin');
        }
    }
}
