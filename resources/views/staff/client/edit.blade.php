@extends('layouts.app')

@section('content')
    {{-- Page Container - Clean background --}}
    <div class="content-wrapper bg-gray-100 min-h-screen">
        {{-- Top Header Section - Dedicated for page title and back button --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-12 d-flex align-items-center">
                        {{-- Back Button --}}
                        <a href="{{ url()->previous() }}"
                            style="color: #6c757d; font-size: 1.5rem; margin-right: 15px; text-decoration: none;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <div>
                            <h1 style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">Edit Client</h1>
                            <p style="font-size: 1rem; color: #6c757d; margin: 0; padding-top: 2px;">Update client
                                information and details</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Main Content Section - Form Card --}}
        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    {{-- FIX 1: INCREASED WIDTH - Now using col-md-11 and col-lg-10 for better width utilization on PC --}}
                    <div class="col-md-13 col-lg-12">

                        {{-- The Main Form Card --}}
                        <div class="card"
                            style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border: none; overflow: hidden;">
                            {{-- Card Header - For "Client Details" --}}
                            <div class="card-header"
                                style="background-color: #f7f7f7; padding: 25px 40px; border-bottom: 1px solid #eee;">
                                <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 5px;">Client
                                    Details</h2>
                            </div>

                            <form method="post" action="{{ url('staff/client/edit/' . $getRecord->id) }}">
                                @csrf

                                {{-- Card Body - Main Form Fields --}}
                                <div class="card-body" style="padding: 40px;">

                                    {{-- SECTION: PERSONAL INFORMATION --}}
                                    <div style="margin-bottom: 40px;">
                                        <h3
                                            style="font-size: 1.1rem; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                                            PERSONAL INFORMATION
                                        </h3>
                                        <div class="row">
                                            {{-- Full Name --}}
                                            <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Full
                                                    Name <span style="color: #dc3545;">*</span></label>
                                                <input type="text" class="form-control" name="full_name"
                                                    value="{{ old('full_name', $getRecord->full_name) }}" required
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                @if ($errors->has('full_name'))
                                                    <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                        {{ $errors->first('full_name') }}</div>
                                                @endif
                                            </div>
                                            {{-- Address --}}
                                            <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Address
                                                    <span style="color: #dc3545;">*</span></label>
                                                <input type="text" class="form-control" name="address"
                                                    value="{{ old('address', $getRecord->address) }}" required
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                @if ($errors->has('address'))
                                                    <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                        {{ $errors->first('address') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SECTION: DEMOGRAPHICS --}}
                                    <div style="margin-bottom: 40px;">
                                        <h3
                                            style="font-size: 1.1rem; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                                            DEMOGRAPHICS
                                        </h3>
                                        <div class="row">
                                            {{-- Age --}}
                                            <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Age</label>
                                                <input type="number" class="form-control" name="age"
                                                    value="{{ old('age', $getRecord->age) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                            {{-- Birthplace --}}
                                            <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Birthplace</label>
                                                <input type="text" class="form-control" name="birthplace"
                                                    value="{{ old('birthplace', $getRecord->birthplace) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                            {{-- Contact Number --}}
                                            <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Contact
                                                    Number</label>
                                                <input type="text" class="form-control" name="contact_number"
                                                    value="{{ old('contact_number', $getRecord->contact_number) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                            {{-- Birthdate --}}
                                            <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Birthdate</label>
                                                <input type="date" class="form-control" name="birthdate"
                                                    value="{{ old('birthdate', $getRecord->birthdate) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem; color-scheme: light;">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SECTION: STATUS & CLASSIFICATION --}}
                                    <div style="margin-bottom: 40px;">
                                        <h3
                                            style="font-size: 1.1rem; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                                            STATUS & CLASSIFICATION
                                        </h3>
                                        <div class="row">
                                            {{-- Sex --}}
                                            <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Sex</label>

                                                {{-- FIX: Removed custom styling to allow the reliable native browser arrow to appear --}}
                                                <select class="form-control" name="sex"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0;
                                                padding: 8px 0; /* Keep vertical padding */
                                                background-color: transparent; box-shadow: none; font-size: 1rem;">

                                                    <option value="">Select</option>
                                                    <option value="Male"
                                                        {{ old('sex', $getRecord->sex) == 'Male' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ old('sex', $getRecord->sex) == 'Female' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                            </div>

                                            {{-- Civil Status --}}
                                            <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Civil
                                                    Status</label>
                                                <input type="text" class="form-control" name="civil_status"
                                                    value="{{ old('civil_status', $getRecord->civil_status) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>

                                            {{-- IPs/4Ps Checkboxes --}}
                                            <div class="form-group col-md-6"
                                                style="margin-bottom: 30px; padding-top: 30px;">
                                                <div style="display: flex; align-items: center;">
                                                    <div style="display: flex; align-items: center; margin-right: 30px;">
                                                        <input type="checkbox" name="is_ips" value="1"
                                                            id="is_ips"
                                                            style="margin-right: 10px; width: 18px; height: 18px; border-radius: 4px; border-color: #ccc;"
                                                            {{ old('is_ips', $getRecord->is_ips) ? 'checked' : '' }}>
                                                        <label for="is_ips"
                                                            style="margin: 0; font-weight: 600; color: #555; user-select: none;">IPs</label>
                                                    </div>
                                                    <div style="display: flex; align-items: center;">
                                                        <input type="checkbox" name="is_4ps" value="1"
                                                            id="is_4ps"
                                                            style="margin-right: 10px; width: 18px; height: 18px; border-radius: 4px; border-color: #ccc;"
                                                            {{ old('is_4ps', $getRecord->is_4ps) ? 'checked' : '' }}>
                                                        <label for="is_4ps"
                                                            style="margin: 0; font-weight: 600; color: #555; user-select: none;">4Ps</label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Educational Attainment --}}
                                            <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Educational
                                                    Attainment</label>
                                                <input type="text" class="form-control" name="educational_attainment"
                                                    value="{{ old('educational_attainment', $getRecord->educational_attainment) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                            {{-- Occupation --}}
                                            <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Occupation</label>
                                                <input type="text" class="form-control" name="occupation"
                                                    value="{{ old('occupation', $getRecord->occupation) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                            {{-- Religion --}}
                                            <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                                <label
                                                    style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Religion</label>
                                                <input type="text" class="form-control" name="religion"
                                                    value="{{ old('religion', $getRecord->religion) }}"
                                                    style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            </div>
                                        </div>
                                    </div>

                                </div> {{-- End of card-body --}}

                                {{-- Card Footer - Actions (Right aligned) --}}
                                <div class="card-footer"
                                    style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
                                    {{-- Cancel Button --}}
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary"
                                        style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                        Cancel
                                    </a>
                                    {{-- Update Client Button --}}
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                        <i class="fas fa-save mr-1"></i> Update Client
                                    </button>
                                </div>
                            </form>
                        </div> {{-- End of Card --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
