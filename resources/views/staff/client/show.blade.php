@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 mb-0">
                        <i class="fas fa-id-badge text-primary"></i>
                        Client Profile: <span class="text-dark">{{ $client->full_name }}</span>
                    </h1>
                    <a href="{{ url('staff/client/list') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Client List
                    </a>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                {{-- Eligibility Summary --}}
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="fas fa-clipboard-check text-primary mr-2"></i>
                        <strong>Assistance Eligibility Summary</strong>
                    </div>
                    <div class="card-body">
                        @if ($eligible)
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success fa-lg mr-3 mt-1"></i>
                                <div>
                                    <p class="mb-1 text-success fw-bold">
                                        Eligible — Client can proceed to the next step (e.g., Verification Form)
                                    </p>
                                    <small class="text-muted">
                                        ✅ Reason: The client has not received assistance within the last 3 months
                                        and meets the criteria for eligibility.
                                    </small>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-start">
                                <i class="fas fa-times-circle text-danger fa-lg mr-3 mt-1"></i>
                                <div>
                                    <p class="mb-1 text-danger fw-bold">
                                        Not Eligible — Client cannot proceed yet.
                                        <strong>{{ $daysLeft }}</strong> more days.
                                    </p>
                                    <small class="text-muted">
                                        ⚠️ Reason: Client has recently availed assistance within the last 3 months.
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Client Information --}}
                <div class="card shadow rounded-lg border-0">
                    <div class="card-header bg-primary text-white rounded-top">
                        <strong><i class="fas fa-user-circle mr-1"></i> Client Information</strong>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 mb-2"><strong>Full Name:</strong> <br>{{ $client->full_name }}</div>
                            <div class="col-md-4 mb-2"><strong>Age:</strong> <br>{{ $client->age }}</div>
                            <div class="col-md-4 mb-2"><strong>Sex:</strong> <br>{{ $client->sex }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-2"><strong>Birthplace:</strong> <br>{{ $client->birthplace }}</div>
                            <div class="col-md-4 mb-2"><strong>Birthdate:</strong> <br>{{ $client->birthdate }}</div>
                            <div class="col-md-4 mb-2"><strong>Contact No.:</strong> <br>{{ $client->contact_number }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-2"><strong>Address:</strong> <br>{{ $client->address }}</div>
                            <div class="col-md-4 mb-2"><strong>Educational Attainment:</strong>
                                <br>{{ $client->educational_attainment }}
                            </div>
                            <div class="col-md-4 mb-2"><strong>Occupation:</strong> <br>{{ $client->occupation }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-2"><strong>Religion:</strong> <br>{{ $client->religion }}</div>
                            <div class="col-md-4 mb-2"><strong>Civil Status:</strong> <br>{{ $client->civil_status }}</div>
                            <div class="col-md-4 mb-2"><strong>4Ps Member:</strong>
                                <br>{{ $client->is_4ps ? 'Yes' : 'No' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2"><strong>IPs Member:</strong>
                                <br>{{ $client->is_ips ? 'Yes' : 'No' }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
