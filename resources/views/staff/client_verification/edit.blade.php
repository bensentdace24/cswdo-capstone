@extends('layouts.app')

@section('content')
<div class="content-wrapper">
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
                        <form method="POST" action="{{ url('staff/client_verification/edit/' . $record->id) }}">
                            @csrf
                            <div class="card-body">
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Beneficiary</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection