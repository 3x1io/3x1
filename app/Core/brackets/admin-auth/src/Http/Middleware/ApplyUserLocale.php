<?php

namespace Brackets\AdminAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplyUserLocale
{
    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * ApplyUserLocale constructor.
     */
    public function __construct()
    {
        $this->guard = config('admin-auth.defaults.guard');
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard($this->guard)->check() && isset(Auth::guard($this->guard)->user()->language)) {
            app()->setLocale(Auth::guard($this->guard)->user()->language);
        }

        return $next($request);
    }
}
