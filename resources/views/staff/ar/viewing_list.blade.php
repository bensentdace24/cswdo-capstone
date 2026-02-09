@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1>Saved Acknowledgement Receipts</h1>
            <a href="{{ url('staff/ar/list') }}" class="btn btn-primary">← Back to AR Form</a>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            <div class="card p-4">
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
                            <td>{{ $value->clientVerification->client->full_name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($value->amount, 2) }}</td>
                            <td>{{ $value->type }}</td>
                            <td>
                                {{ ucwords(strtolower($value->day_received)) }} {{ ucwords(strtolower($value->month_received)) }} {{ $value->year_received }}
                            </td>
                            <td>
                                <a href="{{ url('staff/ar/view/' . $value->id) }}"
                                    class="btn btn-sm btn-success"
                                    data-toggle="tooltip"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ url('staff/ar/edit/' . $value->id) }}"
                                    class="btn btn-sm btn-primary ml-2"
                                    data-toggle="tooltip"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a onclick="return confirm('Are you sure you want to delete this acknowledgement receipt?')"
                                    href="{{ url('staff/ar/delete/' . $value->id) }}"
                                    class="btn btn-sm btn-danger ml-2"
                                    data-toggle="tooltip"
                                    title="Delete">
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