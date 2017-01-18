<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class Flow
{
    private $rule = array(
        'province_quota' => array(
            'application' => array(
                'home' => ['get' => true],
                'info' => ['get' => true],
                'parent' => ['get' => true],
                'address' => ['get' => true],
                'education' => ['get' => true],
                'plan' => ['get' => true],
                'documents' => ['get' => true],
                'change_password' => ['get' => true],
                'quota_confirm' => ['get' => true],
            ),
            'api' => array(
                'v1' => array(
                    'applicant' => array(
                        'data' => ['post' => true],
                        'parent_info' => ['post' => true],
                        'address' => ['post' => true],
                        'education_history' => ['post' => true],
                        'plan_selection' => ['post' => true],
                        'documents_upload' => array(
                            'image' => ['post' => true],
                            'citizen_card' => ['post' => true],
                            'transcript' => ['post' => true],
                            'student_hr' => ['post' => true],
                            'gradecert' => ['post' => true],
                        ),
                        'documents_confirm' => ['post' => true],
                        'submit_quota' => ['post' => true],
                        'change_password' => ['post' => true],
                    ),
                ),
            ),
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
            'home',
            'change_password'
        ),
        'close'=> array(
            'home',
            'change_password'
        ),
        'view_only' => array(
            'application' => array(
                'home' => ['get' => true],
            ),
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
        $path = explode('/', $request->path());

        try{
            $previous = $this->rule[Config::get('uiconfig.mode')];
            for($i=0;$i<count($path);$i++){
                $current = $previous[$path[$i]];
                $previous = $current;
            }

            if($current[strtolower($request->method())] === true){
                return $next($request);
            }else{
                abort(404);
            }
        }catch(\ErrorException $e){
            abort(404);
        }
    }
}
