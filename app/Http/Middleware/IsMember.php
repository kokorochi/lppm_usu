<?php

namespace App\Http\Middleware;

use App\Dedication_partner;
use App\Propose;
use App\Http\Controllers\BlankonController;
use Closure;
use View;
use Illuminate\Support\Facades\Auth;
use App\Auths;

class IsMember extends BlankonController {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->type == 1){
            $dedication_partner = Dedication_partner::find($request->id);
            if ($dedication_partner !== null)
            {
                if (! $dedication_partner->propose()->first()->member()->where('nidn', Auth::user()->nidn)->exists() &&
                    ! $dedication_partner->propose()->first()->created_by === Auth::user()->nidn)
                {
                    array_push($this->css['themes'], 'admin/css/pages/error-page.css');
                    View::share('css', $this->css);
                    View::share('js', $this->js);
                    View::share('title', 'ERROR 403 | ' . $this->mainTitle);
                    return abort('403');
                }
            }
        }elseif($request->type == 2 || $request->type == 3){
            $propose = Propose::find($request->id);
            if ($propose !== null)
            {
                if (! ($propose->member()->where('nidn', Auth::user()->nidn)->exists()) &&
                    ! ($propose->created_by === Auth::user()->nidn) &&
                    ! (Auths::where('user_id', Auth::user()->id)->where('auth_object_ref_id', '3')->exists()))
                {
                    array_push($this->css['themes'], 'admin/css/pages/error-page.css');
                    View::share('css', $this->css);
                    View::share('js', $this->js);
                    View::share('title', 'ERROR 403 | ' . $this->mainTitle);
                    return abort('403');
                }
            }
        }


        return $next($request);
    }
}
