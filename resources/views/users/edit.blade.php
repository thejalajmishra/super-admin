@extends('layouts.app')
@section('page-style')
    <style>
        .custom-radio-section {
            display: initial !important;
            padding-left: 2.5rem;
        }
        .form-group .custom-radio-section:first-child {
            padding-left: 1.5rem !important;
        }
        .form-group.pt-38 {
            padding-top: 38px;
        }
    </style>
@endsection
@section('contents')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $pagetitle ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    {{-- @can('users lists') --}}
                    <a href="{{ url('users/lists') }}" class="btn btn-success float-right">List Users <i class="nav-icon fas fa-users"></i></a>
                    {{-- @endcan --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @if (session()->has('message'))
        <div class="pt-5 duration-300 ease-in-out">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-200 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session()->get('message') }}</p>
                </div>
            </div>
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Fill User Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form name="frm_users_create" id="frm_users_create" action="{{ url('users/update/' . $users->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" name="first_name" id="first_name" value="{{$users->first_name}}" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter First Name here">
                                            @error('first_name')
                                                <span id="first_name-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" value="{{$users->last_name}}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter Last Name here">
                                            @error('last_name')
                                                <span id="last_name-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" name="email" id="email" value="{{$users->email}}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email here">
                                            @error('email')
                                                <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile Number</label>
                                            <input type="tel" name="mobile" id="mobile" value="{{$users->mobile}}" class="form-control @error('mobile') is-invalid @enderror" placeholder="Enter Mobile Number here">
                                            @error('mobile')
                                                <span id="mobile-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password here">
                                            @error('password')
                                                <span id="password-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_picture">Profile Picture</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="profile_picture" id="profile_picture">
                                                    <label class="custom-file-label" for="profile_picture">Choose Profile Picture</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                <option value="">Select Option</option>
                                                <option {{ $users->status == '1' ? 'selected' : '' }} value="1">Active</option>
                                                <option {{ $users->status == '0' ? 'selected' : '' }} value="0">In-Active</option>
                                            </select>
                                            @error('status')
                                                <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label><br>
                                            <div class="custom-control custom-radio custom-radio-section" style="padding-left: 1.5rem;">
                                                <input class="custom-control-input" type="radio" id="genderMale" {{$users->gender == 'M' ? 'checked' : ''}} value="M" name="gender" checked />
                                                <label for="genderMale" class="custom-control-label">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-radio-section">
                                                <input class="custom-control-input" type="radio" id="genderFemale" {{$users->gender == 'F' ? 'checked' : ''}} value="F" name="gender" />
                                                <label for="genderFemale" class="custom-control-label">Female</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-radio-section">
                                                <input class="custom-control-input" type="radio" id="genderOther" {{$users->gender == 'O' ? 'checked' : ''}} value="O" name="gender" />
                                                <label for="genderOther" class="custom-control-label">Other</label>
                                            </div>
                                            @error('gender')
                                                <span id="gender-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                                <option value="">Select Option</option>
                                                @if($roles)
                                                    @foreach($roles as $role)
                                                        <option {{ isset($users->roles->pluck('name')[0]) && $users->roles->pluck('name')[0] == $role->name ? 'selected' : '' }} value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('role')
                                                <span id="role-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pt-38">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" name="login_allowed" id="login_allowed" {{$users->login_allowed == '1' ? 'checked' : ''}} value="1">
                                                <label for="login_allowed" class="custom-control-label">Allow Login</label>
                                            </div>
                                            @error('login_allowed')
                                                <span id="login_allowed-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('page-script')
    <script src="/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script>
        $("form").attr('autocomplete', 'off');

        $(function() {
            $('#frm_users_create').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true,
                    },
                    status: {
                        required: true
                    },
                    role: {
                        required: true
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter a first name"
                    },
                    last_name: {
                        required: "Please enter a last name"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a valid email address"
                    },
                    mobile: {
                        required: "Please enter a mobile number"
                    },
                    status: {
                        required: "Please select status"
                    },
                    role: {
                        required: "Please select role"
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