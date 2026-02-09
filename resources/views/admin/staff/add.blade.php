@extends('layouts.app')

@section('content')

{{-- Page Container - Clean background --}}
<div class="content-wrapper bg-gray-100 min-h-screen">

    {{-- Top Header Section - Consistent with all modern forms --}}
    <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-12 d-flex align-items-center">
                    {{-- Back Button --}}
                    <a href="{{ url('admin/staff/list') }}" style="color: #6c757d; font-size: 1.5rem; margin-right: 15px; text-decoration: none;">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div>
                        <h1 style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">Add New Staff</h1>
                        <p style="font-size: 1rem; color: #6c757d; margin: 0; padding-top: 2px;">Register a new staff member and assign their access credentials.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content py-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                {{-- Narrowed column for the essential fields --}}
                <div class="col-md-8 col-lg-6">

                    <div class="card" style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border: none; overflow: hidden;">

                        {{-- Card Header - Focused Title --}}
                        <div class="card-header" style="background-color: #f7f7f7; padding: 25px 40px; border-bottom: 1px solid #eee;">
                            <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 5px;">Staff Member Credentials</h2>
                            <p style="font-size: 0.95rem; color: #6c757d; margin: 0;">Provide name, email, and a secure password.</p>
                        </div>

                    <form method="post" action="{{ url('admin/staff/insert') }}" enctype="multipart/form-data">
                            @csrf
    {{-- ... rest of your form fields ... --}}

                            <div class="card-body" style="padding: 40px;">
                                <div class="row">

                                    {{-- Name (Full Width, since Last Name is removed) --}}
                                    <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                        <label style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Name <span style="color: #dc3545;">*</span></label>
                                        <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Enter Name"
                                            style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        @if($errors->has('name')) <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">{{ $errors->first('name') }}</div> @endif
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                        <label style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Email Address <span style="color: #dc3545;">*</span></label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Staff Email"
                                            style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        @if($errors->has('email')) <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">{{ $errors->first('email') }}</div> @endif
                                    </div>

                                    {{-- Password --}}
                                    <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                        <label style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Password <span style="color: #dc3545;">*</span></label>
                                        <input type="password" class="form-control" name="password" required placeholder="Min 8 characters"
                                            style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        @if($errors->has('password')) <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">{{ $errors->first('password') }}</div> @endif
                                    </div>

                                    {{-- CRITICAL SECURITY: Password Confirmation (Remains) --}}
                                    <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                        <label style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Confirm Password <span style="color: #dc3545;">*</span></label>
                                        <input type="password" class="form-control" name="password_confirmation" required placeholder="Re-enter password"
                                            style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                    </div>

                                </div>
                            </div>

                            {{-- Card Footer - Actions (Right aligned) --}}
                            <div class="card-footer" style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
                                {{-- Back Button --}}
                                <a href="{{ url('admin/staff/list') }}" class="btn btn-secondary"
                                    style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                    Cancel
                                </a>
                                {{-- Submit Button (Primary) --}}
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                    <i class="fas fa-plus mr-1"></i> Add Staff
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