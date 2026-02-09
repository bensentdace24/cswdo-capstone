<!-- Header Logos and Title -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <img src="{{ asset('dist/img/lungsod.jpeg') }}" style="height:70px;">
    <div class="text-center flex-grow-1">
        <p class="mb-1" style="font-size:13px;">REPUBLIC OF THE PHILIPPINES</p>
        <p class="mb-1" style="font-size:13px;">Province of Davao del Norte</p>
        <p class="mb-1" style="font-size:14px;font-weight:bold;">CITY OF PANABO</p>
        <h5 style="font-weight:bold;">ACKNOWLEDGEMENT RECEIPT</h5>
    </div>
    <img src="{{ asset('dist/img/CSWD.png') }}" style="height:70px;">
</div>

<!-- Body -->
<div style="font-size:16px;text-align:justify;">
    <p>
        This is to acknowledge the <strong>RECEIPT</strong> from LGU-Panabo City through City Social Welfare and
        Development Office (CSWDO) the amount of
        <u><strong>{{ strtoupper($record->amount_words) }}</strong></u>
        (₱ <u><strong>{{ number_format($record->amount, 2) }}</strong></u>)
        for the Assistance for Individual in Crisis Situation (AICS)
        <u><strong>{{ strtoupper($record->type) }}</strong></u>.
    </p>

    <p>
        Received this <u><strong>{{ strtoupper($record->day_received) }}</strong></u> day of
        <u><strong>{{ strtoupper($record->month_received) }} {{ $record->year_received }}</strong></u>
        at LGU-Panabo City CSWDO.
    </p>
</div>

<!-- Signatories -->
<div class="row mt-5" style="font-size:15px;">
    <div class="col-4">
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

<!-- Recipient + Photo -->
<div class="row mt-5">
    <div class="col-md-8 text-center">
        <strong>{{ $record->clientVerification->client->full_name ?? 'Unknown' }} / {{ $record->barangay }}</strong>
        <hr style="border:1px solid #000;">
        <small>Name of Recipient / Barangay</small>
    </div>

    <div class="col-md-4 text-center">
        <div style="border:2px solid #000;width:1.5in;height:1.5in;margin:auto;">
            @if ($record->photo)
                <img src="{{ asset($record->photo) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <small>ATTACHED PHOTO HERE</small>
            @endif
        </div>
    </div>
</div>
