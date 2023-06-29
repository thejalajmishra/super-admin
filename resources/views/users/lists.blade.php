@extends('layouts.app')
@section('page-style')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection
@section('contents')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$pagetitle??''}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    @can('users.create')
                        <a href="{{ url('users/create') }}" class="btn btn-success float-right">Add New <i class="nav-icon fas fa-plus"></i></a>
                    @endcan
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users</h3>
                            <div class="card-tools">
                                <form id="frm_filter">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="input-group input-group-sm">
                                                <select name="per_page" id="status" class="form-control frm_fields">
                                                    <option {{ $request->per_page == '5' ? 'selected' : '' }} value="5">5 Per Page</option>
                                                    <option {{ $request->per_page == '10' ? 'selected' : '' }} value="10">Per Page 10</option>
                                                    <option {{ $request->per_page == '20' ? 'selected' : '' }} value="20">Per Page 20</option>
                                                    <option {{ $request->per_page == '50' ? 'selected' : '' }} value="50">Per Page 50</option>
                                                    <option {{ $request->per_page == '100' ? 'selected' : '' }} value="100">Per Page 100</option>
                                                    <option {{ $request->per_page == '200' ? 'selected' : '' }} value="200">Per Page 200</option>
                                                    <option {{ $request->per_page == '500' ? 'selected' : '' }} value="500">Per Page 500</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="daterange" id="daterange" value="{{$request->daterange}}" class="form-control frm_fields">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-sm">
                                                <select name="roles" id="roles" class="form-control frm_fields">
                                                    <option {{ $request->per_page == '5' ? 'selected' : '' }} value="">Role</option>
                                                    @if($roles)
                                                        @foreach($roles as $role)
                                                            <option {{ $request->roles == $role->id ? 'selected' : '' }} value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-sm">
                                                <select name="status" id="status" class="form-control frm_fields">
                                                    <option value="">Status</option>
                                                    <option {{ $request->status == '1' ? 'selected' : '' }} value="1">Active</option>
                                                    <option {{ $request->status == '0' ? 'selected' : '' }} value="0">In-Active</option>
                                                    <option {{ $request->status == '2' ? 'selected' : '' }} value="2">Deleted</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="s" value="{{$request->s}}" class="form-control float-right frm_fields" placeholder="Search">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Date Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($users) && count($users) > 0)
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>
                                                    @if (isset($user->profile_picture) && !empty($user->profile_picture))
                                                        <img src="/{{ $user->profile_picture }}" class="img-circle elevation-2" height="40" width="40" />
                                                    @else
                                                        @if ($user->gender == 'M')
                                                            <img src="/dist/img/avatar5.png" class="img-circle elevation-2" height="40" width="40" />
                                                        @elseif ($user->gender == 'F')
                                                            <img src="/dist/img/avatar2.png" class="img-circle elevation-2" height="40" width="40" />
                                                        @else
                                                            <img src="/dist/img/avatar.png" class="img-circle elevation-2" height="40" width="40" />
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->mobile }}</td>
                                                <td>{{ $user->roles->pluck('name')[0] ?? '' }}</td>
                                                <td>
                                                    @if($user->deleted_at != NULL)
                                                        <div class="btn btn-xs btn-danger">
                                                            <span>Deleted</span>
                                                        </div>
                                                    @elseif($user->status != 1)
                                                        <div class="btn btn-xs btn-warning">
                                                            <span>In-Active</span>
                                                        </div>
                                                    @else
                                                        <div class="btn btn-xs btn-success">
                                                            <span>Active</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('jS F Y g:i:s A')}}</td>
                                                <td>
                                                    @can('users.edit')
                                                        <a href="{{ url('users/' . $user->id . '/edit') }}" title="Edit User" class="btn btn-xs btn-info">Edit</a>
                                                    @endcan
                                                    @can('users.delete')
                                                        <a href="{{ route('users.destroy', $user->id) }}" title="Delete User" class="btn btn-xs btn-danger" data-confirm-delete="true">Delete</a>
                                                    @endcan
                                                    @can('users.permissions')
                                                        <a href="{{ url('users/' . $user->id . '/permissions') }}" title="Edit User Permissions" class="btn btn-xs btn-success">Permissions</a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">No users found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="d-flex justify-content-end">
                        {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('page-script')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    @if (session()->has('message'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: '{{ session()->get("message") }}'
            });
        </script>
    @endif
    <script>
        var startdate = moment().startOf("month");
        var enddate = moment().endOf("month");
        $('#daterange').daterangepicker();
        $(".frm_fields").on("change", function() {
            $("#frm_filter").submit();
        });
    </script>
@endsection