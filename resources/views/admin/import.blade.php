@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">Bulk Data Import</h1>
                <p class="text-muted">Upload CSV files to bulk import data into the system.</p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <!-- Beneficiary Import -->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users mr-1"></i> Import Beneficiaries (Clients)</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.import.clients') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="csv_file_clients" class="form-label fw-bold">Select CSV File</label>
                                        <input type="file" name="csv_file" id="csv_file_clients" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-upload mr-1"></i> Import Beneficiaries
                                    </button>
                                </form>
                                <hr>
                                <p class="text-sm text-muted">
                                    <strong>💡 CSV Requirements:</strong><br>
                                    Headers must include: <code>full_name, address, age, sex, birthdate, is_ips, is_4ps, civil_status</code><br>
                                    Optional: <code>contact_number, birthplace, educational_attainment, occupation, religion</code>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- AR Import -->
                    <div class="col-md-6">
                        <div class="card card-success card-outline shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-file-invoice mr-1"></i> Import Acknowledgement Receipts</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.import.csv') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="csv_file_ar" class="form-label fw-bold">Select CSV File</label>
                                        <input type="file" name="csv_file" id="csv_file_ar" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-upload mr-1"></i> Import AR Data
                                    </button>
                                </form>
                                <hr>
                                <p class="text-sm text-muted">
                                    <strong>💡 CSV Requirements:</strong><br>
                                    Headers must include: <code>client_id, barangay, amount, type, day_received, month_received, year_received</code><br>
                                    <em>Note: Client IDs must already exist in the system.</em>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
