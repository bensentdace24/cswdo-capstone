@extends('layouts.app')

@section('content')
    @push('scripts')
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush


    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="mb-0">Acknowledgement Receipt</h1>
                    <div class="d-flex align-items-center mt-2 mt-md-0">
                        <!-- Add New Acknowledgement Icon (Pencil) -->
                        <a href="{{ url('admin/ar/add') }}" class="text-primary" data-toggle="tooltip"
                            title="Add Acknowledgement" style="font-size: 1.4rem; margin-right: 16px;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <!-- View Saved Acknowledgements Icon (Folder Open) -->
                        <a href="{{ url('admin/ar/viewing-list') }}" class="text-secondary" data-toggle="tooltip"
                            title="View Saved Acknowledgements" style="font-size: 1.4rem;">
                            <i class="fas fa-folder-open"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>



        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card px-5 py-4"
                    style="background-color: #fff; font-family: 'Arial', sans-serif; border: 1px solid #ccc; line-height: 1.8;">

                    <!-- Header Logos and Title -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Left Logo -->
                        <img src="{{ asset('dist/img/lungsod.jpeg') }}" alt="Left Logo" style="height: 70px;">

                        <!-- Title -->
                        <div class="text-center flex-grow-1">
                            <p class="mb-1" style="font-size: 13px;">REPUBLIC OF THE PHILIPPINES</p>
                            <p class="mb-1" style="font-size: 13px;">Province of Davao del Norte</p>
                            <p class="mb-1" style="font-size: 14px; font-weight: bold;">CITY OF PANABO</p>
                            <h5 style="font-weight: bold;">ACKNOWLEDGEMENT RECEIPT</h5>
                        </div>

                        <!-- Right Logo -->
                        <img src="{{ asset('dist/img/CSWD.png') }}" alt="Right Logo" style="height: 70px;">
                    </div>

                    <!-- Body (Sample Placeholder Data) -->
                    <div style="font-size: 16px; text-align: justify;">
                        <p>
                            This is to acknowledge the <strong>RECEIPT</strong> from LGU-Panabo City through City Social
                            Welfare and Development Office (CSWDO) the amount of
                            <u><strong>ONE THOUSAND TWO HUNDRED PESOS ONLY</u> (₱ <u>1,200.00</strong></u>) for the
                            Assistance for Individual in Crisis Situation (AICS)
                            <u><strong>MEDICAL / FINANCIAL ASSISTANCE</strong></u>.
                        </p>

                        <p>
                            Received this <u><strong>27TH</strong></u> day of <u><strong>DECEMBER 2024</strong></u> at
                            LGU-Panabo City CSWDO.
                        </p>
                    </div>

                    <!-- Signatories -->
                    <div class="row mt-5" style="font-size: 15px;">
                        <div class="col-4 text-start">
                            <strong>Noted by:</strong><br><br>
                            <strong>CHAREINA JOY G. LACUIN, MSSW, RSW</strong><br>
                            <small>CSWDO Department Head</small>
                        </div>
                        <div class="col-4 text-center">
                            <span>By the authority of the Department Head</span><br><br>
                            <strong>{{ $finance_officer_name ?? '____________________' }}</strong><br>
                            <small>CSWDO Finance Officer</small>
                        </div>
                        <div class="col-4 text-end">
                            <br><br>
                            <strong>/ MELVINA A. DOMINGO, RSW</strong><br>
                            <small>SWO III / Section Head</small>
                        </div>
                    </div>

                    <!-- Recipient Info and Photo -->
                    <div class="row mt-5">
                        <!-- Name and Barangay -->
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="mx-auto text-center" style="width: 380px;">
                                <hr style="border: 1px solid #000; width: 100%; margin: 0 auto 4px auto;">
                                <p class="mb-0"><small>Name of Recipient / Barangay</small></p>
                            </div>
                        </div>

                        <!-- Photo -->
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <div
                                style="border: 2px solid #000; width: 1.5in; height: 1.5in; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <strong style="font-size: 11px;">ATTACHED PHOTO HERE</strong>
                            </div>
                        </div>
                    </div>

                </div> <!-- End Card -->
            </div>
        </section>
    </div>
@endsection
