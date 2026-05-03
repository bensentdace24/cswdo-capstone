@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1>Saved Acknowledgement Receipts</h1>
                <a href="{{ url('admin/ar/list') }}" class="btn btn-primary">← Back to AR Form</a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card p-4">


                    {{-- ✅ Month Filter --}}
                    <form method="GET" action="{{ url('admin/ar/viewing-list') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search_name" value="{{ request('search_name') }}"
                                    class="form-control" placeholder="Search by client name">
                            </div>

                            <div class="col-md-2">
                                <select name="type" class="form-control">
                                    <option value="">-- Type --</option>
                                    <option value="Medical" {{ request('type') == 'Medical' ? 'selected' : '' }}>Medical
                                    </option>
                                    <option value="Pharmacy" {{ request('type') == 'Pharmacy' ? 'selected' : '' }}>Pharmacy
                                    </option>
                                    <option value="Burial" {{ request('type') == 'Burial' ? 'selected' : '' }}>Burial
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="month" class="form-control">
                                    <option value="">-- Month --</option>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}"
                                            {{ request('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="year" class="form-control">
                                    <option value="">-- Year --</option>
                                    @for ($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                            {{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>

                            <div class="col-md-1">
                                <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-undo"></i>
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- ✅ End of Step 2B --}}


                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date Received</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRecord as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $value->clientVerification->client->full_name ?? ($value->recipient_name ?? 'N/A') }}
                                    </td>
                                    <td>₱{{ number_format($value->amount, 2) }}</td>
                                    <td>
                                        {{ $value->type ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ ucwords(strtolower($value->day_received)) }}
                                        {{ ucwords(strtolower($value->month_received)) }} {{ $value->year_received }}
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/ar/view/' . $value->id) }}" class="btn btn-sm btn-success"
                                            data-toggle="tooltip" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('admin/ar/edit/' . $value->id . '?finance_officer_name=' . urlencode(request('finance_officer_name'))) }}"
                                            class="btn btn-sm btn-primary ml-2" data-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Are you sure you want to delete this acknowledgement receipt?')"
                                            href="{{ url('admin/ar/delete/' . $value->id) }}"
                                            class="btn btn-sm btn-danger ml-2" data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
