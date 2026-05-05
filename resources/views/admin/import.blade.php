@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="font-weight-bold text-primary mb-1">
                            <i class="fas fa-database mr-2"></i>Bulk Data Import
                        </h1>
                        <p class="text-muted mb-0">Upload CSV files to efficiently populate system records.</p>
                    </div>
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success shadow-sm">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger shadow-sm">
                        <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
                    </div>
                @endif

                @if (session('import_errors'))
                    <div class="card card-warning shadow-sm">
                        <div class="card-header">
                            <strong><i class="fas fa-exclamation-triangle mr-1"></i>Import Warnings</strong>
                        </div>
                        <div class="card-body p-0">
                            <div style="max-height: 220px; overflow-y:auto;">
                                <table class="table table-sm mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width:80px;">Row</th>
                                            <th>Issue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('import_errors') as $error)
                                            <tr>
                                                <td>#{{ preg_replace('/[^0-9]/', '', $error) }}</td>
                                                <td class="text-danger">{{ $error }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step Layout -->
                <div class="row">

                    <!-- STEP 1 -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <strong>Step 1: Import Beneficiaries</strong>
                            </div>

                            <div class="card-body">

                                <p class="text-muted">
                                    Upload a CSV file containing client information. Duplicate entries are automatically
                                    detected.
                                </p>

                                <form action="{{ route('admin.import.clients') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="upload-box" onclick="triggerFile('clients')">
                                        <i class="fas fa-upload fa-2x mb-2"></i>
                                        <p class="mb-0 font-weight-bold">Click to upload CSV</p>
                                        <small>Max: 4MB</small>
                                    </div>

                                    <input type="file" name="csv_file" id="file_clients" hidden required
                                        onchange="showFileName(this, 'name_clients')">

                                    <div id="name_clients" class="file-name text-primary mt-2 text-center"></div>

                                    <button class="btn btn-primary btn-block mt-3">
                                        <i class="fas fa-play mr-1"></i>Import Beneficiaries
                                    </button>
                                </form>

                                <hr>

                                <h6 class="text-muted text-uppercase small">Expected Columns</h6>
                                <div class="tags">
                                    @foreach (['Full Name', 'Address', 'Age', 'Sex', 'Birthdate', 'IPS Member', '4Ps Member', 'Civil Status'] as $h)
                                        <span class="badge badge-light border">{{ $h }}</span>
                                    @endforeach
                                </div>

                                <small class="text-muted d-block mt-2">
                                    IPS/4Ps accepts: Yes, No, True, False, 1, 0
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white">
                                <strong>Step 2: Import Acknowledgement Receipts</strong>
                            </div>

                            <div class="card-body">

                                <p class="text-muted">
                                    Upload assistance records for existing clients. Ensure the Client Reference ID is valid.
                                </p>

                                <form action="{{ route('admin.import.csv') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="upload-box success" onclick="triggerFile('ar')">
                                        <i class="fas fa-file-csv fa-2x mb-2"></i>
                                        <p class="mb-0 font-weight-bold">Click to upload CSV</p>
                                        <small>Max: 2MB</small>
                                    </div>

                                    <input type="file" name="csv_file" id="file_ar" hidden required
                                        onchange="showFileName(this, 'name_ar')">

                                    <div id="name_ar" class="file-name text-success mt-2 text-center"></div>

                                    <button class="btn btn-success btn-block mt-3">
                                        <i class="fas fa-play mr-1"></i>Import Receipts
                                    </button>
                                </form>

                                <hr>

                                <h6 class="text-muted text-uppercase small">Expected Columns</h6>
                                <div class="tags">
                                    @foreach (['Client Reference ID', 'Barangay', 'Amount Received', 'Assistance Type', 'Date Received'] as $h)
                                        <span class="badge badge-light border">{{ $h }}</span>
                                    @endforeach
                                </div>

                                <small class="text-danger d-block mt-2">
                                    Invalid Client IDs will be skipped.
                                </small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <style>
        .upload-box {
            border: 2px dashed #ccc;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .upload-box:hover {
            background: #f4f8ff;
            border-color: #007bff;
        }

        .upload-box.success:hover {
            background: #f1fff5;
            border-color: #28a745;
        }

        .file-name {
            font-size: 0.9rem;
        }

        .tags span {
            margin: 3px;
        }
    </style>

    <script>
        function triggerFile(type) {
            document.getElementById('file_' + type).click();
        }

        function showFileName(input, target) {
            const file = input.files[0];
            document.getElementById(target).innerHTML = file ?
                `<i class="fas fa-file mr-1"></i>${file.name}` :
                '';
        }
    </script>

@endsection
