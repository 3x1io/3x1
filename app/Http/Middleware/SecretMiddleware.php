<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretMiddleware
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
        if(auth()->user() && auth()->user()->secret_key == $request->secret_key){
            return $next($request);
        }
        else {
            return  response()->json([
                'success' => false,
                'message' => __('Bad Secret Key'),
            ]);
        }

    }
}
