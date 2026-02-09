@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Dependent of {{ $client->full_name }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Column -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{ url('staff/client_dependents/edit/' . $getRecord->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label>Dependent Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="dependent_name" value="{{ old('dependent_name', $getRecord->dependent_name) }}" required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Age</label>
                                        <input type="number" class="form-control" name="age" value="{{ old('age', $getRecord->age) }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <input type="text" class="form-control" name="status" value="{{ old('status', $getRecord->status) }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Relationship</label>
                                        <input type="text" class="form-control" name="relationship" value="{{ old('relationship', $getRecord->relationship) }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Occupation</label>
                                        <input type="text" class="form-control" name="occupation" value="{{ old('occupation', $getRecord->occupation) }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Birthday</label>
                                        <input type="date" class="form-control" name="birthday" value="{{ old('birthday', $getRecord->birthday) }}">
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Dependent</button>
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