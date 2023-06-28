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
                    <h1 class="m-0">{{$pagetitle??''}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    @can('permissions.create')
                        <a href="{{ url('permissions/create') }}" class="btn btn-success float-right">Add New <i class="nav-icon fas fa-plus"></i></a>
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
                            <h3 class="card-title">permissions</h3>
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
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Guard</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($permissions)
                                		@foreach ($permissions as $key => $permission)
                                            <tr>
                                                <td>{{ $permission->id }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>{{ $permission->description }}</td>
                                                <td>{{ $permission->guard_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('jS F Y g:i:s A')}}</td>
                                                <td>
                                                    @if($permission->deleted_at != NULL)
                                                        <div class="bg-danger color-palette text-center">
                                                            <span>Deleted</span>
                                                        </div>
                                                    @elseif($permission->status != 1)
                                                        <div class="bg-warning color-palette text-center">
                                                            <span>In-Active</span>
                                                        </div>
                                                    @else
                                                        <div class="bg-primary color-palette text-center">
                                                            <span>Active</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('permissions.edit')
                                                        <a href="{{ url('permissions/' . $permission->id . '/edit') }}" title="Edit Permission" class="btn btn-xs btn-info">Edit</a>
                                                    @endcan
                                                    @can('permissions.delete')
                                                        <a href="{{ url('permissions/' . $permission->id . '/delete') }}" title="Delete Permission" class="btn btn-xs btn-danger" data-confirm-delete="true">Delete</a>
                                                    @endcan
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
                        {{ $permissions->withQueryString()->links('pagination::bootstrap-4') }}
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