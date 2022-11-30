<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (method_exists($response, 'header')) {
             $response->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization')
                ->header('Access-Control-Allow-Origin', env('ACCESS_CONTROL_ALLOW_ORIGIN'))
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE');
        }
        return $response;
    }
}
