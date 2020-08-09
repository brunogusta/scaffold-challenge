<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class Teacher
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
        $user = Auth::user();

        if(!$user->teacher) {
          return response()->json('[error] => User must be a teacher to execute this action.', 401);
        }

        return $next($request);
    }
}
