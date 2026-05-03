@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @include('_message')

                <div class="col-sm-12 no-print mb-4 mt-2">
                    <div class="d-flex justify-content-end align-items-center gap-3" style="gap: 12px;">
                        <!-- Back Button with Tooltip -->
                        <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-outline-secondary" data-toggle="tooltip"
                            title="Go Back" style="font-size: 1.1rem;">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <!-- Print Button with Tooltip -->
                        <button onclick="printAR()" class="btn btn-outline-success" data-toggle="tooltip"
                            title="Print Receipt" style="font-size: 1.1rem;">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>

                <!-- 📄 Printable Section with 2 Copies -->
                <div id="printableArea" class="print-wrapper">

                    {{-- COPY 1 --}}
                    <div class="ar-copy ar-box mb-3">
                        @include('admin.ar.partials.ar_copy', [
                            'record' => $record,
                            'finance_officer_name' => $finance_officer_name,
                        ])
                    </div>

                    {{-- COPY 2 --}}
                    <div class="ar-copy ar-box">
                        @include('admin.ar.partials.ar_copy', [
                            'record' => $record,
                            'finance_officer_name' => $finance_officer_name,
                        ])
                    </div>

                </div>


                <!-- Header Logos and Title -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <img src="{{ asset('dist/img/lungsod.jpeg') }}" alt="Left Logo" style="height: 70px;">
                    <div class="text-center flex-grow-1">
                        <p class="mb-1" style="font-size: 13px;">REPUBLIC OF THE PHILIPPINES</p>
                        <p class="mb-1" style="font-size: 13px;">Province of Davao del Norte</p>
                        <p class="mb-1" style="font-size: 14px; font-weight: bold;">CITY OF PANABO</p>
                        <h5 style="font-weight: bold;">ACKNOWLEDGEMENT RECEIPT</h5>
                    </div>
                    <img src="{{ asset('dist/img/CSWD.png') }}" alt="Right Logo" style="height: 70px;">
                </div>

                <!-- Body -->
                <div style="font-size: 16px; text-align: justify;">
                    <p>
                        This is to acknowledge the <strong>RECEIPT</strong> from LGU-Panabo City through City Social Welfare
                        and Development Office (CSWDO) the amount of
                        <u><strong>{{ strtoupper($record->amount_words) }}</u> (₱
                        <u>{{ number_format($record->amount, 2) }}</strong></u>) for the Assistance for Individual in Crisis
                        Situation (AICS)
                        <u><strong>{{ strtoupper($record->type) }}</strong></u>.
                    </p>
                    <p>
                        Received this <u><strong>{{ strtoupper($record->day_received) }}</strong></u> day of
                        <u><strong>{{ strtoupper($record->month_received) }} {{ $record->year_received }}</strong></u> at
                        LGU-Panabo City CSWDO.
                    </p>
                </div>

                <!-- Signatories -->
                <div class="row mt-5" style="font-size: 16px;">

                    {{-- LEFT: Department Head --}}
                    <div class="col-4 text-start d-flex flex-column justify-content-end" style="min-height: 90px;">
                        <div style="font-weight: bold; margin-bottom: 2px;">
                            CHAREINA JOY G. LACUIN, MSSW, RSW
                        </div>
                        <div style="font-size: 13px;">
                            CSWDO Department Head
                        </div>
                    </div>

                    {{-- CENTER: Finance Officer --}}
                    <div class="col-4 text-center d-flex flex-column justify-content-end" style="min-height: 90px;">
                        <div style="margin-bottom: 14px; font-size: 15px;">
                            By the authority of the Department Head
                        </div>

                        <div style="font-weight: bold; margin-bottom: 2px;">
                            {{ $finance_officer_name ?? 'KAREN A. MALAKINGBATO' }}
                        </div>
                        <div style="font-size: 13px;">
                            CSWDO Finance Officer
                        </div>
                    </div>

                    {{-- RIGHT: Section Head --}}
                    <div class="col-4 text-end d-flex flex-column justify-content-end" style="min-height: 90px;">
                        <div style="font-weight: bold; margin-bottom: 2px;">
                            / MELVINA A. DOMINGO, RSW
                        </div>
                        <div style="font-size: 13px;">
                            SWO III / Section Head
                        </div>
                    </div>

                </div>

                <!-- Recipient + Photo -->
                <div class="row mt-5">
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="mx-auto text-center" style="width: 380px;">
                            <p class="mb-1" style="font-weight: bold;">
                                {{ $record->recipient_name }} / {{ $record->barangay }}
                            </p>
                            <hr style="border: 1px solid #000; width: 100%; margin: 0 auto 4px auto;">
                            <p class="mb-0"><small>Name of Recipient / Barangay</small></p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <div
                            style="border: 2px solid #000; width: 1.5in; height: 1.5in; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            @if ($record->photo)
                                <img src="{{ asset($record->photo) }}" alt="Beneficiary Photo"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <strong style="font-size: 11px;">ATTACHED PHOTO HERE</strong>
                            @endif
                        </div>
                    </div>
                </div>

            </div> <!-- End #printableArea -->

    </div>
    </div>
    </section>
    </div>

    {{-- PRINT SCRIPT --}}
    @push('scripts')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #printableArea,
                #printableArea * {
                    visibility: visible;
                }

                #printableArea {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    padding: 0;
                    margin: 0;
                }

                .no-print {
                    display: none !important;
                }

                .ar-copy {
                    page-break-inside: avoid;
                }

                .ar-box {
                    border: 1.5px solid #000;
                    padding: 24px 32px;
                    background: #fff;
                    box-sizing: border-box;
                }

                .cut-line {
                    border-top: 2px dashed #000 !important;
                }
            }
        </style>

        <script>
            function printAR() {
                window.print();
            }
        </script>
    @endpush
@endsection
