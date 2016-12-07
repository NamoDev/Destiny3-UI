<?php

namespace App\Http\Middleware;

use Applicant;
use Closure;

class MustBeLoggedIn {
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
			return redirect('/home')->with('message', 'NOT_LOGGED_IN')->with('alert-class', 'alert-warning');
		}
	}
}
