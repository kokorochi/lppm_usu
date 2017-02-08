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
        <form class="sign-in form-horizontal shadow rounded no-overflow submit-form" action="{{url('user/reset')}}" method="post">
            <div class="sign-header">
                <div class="form-group">
                    <div class="sign-text">
                        <span>Ubah Password</span>
                    </div>
                </div><!-- /.form-group -->
            </div><!-- /.sign-header -->
            <div class="sign-body">
                <div class="form-group">
                    <div class="input-group input-group-lg rounded no-overflow">
                        <input type="password" class="form-control input-sm" placeholder="Password" name="password"
                               value="{{ old('password') }}">
                        @if($errors->has('password'))
                            <label id="password-confirm-error" class="error" for="password" style="display: inline-block;">
                                {{$errors->first('password')}}
                            </label>
                        @endif
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    </div>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <div class="input-group input-group-lg rounded no-overflow">
                        <input type="password" class="form-control input-sm" placeholder="Konfirmasi password"
                               name="password_confirmation">
                        @if($errors->has('password_confirmation'))
                            <label id="password-error" class="error" for="password_confirmation"
                                   style="display: inline-block;">
                                {{$errors->first('password_confirmation')}}
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
                    <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded submit" id="login-btn">
                        Simpan
                    </button>
                </div><!-- /.form-group -->
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
            </div><!-- /.sign-footer -->
        </form><!-- /.form-horizontal -->
        <!--/ Login form -->

        <!-- Content text -->
    {{--<p class="text-muted text-center sign-link">Belum punya akun? Hubungi Tim PSI</p>--}}
    <!--/ Content text -->

    </div><!-- /#sign-wrapper -->
@stop
<!--/ END SIGN WRAPPER -->
