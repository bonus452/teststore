@extends('layouts.app')

@section('CenterTitle', 'Login & Register')

@section('content')

    <div class="htc__login__register bg__white ptb--130">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <ul class="login__register__menu" role="tablist">
                        <li role="presentation" class="login active"><a href="#login" role="tab" data-toggle="tab"
                                                                        aria-expanded="true">Login</a></li>
                        <li role="presentation" class="register"><a href="#register" role="tab" data-toggle="tab"
                                                                    aria-expanded="false">Register</a></li>
                    </ul>
                </div>
            </div>
            <!-- Start Login Register Content -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="htc__login__register__wrap">
                        <!-- Start Single Content -->
                        <div id="login" role="tabpanel" class="single__tabs__panel tab-pane fade active in">
                            <form class="login" method="POST" action="{{ route('login') }}">
                                @csrf

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                       @error('email') class="is-invalid" @enderror  placeholder="Email*">


                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="password" id="password" name="password"
                                       @error('password') class="is-invalid"
                                       @enderror placeholder="Password*">

                                <div class="tabs__checkbox">
                                    <input type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span> Remember me</span>
                                    @if (Route::has('password.request'))
                                        <span class="forget"><a href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a></span>
                                    @endif
                                </div>
                                <div class="htc__login__btn mt--30">
                                    <button type="submit">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                            </form>


                            <div class="htc__social__connect">
                                <h2>Or Login With</h2>
                                <ul class="htc__soaial__list">
                                    <li><a class="bg--twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>

                                    <li><a class="bg--instagram" href="#"><i class="zmdi zmdi-instagram"></i></a></li>

                                    <li><a class="bg--facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>

                                    <li><a class="bg--googleplus" href="#"><i class="zmdi zmdi-google-plus"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Content -->
                        <!-- Start Single Content -->
                        <div id="register" role="tabpanel" class="single__tabs__panel tab-pane fade">
                            <form class="login" method="POST" action="{{ route('register') }}">
                                @csrf

                                @include('include.error_message', ['field' => 'name'])
                                <input id="name" type="text"
                                       @error('name') class="is-invalid" @enderror name="name"
                                       value="{{ old('name') }}" required autocomplete="name" autofocus
                                       placeholder="Name*">

                                @include('include.error_message', ['field' => 'email'])
                                <input id="email" type="email"
                                       @error('email') class="is-invalid" @enderror name="email"
                                       value="{{ old('email') }}" required autocomplete="email" placeholder="Email*">

                                @include('include.error_message', ['field' => 'password'])
                                <input id="password" type="password"
                                       @error('password') class="is-invalid" @enderror name="password"
                                       required placeholder="Password*">

                                @include('include.error_message', ['field' => 'password'])
                                <input id="password-confirm" type="password"
                                       name="password_confirmation" required placeholder="Password confirm*">

                                <div class="htc__login__btn">
                                    <button type="submit">register</button>
                                </div>


                            </form>

                            <div class="htc__social__connect">
                                <h2>Or Login With</h2>
                                <ul class="htc__soaial__list">
                                    <li><a class="bg--twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a class="bg--instagram" href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a class="bg--facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a class="bg--googleplus" href="#"><i class="zmdi zmdi-google-plus"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Content -->
                    </div>
                </div>
            </div>
            <!-- End Login Register Content -->
        </div>
    </div>

@endsection
