@extends('layouts.guest')
@section('contents')
    <p class="login-box-msg">Sign up to start your session</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- First Name -->
        <div class="input-group mb-3">
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter First Name here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            @error('first_name')
                <span id="first_name-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <!-- Last Name -->
        <div class="input-group mb-3">
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter Last Name here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            @error('last_name')
                <span id="last_name-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <!-- Email Address -->
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
        <!-- Mobile -->
        <div class="input-group mb-3">
            <input type="tel" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{old('mobile')}}" required autofocus autocomplete="mobile" placeholder="Enter your Mobile Number here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('mobile')
                <span id="mobile-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <!-- Password -->
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}" required autofocus autocomplete="password" placeholder="Enter your Password here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('password')
                <span id="password-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <!-- Confirm Password -->
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{old('password_confirmation')}}" required autofocus autocomplete="password" placeholder="Enter your confirm password here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('password_confirmation')
                <span id="password_confirmation-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                    <label for="agreeTerms">I agree to the terms</label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
            </div>
        </div>
        <a href="{{ route('login') }}" class="text-center">{{ __('Already registered? Login Here') }}</a>
    </form>
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
                    password_confirmation: {
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
                    password_confirmation: {
                        required: "Please provide a confirmation password",
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
