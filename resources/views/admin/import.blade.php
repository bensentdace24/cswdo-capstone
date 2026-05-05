@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-import mr-2"></i>Bulk Data Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Bulk Import</li>
                    </ol>
                </div>
            </div>
            <p class="text-muted">Efficiently populate your database by uploading structured CSV files.</p>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Global Feedback Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible shadow-sm">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('import_errors'))
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title text-warning font-weight-bold">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Partial Import Warnings
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 250px;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 100px" class="pl-3">Row</th>
                                        <th>Issue Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('import_errors') as $error)
                                        <tr>
                                            <td class="pl-3 text-muted">#{{ preg_replace('/[^0-9]/', '', explode(':', $error)[0] ?? '0') }}</td>
                                            <td class="text-danger">{{ $error }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible shadow-sm">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <!-- Beneficiary Import Card -->
                <div class="col-lg-6">
                    <div class="card card-primary card-outline shadow-sm h-100">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-users-cog mr-2 text-primary"></i>1. Import Beneficiaries
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-sm text-muted mb-4">Add new clients to the system. The system automatically detects duplicates based on name and birthdate.</p>
                            
                            <form action="{{ route('admin.import.clients') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="csv_file_clients" class="d-block">
                                        <div class="p-4 border-dashed rounded text-center bg-light pointer" style="border: 2px dashed #ddd;">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                            <p class="mb-0 text-dark font-weight-bold">Click to select CSV file</p>
                                            <span class="text-xs text-muted">Max file size: 4MB</span>
                                        </div>
                                        <input type="file" name="csv_file" id="csv_file_clients" class="d-none" required onchange="updateFileName(this, 'fileNameClients')">
                                    </label>
                                    <div id="fileNameClients" class="text-center text-sm font-italic text-primary mt-2"></div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                                    <i class="fas fa-file-import mr-1"></i> Start Beneficiary Import
                                </button>
                            </form>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="bg-light p-3 rounded">
                                <h6 class="font-weight-bold text-xs text-uppercase tracking-wider text-muted mb-2">Required CSV Headers:</h6>
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach(['Full Name', 'Address', 'Age', 'Sex', 'Birthdate', 'IPS Member', '4Ps Member', 'Civil Status'] as $h)
                                        <span class="badge badge-secondary font-weight-normal px-2 py-1">{{ $h }}</span>
                                    @endforeach
                                </div>
                                <p class="text-xs text-muted mt-2 mb-0 italic">* IPS/4Ps columns accept: "Yes", "No", "True", "False", "1", "0"</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AR Import Card -->
                <div class="col-lg-6">
                    <div class="card card-success card-outline shadow-sm h-100">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-receipt mr-2 text-success"></i>2. Import Receipts (AR)
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-sm text-muted mb-4">Record assistance logs for existing clients. Ensure the Client ID matches exactly with the records in the system.</p>
                            
                            <form action="{{ route('admin.import.csv') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="csv_file_ar" class="d-block">
                                        <div class="p-4 border-dashed rounded text-center bg-light pointer" style="border: 2px dashed #ddd;">
                                            <i class="fas fa-file-csv fa-3x text-muted mb-2"></i>
                                            <p class="mb-0 text-dark font-weight-bold">Click to select CSV file</p>
                                            <span class="text-xs text-muted">Max file size: 2MB</span>
                                        </div>
                                        <input type="file" name="csv_file" id="csv_file_ar" class="d-none" required onchange="updateFileName(this, 'fileNameAR')">
                                    </label>
                                    <div id="fileNameAR" class="text-center text-sm font-italic text-success mt-2"></div>
                                </div>
                                
                                <button type="submit" class="btn btn-success btn-block btn-lg shadow-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Start AR Data Import
                                </button>
                            </form>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="bg-light p-3 rounded">
                                <h6 class="font-weight-bold text-xs text-uppercase tracking-wider text-muted mb-2">Required CSV Headers:</h6>
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach(['Client ID', 'Barangay', 'Amount', 'Assistance Type', 'Day', 'Month', 'Year'] as $h)
                                        <span class="badge badge-secondary font-weight-normal px-2 py-1">{{ $h }}</span>
                                    @endforeach
                                </div>
                                <p class="text-xs text-muted mt-2 mb-0 italic text-danger">* Warning: Records will be skipped if the Client ID does not exist.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .pointer { cursor: pointer; }
    .border-dashed:hover { background-color: #f0f4f8 !important; border-color: #007bff !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .text-gray-500 { color: #adb5bd; }
    .italic { font-style: italic; }
</style>

<script>
    function updateFileName(input, targetId) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById(targetId).innerHTML = fileName ? 
            `<i class="fas fa-file-alt mr-1"></i> Selected: <strong>${fileName}</strong>` : '';
    }
</script>
@endsection
