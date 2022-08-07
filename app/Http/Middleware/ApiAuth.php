<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header('Authorization') != null){
            $user = User::where('api_token', str_replace('Bearer ','',$request->header('Authorization')))->first();
            if($user != null){
                return $next($request);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Token'
            ]);
        }
        return abort(404);
    }
}
