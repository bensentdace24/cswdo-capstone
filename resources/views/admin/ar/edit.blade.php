@extends('layouts.app')

@section('content')
    {{-- Page Container - Clean background --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

        {{-- Top Header Section - Consistent with all modern forms --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">
                    <i class="fas fa-receipt mr-2" style="color: #1D4FA1;"></i> Edit Acknowledgement Receipt
                </h1>
                {{-- Back Button (Consistent secondary style) --}}
                <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-secondary"
                    style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                    ← Back to AR List
                </a>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    {{-- Use slightly wider column for finance forms --}}
                    <div class="col-md-10 col-lg-8">

                        @include('_message')

                        {{-- Main Card: Floating and Rounded --}}
                        <div class="card shadow-lg" style="border-radius: 12px; border: none; overflow: hidden;">

                            <div class="card-body p-4" style="padding: 40px;">
                                {{-- Action URL corrected to use update route with ID --}}
                                <form action="{{ url('admin/ar/update/' . $record->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- SECTION 1: RECIPIENT AND CONTEXT --}}
                                    <div class="row" style="margin-bottom: 30px;">
                                        <div class="col-md-8 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Name
                                                of Recipient</label>
                                            {{-- Note: Reverting from select to text input to match existing data display --}}
                                            <input type="text" name="recipient_name" class="form-control" required
                                                value="{{ $record->recipient_name }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Barangay</label>
                                            <input type="text" name="barangay" class="form-control" required
                                                value="{{ $record->barangay }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                    </div>

                                    {{-- SECTION 2: AMOUNT DETAILS --}}
                                    <div class="row"
                                        style="border-top: 1px solid #eee; padding-top: 30px; margin-bottom: 30px;">
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Amount
                                                (₱)</label>
                                            <input type="number" name="amount" class="form-control" required
                                                value="{{ $record->amount }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="col-md-8 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Amount
                                                (in words)</label>
                                            <input type="text" name="amount_words" class="form-control" required
                                                value="{{ $record->amount_words }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Type
                                                of Assistance</label>
                                            <input type="text" name="type" class="form-control" required
                                                value="{{ $record->type }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                    </div>

                                    {{-- SECTION 3: DATE AND PHOTO --}}
                                    <div class="row"
                                        style="border-top: 1px solid #eee; padding-top: 30px; margin-bottom: 30px;">
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Day
                                                Received</label>
                                            <input type="text" name="day_received" class="form-control" required
                                                value="{{ $record->day_received }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Month
                                                Received</label>
                                            <input type="text" name="month_received" class="form-control" required
                                                value="{{ $record->month_received }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Year
                                                Received</label>
                                            <input type="text" name="year_received" class="form-control" required
                                                value="{{ $record->year_received }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        {{-- SECTION: FINANCE OFFICER --}}
                                        <div class="row"
                                            style="border-top: 1px solid #eee; padding-top: 30px; margin-bottom: 30px;">
                                            <div class="col-md-12 form-group">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">
                                                    Finance Officer Name
                                                </label>
                                                <input type="text" name="finance_officer_name" class="form-control"
                                                    value="{{ request('finance_officer_name') }}"
                                                    placeholder="e.g. KAREN A. MALAKINGBATO"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-group" style="margin-top: 15px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Photo
                                                (Current)</label>

                                            {{-- Display Existing Photo --}}
                                            @if ($record->photo)
                                                <img src="{{ asset($record->photo) }}" alt="Current Photo"
                                                    style="height: 100px; max-width: 100%; border-radius: 8px; margin-bottom: 10px;"
                                                    class="d-block">
                                            @endif

                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Replace
                                                Photo (Optional)</label>
                                            <input type="file" name="photo" class="form-control-file"
                                                style="border: 1px solid #ccc; border-radius: 6px; padding: 8px;">
                                        </div>
                                    </div>

                                    {{-- Card Footer - Actions (Right aligned) --}}
                                    <div class="card-footer"
                                        style="padding: 25px 0; background-color: white; border-top: 1px solid #e0e0e0; display: flex; justify-content: flex-end;">
                                        {{-- Cancel Button --}}
                                        <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-secondary"
                                            style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                            Cancel
                                        </a>
                                        {{-- Submit Button (Primary) --}}
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                            <i class="fas fa-save mr-1"></i> Update Receipt
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
