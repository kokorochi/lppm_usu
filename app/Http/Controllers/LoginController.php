<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use Monolog\Handler\IFTTTHandler;
use View;
use App\Auths;

class LoginController extends BlankonController {

    protected $redirectTo = '/';
    private $pageTitle = 'Sign In';

    public function __construct()
    {
        parent::__construct();

        array_push($this->css['themes'], 'admin/css/pages/sign.css');

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');

        array_push($this->js['scripts'], 'admin/js/pages/blankon.sign.js');

        array_push($this->js['scripts'], 'global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js');

        // pass variable to view
        View::share('css', $this->css);
        View::share('js', $this->js);
        View::share('title', $this->pageTitle . ' | ' . $this->mainTitle);
    }

    public function showLoginForm()
    {
        if (Auth::user())
        {
            return redirect()->intended('/');
        }

        return view('user.signin');
    }

    public function doLogin(Requests\LoginRequest $request)
    {
        Auth::user()->userAuths = Auths::find(Auth::user()->id);

        return redirect()->intended('/');
    }

    public function doLogout()
    {
        if (Auth::user())
        {
            unset($this->v_auths);
            Auth::logout();
        }

        return redirect()->intended('/');
    }

    public function reset()
    {
        if (Auth::user())
        {
            return view('user.reset');
        } else
        {
            return redirect()->intended('/');
        }
    }

    public function doReset(Requests\StoreResetPasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->intended('/');
    }
}