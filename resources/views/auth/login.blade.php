@extends('layouts.main')
@section('title')
    ChipTranz | Login to ChipTranz
@endsection
@section('main-content')
<div  class="container-scroller">


    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-5 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                           <a href="{{url('/')}}"> <img src="{{asset('chiptranz-vendors/images/logo.svg')}}" alt="logo"/></a>
                        </div>
                        <h4>Welcome to ChipTranz, </h4>
                        <h6 class="font-weight-light">{{ __('Login') }} to continue.</h6>
                        <form class="pt-3" method="POST" action="{{ route('login') }}">

                            @csrf

                            <div class="form-group row">

                                <div class="col-md-12">
                                <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="account@mail.com" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">
                                <label for="password" class=" col-form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 offset-md-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- page-body-wrapper ends -->
</div>
@endsection
<!-- container-scroller -->

















<!-- plugins:js -->

@section('main-scripts')
<!--Import main scripts here -->


<!-- endinject -->
@endsection










