@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">Import Acknowledgement Receipts</h1>
                <p class="text-muted">Upload a CSV file to bulk import data into the system.</p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card shadow-sm p-4">
                    <form action="{{ route('admin.import.csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="csv_file" class="form-label fw-bold">Select CSV File</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import CSV
                        </button>
                    </form>

                    <p class="text-muted mt-3">
                        💡 Make sure your CSV has headers matching the database columns (e.g. <code>client_id, barangay,
                            amount, type, month_received, year_received</code>).
                    </p>
                </div>
            </div>
        </section>
    </div>
=======
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Import Acknowledgement Receipts</h1>
      <p class="text-muted">Upload a CSV file to bulk import data into the system.</p>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="card shadow-sm p-4">
        <form action="{{ route('admin.import.csv') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="csv_file" class="form-label fw-bold">Select CSV File</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-upload"></i> Import CSV
          </button>
        </form>

        <p class="text-muted mt-3">
          💡 Make sure your CSV has headers matching the database columns (e.g. <code>client_id, barangay, amount, type, month_received, year_received</code>).
        </p>
      </div>
    </div>
  </section>
</div>
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
@endsection
