@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Student</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">



                    @include('_message')

                    <!-- /.card -->



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Student</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Profile Pic</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Admission Number</th>
                                        <th>Roll Number</th>
                                        <th>Class</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Caste</th>
                                        <th>Religion</th>
                                        <th>Mobile Number</th>
                                        <th>Admission Date</th>
                                        <th>Blood Group</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $student)
                                    <tr>
                                        <td>
                                            @if(!empty($student->getProfile()))
                                            <img src="{{ $student->getProfile() }}" style="height: 50px; width: 50px; border-radius: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $student->name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->admission_number }}</td>
                                        <td>{{ $student->roll_number }}</td>
                                        <td>{{ $student->class_name }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>
                                            @if(!empty($student->date_of_birth))
                                            {{ date('d-m-Y', strtotime($student->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>{{ $student->caste }}</td>
                                        <td>{{ $student->religion }}</td>
                                        <td>{{ $student->mobile_number }}</td>
                                        <td>
                                            @if(!empty($student->admission_date))
                                            {{ date('d-m-Y', strtotime($student->admission_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $student->blood_group }}</td>
                                        <td>{{ $student->height }}</td>
                                        <td>{{ $student->weight }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($student->created_at)) }}</td>
                                        <td style="min-width: 140px;">
                                            <a style="margin-bottom: 10px;" class="btn btn-primary btn-sm" href="{{ url('parent/my_student/subject/'.$student->id) }}">Subject</a>
                                            <a style="margin-bottom: 10px;" class="btn btn-success btn-sm" href="{{ url('parent/my_student/fees_collection/'.$student->id) }}">Fees Collection</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="padding: 10px; float: right;">
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@endsection