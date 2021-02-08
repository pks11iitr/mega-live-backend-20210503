<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LastActivityLogger
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
        $user=auth()->guard('customerapi')->user();
        $user->last_active=date('Y-m-d H:i:s');
        $user->save();
        return $next($request);
    }
}
