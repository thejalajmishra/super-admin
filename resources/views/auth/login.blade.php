@extends('layouts.guest')
@section('contents')
    <p class="login-box-msg">Sign in to start your session</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" required autofocus autocomplete="email" placeholder="Enter your Email Id here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"  required autocomplete="password" placeholder="Enter Your Password here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span id="password-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember_me">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
        </div>
    </form>
    @if (Route::has('password.request'))
        <p class="mb-1">
            <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
        </p>
    @endif
    @if (Route::has('register'))
        <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
        </p>
    @endif
@endsection
@section('page-script')
    <script src="/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script>
        $("form").attr('autocomplete', 'off');
        $(function() {
            $('#frm_users_create').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
