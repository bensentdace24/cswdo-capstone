@extends('layouts.app')

@section('style')
    <style>
        .content-wrapper {
            background-color: #f5f6fa;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(30, 45, 60, 0.08);
            border: 1px solid rgba(20, 35, 60, 0.05);
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: 700;
            color: #1f4e8a;
        }

        /* Search Filters UI */
        .search-card {
            margin-bottom: 25px;
            padding: 0;
        }

        .search-card .card-header {
            background-color: white !important;
            border-bottom: 1px solid #e0e0e0 !important;
            padding: 15px 25px;
        }

        .filter-title {
            font-size: 1rem;
            font-weight: 600;
            color: #343a40;
            margin: 0;
        }

        .filter-row {
            padding: 20px 25px;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            height: 40px;
            border-color: #e0e0e0;
            box-shadow: none !important;
        }

        .btn-search {
            background-color: #0794f1;
            border-color: #0794f1;
            color: #fff;
            height: 40px;
            font-weight: 600;
            width: 100%;
            border-radius: 6px;
        }

        .btn-reset {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            color: #343a40;
            height: 40px;
            font-weight: 600;
            width: 100%;
            border-radius: 6px;
        }

        /* Add Client button */
        .add-client-button-final {
            background-color: #0794f1 !important;
            border-color: #0794f1 !important;
            font-size: 1.2rem;
            padding: 10px 15px;
            border-radius: 8px;
            color: #fff !important;
            font-weight: 500;
        }

        /* Table UI */
        .client-table thead th {
            background-color: #f3f6fa;
            color: #576574;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }

        .client-table tbody tr:hover {
            background-color: #fcfcfc;
        }

        .client-table tbody td {
            border-top: 1px solid #eee;
            vertical-align: middle;
        }

        /* Badge styling */
        .badge-4ps-yes,
        .badge-eligible {
            background-color: #28a745;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .badge-4ps-no,
        .badge-not-eligible {
            background-color: #6c757d;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .pagination .page-item.active .page-link {
            background-color: #34495e;
            border-color: #34495e;
        }

        .btn-action-dropdown {
            background-color: #007bff;
            border-color: #34495e;
            color: #fff;
            border-radius: 6px;
        }

        .card-header-dark {
            background-color: #34495e !important;
            color: #fff;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Title -->
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1>Client List (Total: {{ $getRecord->total() }})</h1>

                <a href="{{ url('admin/client/add') }}" class="btn add-client-button-final shadow-sm" data-toggle="tooltip">
                    <i class="fas fa-plus"></i> Add Client
                </a>
            </div>
        </section>

        <!-- Page Content -->
        <section class="content">
            <div class="container-fluid">

                @include('_message')

                <!-- Search Filters -->
                <div class="card search-card">
                    <div class="card-header">
                        <h3 class="filter-title"><i class="fas fa-filter me-2"></i> Filters</h3>
                    </div>

                    <form method="get" action="{{ url('admin/client/list') }}">
                        <div class="card-body p-0">
                            <div class="row filter-row g-2">

                                <div class="form-group col">
                                    <input type="text" class="form-control" name="full_name"
                                        value="{{ Request::get('full_name') }}" placeholder="Full Name">
                                </div>

                                <div class="form-group col-md-1">
                                    <input type="text" class="form-control" name="age"
                                        value="{{ Request::get('age') }}" placeholder="Age">
                                </div>

                                <div class="form-group col-md-2">
                                    <select class="form-control" name="sex">
                                        <option value="">Sex</option>
                                        <option value="Male" {{ Request::get('sex') == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ Request::get('sex') == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <select class="form-control" name="is_4ps">
                                        <option value="">4Ps Member</option>
                                        <option value="1" {{ Request::get('is_4ps') == '1' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ Request::get('is_4ps') == '0' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <select class="form-control" name="is_ips">
                                        <option value="">IPs Member</option>
                                        <option value="1" {{ Request::get('is_ips') == '1' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ Request::get('is_ips') == '0' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-1 d-grid">
                                    <button class="btn btn-search" type="submit"><i class="fas fa-search"></i></button>
                                </div>

                                <div class="form-group col-md-1 d-grid">
                                    <a href="{{ url('admin/client/list') }}" class="btn btn-reset">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <!-- Client Table -->
                <div class="card shadow-sm">
                    <div class="card-header card-header-dark">
                        <h3 class="card-title">Client List</h3>
                    </div>

                    <div class="card-body p-0" style="min-height: 400px;">
                        <table class="table client-table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th class="text-center">4Ps</th>
                                    <th class="text-center">IPs</th>
                                    <th class="text-center">Eligibility</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->full_name }}</td>
                                        <td>{{ $value->age }}</td>
                                        <td>{{ $value->sex }}</td>

                                        <td class="text-center">
                                            <span class="{{ $value->is_4ps ? 'badge-4ps-yes' : 'badge-4ps-no' }}">
                                                {{ $value->is_4ps ? 'Yes' : 'No' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="{{ $value->is_ips ? 'badge-4ps-yes' : 'badge-4ps-no' }}">
                                                {{ $value->is_ips ? 'Yes' : 'No' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @if ($value->eligibility_status)
                                                <span class="badge badge-eligible">Eligible</span>
                                            @else
                                                <span class="badge badge-not-eligible">
                                                    Not Eligible ({{ $value->days_until_eligible }} days left)
                                                </span>
                                            @endif
                                        </td>


                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button"
                                                    class="btn btn-sm btn-action-dropdown dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/client/edit/' . $value->id) }}">✏️ Edit</a>
                                                    <a class="dropdown-item" onclick="return confirm('Are you sure?')"
                                                        href="{{ url('admin/client/delete/' . $value->id) }}">🗑️
                                                        Delete</a>

                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/client/show/' . $value->id) }}">👁️ View
                                                        Info's</a>

                                                    <div class="dropdown-divider"></div>

                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/client_dependents/list/' . $value->id) }}">👪
                                                        View Dependent/s</a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/client_assistance_logs/add/' . $value->id) }}">📝
                                                        Log Assistance</a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/client_verification/list/' . $value->id) }}">📋
                                                        View Beneficiaries</a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('client.requirements', $value->id) }}">🧾 View
                                                        Checklist</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                        <div class="mt-2" style="float:right;">
                            {!! $getRecord->appends(request()->except('page'))->links() !!}
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection
