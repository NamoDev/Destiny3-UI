<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Response;

class BrowserFilter{

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
        }else{
            $browser = $this->agent->browser();
            $version = $this->agent->version($browser);
            $version = explode('.', $version);

            if($browser == 'Chrome'){
                if($version[0] < 38){
                    return response()->view('unsupported_browser');
                }
            }else if($browser == 'Firefox'){
                if($version[0] < 33){
                    return response()->view('unsupported_browser');
                }
            }
        }

        return $next($request);
    }
}
