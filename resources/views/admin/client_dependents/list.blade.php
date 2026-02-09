@extends('layouts.app')

@section('content')

{{-- Set the neutral light background consistent across all admin screens --}}
<div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

    {{-- Header Section: Consistent Title and Button Style --}}
    <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    {{-- Adjusted H1 for thinner, less dominant text and smaller record count --}}
                    <h1 class="text-3xl font-semibold text-gray-800" style="font-size: 2rem; font-weight: 500; color: #333; display: inline-block; margin-right: 10px;">
                        {{ $header_title }}
                    </h1>
                    <span style="font-size: 1rem; color: #6c757d; font-weight: 400;">({{ $dependents->total() }} Records)</span>
                </div>

                <div class="col-sm-6 text-right d-flex justify-content-end align-items-center">
                    @isset($client)
                    <a href="{{ url('admin/client_dependents/add/' . $client->id) }}"
                        class="btn btn-primary"
                        style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 10px 20px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,123,255,0.2);">
                        <i class="fas fa-plus mr-1"></i> Add New Dependent
                    </a>
                    @endisset

                    <a href="{{ url('admin/client/list') }}"
                        class="btn btn-secondary"
                        style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 10px 20px;">
                        ← Back to Clients
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @include('_message')

                    {{-- Table Card: Clean, modern appearance --}}
                    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
                        <div class="card-header bg-white border-b" style="padding: 15px 20px;">
                            <h3 class="card-title text-xl font-medium text-gray-800" style="font-size: 1.5rem; font-weight: 40000;">List of Patient Dependents</h3>
                        </div>

                        <div class="card-body p-0" style="overflow-x: auto;">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">#</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Dependent Name</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Age</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Status</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Relationship</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Occupation</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Birthday</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Created At</th>
                                        <th style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 15px 20px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dependents as $dependent)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        <td style="padding: 12px 20px;">{{ $dependent->id }}</td>
                                        {{-- Keep Dependent Name Bold for prominence --}}
                                        <td style="padding: 12px 20px; font-weight: 600;">{{ $dependent->dependent_name }}</td>
                                        {{-- Set remaining data cells to normal or lighter weight --}}
                                        <td style="padding: 12px 20px; font-weight: 500; color: #333;">{{ $dependent->age }}</td>
                                        <td style="padding: 12px 20px; font-weight: 400; color: #555;">{{ $dependent->status }}</td>
                                        <td style="padding: 12px 20px; font-weight: 400; color: #555;">{{ $dependent->relationship }}</td>
                                        <td style="padding: 12px 20px; font-weight: 400; color: #555;">{{ $dependent->occupation }}</td>
                                        <td style="padding: 12px 20px; font-weight: 500; color: #333;">{{ date('d-m-Y', strtotime($dependent->birthday)) }}</td>
                                        <td style="padding: 12px 20px; font-weight: 400; color: #555;">{{ date('d-m-Y H:i A', strtotime($dependent->created_at)) }}</td>
                                        <td style="padding: 12px 20px;">
                                            <div class="d-flex">
                                                {{-- Action Buttons (Styles remain the same) --}}
                                                <a href="{{ url('admin/client_dependents/edit/' . $dependent->id) }}"
                                                    class="btn btn-sm"
                                                    title="Edit"
                                                    style="background-color: #007bff; border-color: #007bff; color: white; border-radius: 4px; padding: 6px 10px; margin-right: 8px; box-shadow: 0 1px 2px rgba(0,123,255,0.1);">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a onclick="return confirm('Are you sure you want to delete this patient dependent?')"
                                                    href="{{ url('admin/client_dependents/delete/' . $dependent->id) }}"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete"
                                                    style="background-color: #dc3545; border-color: #dc3545; color: white; border-radius: 4px; padding: 6px 10px; box-shadow: 0 1px 2px rgba(220,53,69,0.1);">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-gray-500" style="font-style: italic;">No dependents found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination Footer --}}
                            <div class="card-footer clearfix bg-white" style="padding: 15px 20px; border-radius: 0 0 12px 12px; border-top: 1px solid #eee;">
                                <div class="float-right">
                                    {!! $dependents->links() !!}
                                </div>
                                <div class="float-left pt-2 text-sm text-gray-600">
                                    @if($dependents->total() > 0)
                                        Showing 1 to {{ $dependents->count() }} of {{ $dependents->total() }} entries
                                    @else
                                        Showing 0 to 0 of 0 entries
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection