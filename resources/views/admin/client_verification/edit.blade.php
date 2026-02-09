@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background-color: #e4e4e4; min-height: 100vh;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Beneficiary</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="POST" action="{{ url('admin/client_verification/edit/' . $record->id) }}">
                            @csrf
                            <div class="card-body" style="background-color: #f7f7f7;">
                                <div class="form-group">
                                    <label>Problem Presented <span style="color: red;">*</span></label>
                                    <textarea name="problem_presented" class="form-control" required>{{ old('problem_presented', $record->problem_presented) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Briefcase Assessment (Client)</label><br />
                                    @foreach($client_checks as $field => $label)
                                    <label class="mr-3">
                                        <input type="checkbox" name="client_assessment[]" value="{{ $field }}" {{ in_array($field, json_decode($record->client_assessment ?? '[]')) ? 'checked' : '' }}> {{ $label }}
                                    </label>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label>Family Condition</label>
                                    <textarea name="family_condition" class="form-control">{{ old('family_condition', $record->family_condition) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Environment / Community Assessment</label><br />
                                    @foreach($community_checks as $field => $label)
                                    <label class="mr-3">
                                        <input type="checkbox" name="community_assessment[]" value="{{ $field }}" {{ in_array($field, json_decode($record->community_assessment ?? '[]')) ? 'checked' : '' }}> {{ $label }}
                                    </label>
                                    @endforeach
                                </div>

                                <hr>
                                <h5>Disaster Info</h5>

                                <div class="form-group">
                                    <label>Date of Occurrence</label>
                                    <input type="date" class="form-control" name="disaster_date" value="{{ old('disaster_date', $record->disaster_date) }}">
                                </div>

                                <div class="form-group">
                                    <label>Disaster Type</label><br />
                                    @foreach($disaster_types as $value)
                                    <label class="mr-3">
                                        @php
                                        $selectedDisasters = json_decode($record->disaster_type, true) ?? [];
                                        @endphp
                                        <input type="checkbox" name="disaster_type[]" value="{{ $value }}" {{ in_array($value, $selectedDisasters) ? 'checked' : '' }}> {{ ucfirst($value) }}
                                    </label>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label>Household Type</label><br />
                                    @foreach($household_types as $value)
                                    <label class="mr-3">
                                        @php
                                        $selectedHouseholds = json_decode($record->household_type, true) ?? [];
                                        @endphp
                                        <input type="checkbox" name="household_type[]" value="{{ $value }}" {{ in_array($value, $selectedHouseholds) ? 'checked' : '' }}>
                                        {{ ucfirst($value) }}
                                    </label>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label>Living With (Specify)</label>
                                    <input type="text" name="living_with" class="form-control" value="{{ old('living_with', $record->living_with) }}">
                                </div>

                                <div class="form-group">
                                    <label>Damage Type</label>
                                    <select name="damage_type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="partially" {{ old('damage_type', $record->damage_type) == 'partially' ? 'selected' : '' }}>Partially</option>
                                        <option value="totally" {{ old('damage_type', $record->damage_type) == 'totally' ? 'selected' : '' }}>Totally</option>
                                    </select>
                                </div>
                            </div>
                            {{-- Card Footer - Actions (Right aligned) --}}
                            <div class="card-footer" style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
                                {{-- Cancel Button --}}
                                <a href="{{ url('admin/client_verification/list') }}" class="btn btn-secondary"
                                    style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                    Cancel
                                </a>
                                {{-- Submit Button (Primary) --}}
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                    <i class="fas fa-save mr-1"></i> Save Beneficiary
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