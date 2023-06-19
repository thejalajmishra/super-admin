@extends('layouts.app')
@section('page-style')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
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
                    {{-- @can('users create') --}}
                        <a href="{{ url('users/create') }}" class="btn btn-success float-right">Add New <i class="nav-icon fas fa-plus"></i></a>
                    {{-- @endcan --}}
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
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <select name="per_page" id="status" class="form-control frm_fields">
                                                    <option {{ $request->per_page == '5' ? 'selected' : '' }} value="5">Per Page 5</option>
                                                    <option {{ $request->per_page == '10' ? 'selected' : '' }} value="10">Per Page 10</option>
                                                    <option {{ $request->per_page == '20' ? 'selected' : '' }} value="20">Per Page 20</option>
                                                    <option {{ $request->per_page == '50' ? 'selected' : '' }} value="50">Per Page 50</option>
                                                    <option {{ $request->per_page == '100' ? 'selected' : '' }} value="100">Per Page 100</option>
                                                    <option {{ $request->per_page == '200' ? 'selected' : '' }} value="200">Per Page 200</option>
                                                    <option {{ $request->per_page == '500' ? 'selected' : '' }} value="500">Per Page 500</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users)
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
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->mobile }}</td>
                                                <td>{{ $user->roles->pluck('name')[0] ?? '' }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td><span class="tag tag-success">Approved</span></td>
                                                <td>
                                                    <a href="{{ url('users/' . $user->id . '/edit') }}" title="Edit User"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                                    <a href="{{ url('users/' . $user->id . '/delete') }}" title="Delete User"><i class="fas fa-trash danger" aria-hidden="true"></i></a>
                                                    <a href="{{ url('users/' . $user->id . '/permissions') }}" title="Edit User Permissions"><i class="fas fa-lock"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
    <!-- Toastr -->
    <script src="/plugins/toastr/toastr.min.js"></script>
    @if (session()->has('message'))
        <script>
            $(document).Toasts('create', {
                title: 'Success',
                position: 'topLeft',
                body: '{{ session()->get('message') }}'
            });
        </script>
    @endif
    <script>
        $(".frm_fields").on("change", function() {
            $("#frm_filter").submit();
        });
    </script>
@endsection