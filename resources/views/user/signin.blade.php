@extends('layouts.lay_account')

<!-- START @SIGN WRAPPER -->
@section('content')
    <div id="sign-wrapper">

        <!-- Brand -->
        <div class="brand">
            <a href="{{url('/')}}"><img src="{{$assetUrl}}images/Logo LPM USU 2.png" alt="brand logo"/></a>
        </div>
        <!--/ Brand -->

        <!-- Login form -->
        <form class="sign-in form-horizontal shadow rounded no-overflow" action="{{url('user/login')}}" method="post">
            <div class="sign-header">
                <div class="form-group">
                    <div class="sign-text">
                        <span>Member Area</span>
                    </div>
                </div><!-- /.form-group -->
            </div><!-- /.sign-header -->
            <div class="sign-body">
                <div class="form-group">
                    <div class="input-group input-group-lg rounded no-overflow">
                        <input type="text" class="form-control input-sm" placeholder="NIDN" name="nidn"
                               value="{{ old('nidn') }}">
                        @if($errors->has('nidn'))
                            <label id="username-error" class="error" for="nidn" style="display: inline-block;">
                                {{$errors->first('nidn')}}
                            </label>
                        @endif
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    </div>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <div class="input-group input-group-lg rounded no-overflow">
                        <input type="password" class="form-control input-sm" placeholder="Password" name="password">
                        @if($errors->has('password'))
                            <label id="password-error" class="error" for="password" style="display: inline-block;">
                                {{$errors->first('password')}}
                            </label>
                        @endif

                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    </div>
                </div><!-- /.form-group -->
            </div><!-- /.sign-body -->
            <div class="sign-footer">
                @if($errors->has('sumErrors'))
                    <div class="form-group">
                        <label id="login-error" class="error" for="password" style="display: inline-block;">
                            {{$errors->first('sumErrors')}}
                        </label>
                    </div>
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="ckbox ckbox-theme">
                                <input name="remember_me"id="rememberme" type="checkbox">
                                <label for="rememberme" class="rounded">Ingat saya</label>
                            </div>
                        </div>
                        {{--<div class="col-xs-6 text-right">--}}
                        {{--<a href="{{url('page/lost-password')}}" title="lost password">Lost password?</a>--}}
                        {{--</div>--}}
                    </div>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded" id="login-btn">
                        Masuk
                    </button>
                </div><!-- /.form-group -->
                {{ csrf_field() }}
            </div><!-- /.sign-footer -->
        </form><!-- /.form-horizontal -->
        <!--/ Login form -->

        <!-- Content text -->
        <p class="text-muted text-center sign-link">Belum punya akun? Hubungi Tim PSI</p>
        <!--/ Content text -->

    </div><!-- /#sign-wrapper -->
@stop
<!--/ END SIGN WRAPPER -->
