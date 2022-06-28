@extends('layouts.app')

@section('content')

    <div class="htc__login__register bg__white ptb--130">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <ul class="login__register__menu" role="tablist">
                        <li role="presentation" class="login active"><a href="javascript:void(0);" class="not-click">Reset Password</a></li>
                    </ul>
                </div>
            </div>
            <!-- Start Login Register Content -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="htc__login__register__wrap">
                        <!-- Start Single Content -->
                        <div id="login" class="single__tabs__panel tab-pane fade active in">
                            @include('include.status_message', ['mark' => 'status'])
                            <form class="login" method="POST" action="{{ route('password.email') }}">
                                @csrf

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input id="email" type="email"
                                       @error('email') class="is-invalid" @enderror name="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Email*">

                                <div class="htc__login__btn mt--30">
                                    <button type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- End Single Content -->
                    </div>
                </div>
            </div>
            <!-- End Login Register Content -->
        </div>
    </div>






@endsection
