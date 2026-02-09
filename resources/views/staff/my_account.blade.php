@extends('layouts.app')

@section('content')
    {{-- Page Container - Clean background (Using the soft #f0f2f5 base) --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

        {{-- Top Header Section - Consistent with all modern forms --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-12 d-flex align-items-center">
                        {{-- Back Button (Assumes context returns to Dashboard) --}}
                        <a href="{{ url('/staff/dashboard') }}"
                            style="color: #6c757d; font-size: 1.5rem; margin-right: 15px; text-decoration: none;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-semibold text-gray-800"
                                style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">My Account</h1>
                            <p style="font-size: 1rem; color: #6c757d; margin: 0; padding-top: 2px;">Update your personal
                                profile information.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    {{-- Focused column width for maximum focus --}}
                    <div class="col-md-8 col-lg-6">

                        @include('_message')

                        <div class="card"
                            style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border: none; overflow: hidden;">

                            {{-- Card Header - Focused Title --}}
                            <div class="card-header"
                                style="background-color: #f7f7f7; padding: 25px 40px; border-bottom: 1px solid #eee;">
                                <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 5px;">Profile
                                    Details</h2>
                                <p style="font-size: 0.95rem; color: #6c757d; margin: 0;">Your name and email address.</p>
                            </div>

                            <form method="post" action=""> {{-- Keep action empty as per original code --}}
                                @csrf

                                <div class="card-body" style="padding: 40px;">
                                    <div class="row">

                                        {{-- Name --}}
                                        <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Name
                                                <span style="color: #dc3545;">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $getRecord->name) }}" required placeholder="Name"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            @if ($errors->has('name'))
                                                <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $errors->first('name') }}</div>
                                            @endif
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Email
                                                <span style="color: #dc3545;">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $getRecord->email) }}" required placeholder="Email"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                            @if ($errors->has('email'))
                                                <div style="color:#dc3545; font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $errors->first('email') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                {{-- Card Footer - Actions (Right aligned) --}}
                                <div class="card-footer"
                                    style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
                                    {{-- Update Button (Primary) --}}
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                        <i class="fas fa-save mr-1"></i> Update
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
