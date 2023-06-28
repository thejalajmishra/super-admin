@extends('layouts.app')
@section('contents')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $pagetitle ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    @can('roles.index')
                    <a href="{{ url('roles/lists') }}" class="btn btn-success float-right">List Roles <i class="nav-icon fas fa-users"></i></a>
                    @endcan
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
                            <h3 class="card-title">Fill Role Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form name="frm_roles_create" id="frm_roles_create" action="{{ url('roles/store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Role Name here">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Role Description</label>
                                    <input type="text" name="description" id="description" value="{{old('description')}}" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Role Description here">
                                    @error('description')
                                        <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guard_name">Guard Name</label>
                                            <select name="guard_name" id="guard_name" class="form-control @error('guard_name') is-invalid @enderror">
                                                <option value="">Select Option</option>
                                                <option {{ old('guard_name') == 'web' ? 'selected' : '' }} value="web">WEB</option>
                                                <option {{ old('guard_name') == 'api' ? 'selected' : '' }} value="api">API</option>
                                            </select>
                                            @error('guard_name')
                                                <span id="guard_name-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                <option value="">Select Option</option>
                                                <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Active</option>
                                                <option {{ old('status') == '0' ? 'selected' : '' }} value="0">In-Active</option>
                                            </select>
                                            @error('status')
                                                <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
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
            $('#frm_roles_create').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    guard_name: {
                        required: true
                    },
                    status: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter a role name"
                    },
                    description: {
                        required: "Please enter a role description"
                    },
                    guard_name: {
                        required: "Please select guard"
                    },
                    status: {
                        required: "Please select status"
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
