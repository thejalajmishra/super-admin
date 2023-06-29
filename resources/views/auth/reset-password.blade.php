@extends('layouts.guest')
@section('contents')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <!-- Email Address -->
        <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email', $request->email)}}" required autofocus autocomplete="email" placeholder="Enter your Email Id here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <!-- Password -->
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
        <!-- Confirm Password -->
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"  required autocomplete="password_confirmation" placeholder="Enter Confirm Password here">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password_confirmation')
                <span id="password_confirmation-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
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
