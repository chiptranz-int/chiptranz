@extends('layouts.main')

@section('title')
    ChipTranz | Sign up for a ChipTranz account
    @endsection

@section('main-content')

    <div class="container-scroller">
        <div class="container-fluid  page-body-wrapper full-page-wrapper">
            <div class="content-wrapper  d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-6 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <a href="{{url('/')}}"> <img src="{{asset('chiptranz-vendors/images/logo.svg')}}"
                                                             alt=" ChipTranz logo"/></a>
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">

                                    <div class="col-md-6">
                                        <label for="name" class="col-form-label"> {{ __('First Name') }}</label>
                                        <input id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name" class="col-form-label"> {{ __('Last Name') }}</label>
                                        <input id="last_name" type="text"
                                               class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                               value="{{ old('last_name') }}" required autocomplete="last_name"
                                               autofocus>

                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="telephone" class="col-form-label">{{ __('Telephone') }}</label>
                                        <input id="telephone" type="number"
                                               class="form-control @error('telephone') is-invalid @enderror"
                                               name="telephone" value="{{ old('telephone') }}" required
                                               autocomplete="telephone">

                                        @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-6">
                                        <label for="password" class=" col-form-label">{{ __('Password') }}</label>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password-confirm"
                                               class=" col-form-label ">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="code" class="col-form-label">Code Verification</label>
                                        <div class="row col-sm">
                                            <div id="code-area"
                                                 class="col-md-6 bg-google text-white font-italic h3 text-center pt-2 cm-strikethrough"></div>
                                            <i id="refresh" class="mdi mdi-refresh btn">Refresh</i>
                                        </div>
                                        <input id="code" placeholder="Enter the code above" type="number"
                                               class="form-control  @error('code') is-invalid @enderror" name="code" required autocomplete="code">
                                        <input id="code-confirm" type="hidden" class="form-control"
                                               name="code_confirmation">

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                         <strong id="wrong-code">{{$message}}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="form-group row  float-md-right">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
@endsection
@section('main-scripts')
    <script>

        let codeArea = document.querySelector("#code-area");
        let codeConfirm = document.querySelector("#code-confirm");
        let wrongCode = document.querySelector("#wrong-code");
        let refresh = document.querySelector("#refresh");

        let button = document.querySelector("button[type=submit]");

        generateCode();

        function generateCode() {


            let randomCode = Math.round(Math.random() * 10000);

            codeConfirm.value = randomCode;

            codeArea.innerText = randomCode;
            button.setAttribute("disabled", "disabled");
        }

        let code = document.querySelector("#code");

        code.addEventListener("keyup", function () {

            if (this.value == codeConfirm.value) {
                button.removeAttribute("disabled");
            } else {
                button.setAttribute("disabled", "disabled");
            }
        });

        button.addEventListener("submit", function (e) {
            if (code.value != codeConfirm.value) {
                e.preventDefault();

            }
        });

        refresh.addEventListener("click", function () {
            generateCode();
        })

    </script>
@endsection