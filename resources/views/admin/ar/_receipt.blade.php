<!-- BEGIN RECEIPT COPY -->
<div class="card px-5 py-4"
    style="background-color: #fff; font-family: 'Arial', sans-serif; border: none; line-height: 1.8; page-break-inside: avoid;">

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

    <!-- Body -->
    <div style="font-size: 16px; text-align: justify;">
        <p>
            This is to acknowledge the <strong>RECEIPT</strong> from LGU-Panabo City through City Social Welfare and
            Development Office (CSWDO) the amount of
            <u><strong>{{ strtoupper($record->amount_words) }}</u> (₱
            <u>{{ number_format($record->amount, 2) }}</strong></u>) for the Assistance for Individual in Crisis
            Situation (AICS)
            <u><strong>{{ strtoupper($record->type) }}</strong></u>.
        </p>

        <p>
            Received this <u><strong>{{ strtoupper($record->day_received) }}</strong></u> day of
            <u><strong>{{ strtoupper($record->month_received) }} {{ $record->year_received }}</strong></u> at LGU-Panabo
            City CSWDO.
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
            <strong>KAREN A. MALAKINGBATO</strong><br>
            <small>CSWDO Finance Officer</small>
        </div>
        <div class="col-4 text-end">
            <br><br>
            <strong>/ MELVINA A. DOMINGO, RSW</strong><br>
            <small>SWO III / Section Head</small>
        </div>
    </div>

    <!-- Recipient Info + Photo -->
    <div class="row mt-5">
        <!-- Name and Barangay -->
        <div class="col-md-8 d-flex align-items-center">
            <div class="mx-auto text-center" style="width: 380px;">
                <p class="mb-1" style="font-weight: bold;">
                    {{ $record->clientVerification->client->full_name ?? 'Unknown' }} / {{ $record->barangay }}
                </p>
                <hr style="border: 1px solid #000; width: 100%; margin: 0 auto 4px auto;">
                <p class="mb-0"><small>Name of Recipient / Barangay</small></p>
            </div>
        </div>

        <!-- Attached Photo -->
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

</div>
<!-- END RECEIPT COPY -->
