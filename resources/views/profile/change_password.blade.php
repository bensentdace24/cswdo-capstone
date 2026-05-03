@extends('layouts.app')

@section('content')
    {{-- Page Container - Clean background (Using the soft #f0f2f5 base) --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

        {{-- Top Header Section - Consistent with all modern forms --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-12 d-flex align-items-center">
                        {{-- Back Button (Assumes context returns to My Account or Dashboard) --}}
                        <a href="{{ url()->previous() }}"
                            style="color: #6c757d; font-size: 1.5rem; margin-right: 15px; text-decoration: none;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-semibold text-gray-800"
                                style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">Change Password</h1>
                            <p style="font-size: 1rem; color: #6c757d; margin: 0; padding-top: 2px;">Update your account
                                security credentials.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    {{-- Focused column width for maximum focus on security task --}}
                    <div class="col-md-8 col-lg-6">

                        <div class="card"
                            style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border: none; overflow: hidden;">

                            {{-- Card Header - Focused Title --}}
                            <div class="card-header"
                                style="background-color: #f7f7f7; padding: 25px 40px; border-bottom: 1px solid #eee;">
                                <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 5px;">Password
                                    Security Form</h2>
                                <p style="font-size: 0.95rem; color: #6c757d; margin: 0;">You must provide your old password
                                    to confirm identity.</p>
                            </div>

				@php
    $prefix = match ((string) Auth::user()->user_type) {
        '1' => 'admin',
        '2' => 'staff',
        '3' => 'student',
        '4' => 'parent',
        default => 'staff',
    };
@endphp
                            <form method="post" action="{{ url($prefix . '/change_password') }}">
                                @csrf

                                <div class="card-body" style="padding: 40px;">
                                    @include('_message') {{-- Keep message include here for errors/success messages --}}

                                    <div class="row">

                                        {{-- Old Password --}}
                                        <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Old
                                                Password <span style="color: #dc3545;">*</span></label>
                                            <input type="password" class="form-control" name="old_password" required
                                                placeholder="Enter current password"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            {{-- Validation error placeholder --}}
                                            @if ($errors->has('old_password'))
                                                <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $errors->first('old_password') }}</div>
                                            @endif
                                        </div>

                                        {{-- New Password --}}
                                        <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">New
                                                Password <span style="color: #dc3545;">*</span></label>
                                            <input type="password" class="form-control" name="new_password" required
                                                placeholder="Min 8 characters"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            {{-- Using 'new_password' here to match likely Laravel validation rules --}}
                                            @if ($errors->has('new_password'))
                                                <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $errors->first('new_password') }}</div>
                                            @endif
                                        </div>

                                        {{-- CRITICAL SECURITY: Confirm New Password --}}
                                        <div class="form-group col-md-6" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Confirm
                                                New Password <span style="color: #dc3545;">*</span></label>
                                            {{-- IMPORTANT: Laravel's 'confirmed' rule looks for 'new_password_confirmation' --}}
                                            <input type="password" class="form-control" name="new_password_confirmation"
                                                required placeholder="Re-enter new password"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            {{-- Validation error display placeholder for confirmation mismatch --}}
                                            @if ($errors->has('new_password_confirmation'))
                                                <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $errors->first('new_password_confirmation') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Footer - Actions (Right aligned) --}}
                                <div class="card-footer"
                                    style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
                                    {{-- Cancel Button --}}
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary"
                                        style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                        Cancel
                                    </a>
                                    {{-- Update Button (Primary) --}}
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                        <i class="fas fa-key mr-1"></i> Update Password
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
