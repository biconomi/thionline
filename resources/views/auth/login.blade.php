@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center ht-100v">
    <img src="{{asset('adminlte/login/img22.jpg')}}" class="wd-100p ht-100p object-fit-cover" alt="">
    <div class="overlay-body bg-black-6 d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 rounded bd bd-white-2 bg-black-7">
            <div class="signin-logo tx-center tx-28 tx-bold tx-white"><span class="tx-normal">[</span> Nguyen <span class="tx-info">Nha</span> <span class="tx-normal">]</span></div>
            <div class="tx-white-5 tx-center mg-b-60" style="margin-bottom: 30px !important">By Nguyen Nha 2019</div>

            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control fc-outline-dark" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your username">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong><p style="color: red !important">Đăng nhập không thanh công</p></strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">


                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control fc-outline-dark" name="password" required placeholder="Enter your password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-info btn-block">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
        </div><!-- login-wrapper -->
    </div><!-- overlay-body -->
</div><!-- d-flex -->
</div>
@endsection
