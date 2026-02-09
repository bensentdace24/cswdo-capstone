@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Client</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ url('admin/client/list') }}" class="btn btn-secondary">← Back to Client list</a>
                </div>
            </div>
        </div>
    </section>

@include('_message')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{ url('admin/client/add') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label>Full Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required placeholder="Full Name">
                                        <div style="color:red">{{ $errors->first('full_name') }}</div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Address">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>IPS Member?</label><br />
                                        <select class="form-control" name="is_ips">
                                            <option value="">Select</option>
                                            <option value="1" {{ old('is_ips') == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('is_ips') == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>4Ps Member?</label><br />
                                        <select class="form-control" name="is_4ps">
                                            <option value="">Select</option>
                                            <option value="1" {{ old('is_4ps') == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('is_4ps') == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Age</label>
                                        <input type="number" class="form-control" name="age" value="{{ old('age') }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Birthplace</label>
                                        <input type="text" class="form-control" name="birthplace" value="{{ old('birthplace') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Contact No.</label>
                                        <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Educational Attainment</label>
                                        <input type="text" class="form-control" name="educational_attainment" value="{{ old('educational_attainment') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Occupation</label>
                                        <input type="text" class="form-control" name="occupation" value="{{ old('occupation') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Religion</label>
                                        <input type="text" class="form-control" name="religion" value="{{ old('religion') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Sex</label>
                                        <select name="sex" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Civil Status</label>
                                        <input type="text" class="form-control" name="civil_status" value="{{ old('civil_status') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Birthdate</label>
                                        <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}">
                                    </div>

                                </div>

                                <hr>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save Client</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection