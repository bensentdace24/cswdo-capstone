@extends('layouts.app')

@section('content')

<div class="content-wrapper bg-gray-50 min-h-screen">
    {{-- Header Section: Aligned with Admin List --}}
    <section class="content-header pt-4 pb-2">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-sm-6">
                    <h1 class="text-3xl font-semibold text-gray-800">
                        Staff List <span class="text-sm font-medium text-gray-500 ml-2">(Total: {{ $getRecord->total() }})</span>
                    </h1>
                </div>

                <div class="col-sm-6 text-right">
                    {{-- 'ADD STAFF' button is explicit and primary --}}
                    <a href="{{ url('admin/staff/add') }}"
                        class="btn btn-primary bg-blue-600 hover:bg-blue-700 border-none rounded-lg shadow-md transition duration-150 ease-in-out"
                        title="Add New Staff"
                        style="font-size: 1rem; padding: 10px 20px;">
                        <i class="fas fa-user-plus mr-1"></i>
                        Add New Staff
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Main content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    {{-- Search/Filter Card: Aligned with Admin List's filter card --}}
                    <div class="card shadow-sm border-t-4" style="border-top-color: #007bff; border-radius: 8px;">
                        <div class="card-header bg-white border-b-0" style="padding: 15px 20px;">
                            <h3 class="card-title text-lg font-medium text-gray-700">Filter Staff</h3>
                        </div>
                        <form method="get" action="">
                            <div class="card-body" style="padding-top: 5px;">
                                <div class="row align-items-end">

                                    <div class="form-group col-md-3">
                                        <label class="text-sm font-medium text-gray-600">Name</label>
                                        {{-- Increased padding for better visual match --}}
                                        <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="Search by Name" style="padding: 10px 12px; border-radius: 6px;">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="text-sm font-medium text-gray-600">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ Request::get('email') }}" placeholder="Search by Email" style="padding: 10px 12px; border-radius: 6px;">
                                    </div>

                                    <div class="form-group col-md-3 d-flex align-items-end" style="padding-bottom: 5px;">
                                        {{-- Primary Action Button Style --}}
                                        <button class="btn btn-primary bg-blue-600 hover:bg-blue-700 border-none mr-2 shadow-sm" type="submit" title="Search" style="border-radius: 6px; padding: 8px 15px;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        {{-- Secondary Action Button Style --}}
                                        <a href="{{ url('admin/staff/list') }}" class="btn btn-outline-secondary border-gray-300 hover:bg-gray-100" title="Reset" style="border-radius: 6px; padding: 8px 15px;">
                                            <i class="fas fa-sync-alt"></i> Reset
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>


                    @include('_message')

                    {{-- Staff List Table: Clean, modern appearance --}}
                    <div class="card shadow-sm" style="border-radius: 8px;">
                        <div class="card-header bg-white border-b" style="padding: 15px 20px;">
                            <h3 class="card-title text-xl font-medium text-gray-800">Staff List</h3>
                        </div>

                        <div class="card-body p-0" style="overflow: auto;">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057;">#</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057;">Name</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057;">Email</th>
                                        {{-- UX IMPROVEMENT: Added Role column, consistent with Admin List --}}
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057;">Role</th>
                                        {{-- Consistent Column Name --}}
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057;">Created At</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getRecord as $value)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        <td style="padding: 12px 20px;">{{ $value->id }}</td>
                                        {{-- Combined Name for better display --}}
                                        <td style="padding: 12px 20px;">{{ $value->name }} {{ $value->last_name }}</td>
                                        <td style="padding: 12px 20px;">{{ $value->email }}</td>

                                        {{-- Placeholder Role Display --}}
                                        <td style="padding: 12px 20px;">
                                            {{-- Assume role is available via $value->role --}}
                                            <span style="background-color: #ffc107; color: #343a40; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                                                Case Officer
                                            </span>
                                        </td>

                                        {{-- Consistent Date Format --}}
                                        <td style="padding: 12px 20px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>

                                        <td style="padding: 12px 20px; min-width: 150px;">
                                            {{-- Edit Button (Using Dashboard Orange/Blue for consistency) --}}
                                            <a href="{{ url('admin/staff/edit/'.$value->id) }}"
                                                class="btn btn-sm btn-primary"
                                                title="Edit"
                                                style="background-color: #ffc107; border-color: #ffc107; color: #343a40; border-radius: 4px; padding: 6px 10px; margin-right: 5px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Delete Button --}}
                                            <a onclick="return confirm('Are you sure you want to delete this staff?')"
                                                href="{{ url('admin/staff/delete/'.$value->id) }}"
                                                class="btn btn-sm btn-danger"
                                                title="Delete"
                                                style="background-color: #dc3545; border-color: #dc3545; border-radius: 4px; padding: 6px 10px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-gray-500" style="padding: 20px;">No staff records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Footer: Consistent with Admin List --}}
                        <div class="card-footer clearfix border-t bg-white" style="padding: 15px 20px; border-radius: 0 0 8px 8px;">
                            <div class="float-right">
                                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            </div>
                            <div class="float-left pt-2 text-sm text-gray-600">
                                @if($getRecord->total() > 0)
                                    Showing {{ $getRecord->firstItem() }} to {{ $getRecord->lastItem() }} of {{ $getRecord->total() }} entries
                                @else
                                    No entries to show.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection