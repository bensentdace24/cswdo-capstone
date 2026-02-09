@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <h1 class="text-3xl font-semibold text-gray-800">
                        Admin List <span class="text-sm font-medium text-gray-500">(Total: {{ $getRecord->total() }})</span>
                    </h1>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{ url('admin/admin/add') }}"
                        class="btn btn-primary bg-blue-500 hover:bg-blue-600 border-none rounded-lg shadow-md transition duration-150 ease-in-out"
                        title="Add New Admin">
                        <i class="fas fa-user-plus mr-1"></i>
                        Add New Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card shadow-sm border-t-4 border-blue-500">
                        <div class="card-header bg-white border-b-0">
                            <h3 class="card-title text-lg font-medium text-gray-700">Filter Admins</h3>
                        </div>
                        <form method="get" action="">
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-3">
                                        <label class="text-sm font-medium text-gray-600">Name</label>
                                        <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="Search by Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-sm font-medium text-gray-600">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ Request::get('email') }}" placeholder="Search by Email">
                                    </div>
                                    <div class="form-group col-md-3 d-flex align-items-end pt-2">
                                        <button class="btn btn-primary bg-blue-500 hover:bg-blue-600 border-none mr-2 shadow-sm" type="submit" title="Search">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ url('admin/admin/list') }}" class="btn btn-outline-secondary border-gray-300 hover:bg-gray-100" title="Reset">
                                            <i class="fas fa-sync-alt"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @include('_message')

                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-b">
                            <h3 class="card-title text-xl font-medium text-gray-800">Admin List</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover text-gray-700">
                                <thead>
                                    <tr>
                                        <th class="border-b-2">#</th>
                                        <th class="border-b-2">Name</th>
                                        <th class="border-b-2">Email</th>
                                        <th class="border-b-2">Role</th>
                                        <th class="border-b-2">Created At</th>
                                        <th class="border-b-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getRecord as $value)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>

                                        <td>
                                            <span class="badge badge-success bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                                                Super Admin
                                            </span>
                                        </td>

                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>

                                        <td>
                                            <a onclick="return confirm('Are you sure you want to delete this admin?')"
                                                href="{{ url('admin/admin/delete/'.$value->id) }}"
                                                class="btn btn-sm btn-danger bg-red-600 hover:bg-red-700 border-none"
                                                title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-gray-500">No admin records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer clearfix border-t bg-white">
                            <div class="float-right">
                                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            </div>
                            <div class="float-left pt-2 text-sm text-gray-600">
                                Showing {{ $getRecord->firstItem() }} to {{ $getRecord->lastItem() }} of {{ $getRecord->total() }} entries
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection