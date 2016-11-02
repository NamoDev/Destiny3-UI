<?php

namespace App\Http\Middleware;

use Applicant;
use Closure;

class APIAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $applicant = new Applicant();
        if ($applicant->isLoggedIn()) {
            return $next($request);
        } else {
            // TODO: Maybe do a RESTResponse?
            return response(json_encode(["status" => "unauthorized"], JSON_UNESCAPED_UNICODE), 401);
        }
    }
}
