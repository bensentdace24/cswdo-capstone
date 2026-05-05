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

                @if (session('import_errors'))
                    <div class="alert alert-warning shadow-sm">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Import Issues Detected</h5>
                        <ul class="mb-0" style="max-height: 200px; overflow-y: auto;">
                            @foreach (session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                                    Headers (Friendly): <code>Full Name, Address, Age, Sex, Birthdate, IPS Member, 4Ps Member, Civil Status</code><br>
                                    <em>* Boolean fields (IPS/4Ps) support: Yes/No, True/False, or 1/0.</em>
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
                                    Headers (Friendly): <code>Client ID, Barangay, Amount, Assistance Type, Day, Month, Year</code><br>
                                    <em>* Note: Client IDs must already exist in the system.</em>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
