<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BlankonController;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Auths;
use View;

class IsOperator extends BlankonController {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((! Auths::where('user_id', Auth::user()->id)->where('auth_object_ref_id', '1')->exists()) &&
            (! Auths::where('user_id', Auth::user()->id)->where('auth_object_ref_id', '2')->exists())
        )
        {
            array_push($this->css['themes'], 'admin/css/pages/error-page.css');

            View::share('css', $this->css);
            View::share('js', $this->js);
            View::share('title', 'ERROR 403 | ' . $this->mainTitle);

            return abort('403');
        }

        return $next($request);
    }
}
