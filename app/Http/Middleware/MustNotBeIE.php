<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Response;

class MustNotBeIE{

    /**
     * Agent instance
     *
     * @var Jenssegers\Agent\Agent
      */
    private $agent;

    /**
     * Construct class
     *
     * @param
     * @return void
     */
    public function __construct(Agent $agent){
        $this->agent = $agent;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if($this->agent->browser() == 'IE'){
            return new Response(view('errors.unsupported_browser'));
        }

        return $next($request);
    }
}
