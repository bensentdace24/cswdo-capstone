@extends('layouts.app')

@section('content')
    {{-- Page Container - Clean background (Using the soft #f0f2f5 base) --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

        {{-- Top Header Section - Consistent with all client screens --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-12 d-flex align-items-center">
                        {{-- Back Button --}}
                        <a href="{{ url('staff/client_dependents/list/' . $client->id) }}"
                            style="color: #6c757d; font-size: 1.5rem; margin-right: 15px; text-decoration: none;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-semibold text-gray-800"
                                style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">Add New Dependent</h1>
                            <p style="font-size: 1rem; color: #6c757d; margin: 0; padding-top: 2px;">For Client: <span
                                    style="font-weight: 600;">{{ $client->full_name }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    {{-- Use wider column for efficient horizontal grouping --}}
                    <div class="col-md-10 col-lg-8">

                        <div class="card"
                            style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border: none; overflow: hidden;">

                            {{-- Card Header - Focused Title --}}
                            <div class="card-header"
                                style="background-color: #f7f7f7; padding: 25px 40px; border-bottom: 1px solid #eee;">
                                <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 5px;">Dependent
                                    Information</h2>
                                <p style="font-size: 0.95rem; color: #6c757d; margin: 0;">Enter all required demographic and
                                    status details.</p>
                            </div>

                            <form method="post" action="{{ url('staff/client_dependents/add/' . $client->id) }}">
                                @csrf

                                <div class="card-body" style="padding: 40px;">
                                    <div class="row">

                                        {{-- Group 1: Name, Age, Status (Efficient 2-column layout) --}}
                                        <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Dependent
                                                Name <span style="color: #dc3545;">*</span></label>
                                            <input type="text" class="form-control" name="dependent_name"
                                                value="{{ old('dependent_name') }}" required placeholder="Full Name"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            @if ($errors->has('dependent_name'))
                                                <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $errors->first('dependent_name') }}</div>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Age</label>
                                            <input type="number" class="form-control" name="age"
                                                value="{{ old('age') }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="form-group col-md-3" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Status</label>
                                            <input type="text" class="form-control" name="status"
                                                value="{{ old('status') }}" placeholder="e.g. Single, Married"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        {{-- Group 2: Relationship, Occupation, Birthday --}}
                                        <div class="form-group col-md-4" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Relationship</label>
                                            <input type="text" class="form-control" name="relationship"
                                                value="{{ old('relationship') }}" placeholder="e.g. Son, Daughter"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="form-group col-md-4" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Occupation</label>
                                            <input type="text" class="form-control" name="occupation"
                                                value="{{ old('occupation') }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="form-group col-md-4" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Birthday</label>
                                            <input type="date" class="form-control" name="birthday"
                                                value="{{ old('birthday') }}"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem; color-scheme: light;">
                                        </div>

                                    </div>
                                </div>

                                {{-- Card Footer - Actions (Right aligned) --}}
                                <div class="card-footer"
                                    style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
                                    {{-- Cancel Button --}}
                                    <a href="{{ url('staff/client_dependents/list/' . $client->id) }}"
                                        class="btn btn-secondary"
                                        style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                        Cancel
                                    </a>
                                    {{-- Save Button (Primary) --}}
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                        <i class="fas fa-save mr-1"></i> Save Dependent
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
