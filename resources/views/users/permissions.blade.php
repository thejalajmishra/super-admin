@extends('layouts.app')
@section('page-style')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
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
                    @can('permissions.index')
                        <a href="{{ url('permissions/lists') }}" class="btn btn-success float-right">List Permissions <i class="nav-icon fas fa-users"></i></a>
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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Update "{{ $users->first_name }} {{ $users->last_name }}" Permissions Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form name="frm_roles_create" id="frm_roles_create" action="{{ url('users/update-permissions', $users->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                @if ($permissions)
                                    @foreach ($permissions as $key => $permission)
                                        <div class="form-group">
                                            <label for="permission-{{ $key }}">{{ strtoupper($key) }}</label>
                                        </div>
                                        @if ($permission)
                                            <div class="row">
                                                @foreach ($permission as $key1 => $val)
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" name="permissions[]" id="permission-{{ $key }}-{{ $key1 }}" {{ in_array($key.'.'.$val, $user_permissions) ? 'checked' : '' }} type="checkbox" value="{{ $key.'.'.$val }}">
                                                                <label class="custom-control-label" for="permission-{{ $key }}-{{ $key1 }}">{{ count($permission) > 1 ? strtoupper($val) : strtoupper($key) }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
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
@endsection
