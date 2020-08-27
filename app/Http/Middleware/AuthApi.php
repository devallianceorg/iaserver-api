<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Core\ApiLogin;
use Closure;

class AuthApi
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if($token) {
            $authApi = new ApiLogin();
            $user = $authApi->getUserData($token);

            // Puede que el API retorne un error
            if(isset($user['error'])) {
                session()->flush();
                return response()->json($user);
            } else {
                session()->put('token', $token);
                session()->put('user', $user);
                return $next($request);
            }
        }

        return response()->json(['error'=>'No se detecto un token valido']);
    }
}
