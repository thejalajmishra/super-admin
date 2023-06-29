@extends('layouts.guest')
@section('contents')
    <p class="login-box-msg">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
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
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Email Password Reset Link') }}</button>
            </div>
        </div>
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
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a valid email address"
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
