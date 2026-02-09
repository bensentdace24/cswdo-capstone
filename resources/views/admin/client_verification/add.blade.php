@extends('layouts.app')

@section('content')

<div class="content-wrapper" style="background-color: #e4e4e4; min-height: 100vh;">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Beneficiary</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ url('admin/client_verification/add/' . $client->id) }}">
                @csrf
                <div class="card card-primary" style="background-color: #f7f7f7;">
                    <div class="card-body">

                        <h5 class="mb-3">PROBLEM PRESENTED</h5>
                        <div class="form-group">
                            <textarea name="problem_presented" class="form-control" rows="2" required>{{ old('problem_presented') }}</textarea>
                        </div>

                        <hr>

                        <h5>BRIEFCASE ASSESSMENT - CLIENT (Physical Impression)</h5>
                        @php
                        $client_checks = [
                        'understands_questions' => 'Client understands easily the question',
                        'well_dressed' => 'Client wearing good and comfortable clothes',
                        'presentable' => 'Well presentable and clearly answers the questions',
                        'solo_parent' => 'Client is a Solo Parent',
                        'senior_citizen' => 'Client is a Senior Citizen',
                        'pwd' => 'Client is a PWD',
                        'wheelchair' => 'Client is with wheelchair',
                        'crutches' => 'Client is with crutches',
                        'unkempt' => 'Client is unkept',
                        'handicapped' => 'Physically handicapped with clothes',
                        ];
                        @endphp
                        <div class="row">
                            @foreach($client_checks as $field => $label)
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="client_assessment[]" value="{{ $field }}" {{ is_array(old('client_assessment')) && in_array($field, old('client_assessment')) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>FAMILY (Family Condition/Relationship)</label>
                            <textarea name="family_condition" class="form-control" rows="2">{{ old('family_condition') }}</textarea>
                        </div>

                        <hr>

                        <div class="form-group col-md-12">
                            <label><strong>Community Environment (Check all that apply):</strong></label><br>
                            @php
                            $communityOptions = [
                            'peaceful' => 'The community is peaceful',
                            'urban_poor' => 'Client lives in an urban poor community',
                            'transport_problem' => 'Transportation problem',
                            'rural_area_north' => 'Client lives in a rural area at North dist.',
                            'rural_area_south' => 'Client lives in a rural area at South dist.',
                            'accessible_needs' => 'Easy access to medical, education, market'
                            ];
                            @endphp

                            @foreach($communityOptions as $key => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="community_assessment[]" value="{{ $key }}">
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>

                        <hr>

                        <h5>OTHER INFORMATION (For Disaster Related)</h5>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Date of Occurrence</label>
                                <input type="date" name="disaster_date" class="form-control" value="{{ old('disaster_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Type of Disaster</label>
                                <select name="disaster_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="fire" {{ old('disaster_type') == 'fire' ? 'selected' : '' }}>Fire</option>
                                    <option value="flood" {{ old('disaster_type') == 'flood' ? 'selected' : '' }}>Flood</option>
                                    <option value="other" {{ old('disaster_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Type of Damage</label>
                                <select name="damage_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="partially" {{ old('damage_type') == 'partially' ? 'selected' : '' }}>Partially</option>
                                    <option value="totally" {{ old('damage_type') == 'totally' ? 'selected' : '' }}>Totally</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Type of Household</label>
                                <select name="household_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="owned" {{ old('household_type') == 'owned' ? 'selected' : '' }}>Owned</option>
                                    <option value="rented" {{ old('household_type') == 'rented' ? 'selected' : '' }}>Rented</option>
                                    <option value="living_with" {{ old('household_type') == 'living_with' ? 'selected' : '' }}>Living with</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Living With (Specify)</label>
                                <input type="text" name="living_with" class="form-control" placeholder="e.g., Mother and 3 children">
                            </div>
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
                </div>
            </form>
        </div>
    </section>
</div>

@endsection