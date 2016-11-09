<?php

namespace App\Http\Middleware;

use Closure;

class Flow
{
    private $rule = array(
        'province_quota' => array(
            'home',
            'info',
            'parent',
            'address',
            'education',
            'plan',
            'documents',
            'grade',
            'change_password'
        ),
        'normal' => array(
            'home',
            'info',
            'parent',
            'address',
            'education',
            'plan',
            'day',
            'documents',
            'change_password'
        ),
        'print_only' => array(
            'change_password'
        ),
        'close'=> array(
            'change_password'
        ),
    );

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        return $next($request);
    }
}
