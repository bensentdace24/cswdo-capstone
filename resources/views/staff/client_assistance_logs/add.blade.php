@extends('layouts.app')

@section('title', 'Log New Assistance | CSWDO')

@section('content')

    {{-- Page Container - Clean background --}}
    <div class="content-wrapper bg-gray-100 min-h-screen">

        {{-- Top Header Section - Dedicated for page title and back button --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-12 d-flex align-items-center">
                        {{-- Back Button (Assumed URL is the client's detail view) --}}
                        <a href="{{ url('staff/client/' . $client->id) }}"
                            style="color: #6c757d; font-size: 1.5rem; margin-right: 15px; text-decoration: none;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <div>
                            <h1 style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">Log New Assistance</h1>
                            <p style="font-size: 1rem; color: #6c757d; margin: 0; padding-top: 2px;">For Client: <span
                                    style="font-weight: 600; color: #007bff;">{{ $client->full_name }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    {{-- Use a focused column width since the form is short --}}
                    <div class="col-md-10 col-lg-8">

                        <form method="post" action="{{ url('staff/client_assistance_logs/add/' . $client->id) }}">
                            @csrf

                            {{-- The Main Form Card - Floating, rounded, and clean --}}
                            <div class="card"
                                style="border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border: none; overflow: hidden;">

                                {{-- Card Header - Focused Title --}}
                                <div class="card-header"
                                    style="background-color: #f7f7f7; padding: 25px 40px; border-bottom: 1px solid #eee;">
                                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 5px;">New
                                        Service Entry</h2>
                                    <p style="font-size: 0.95rem; color: #6c757d; margin: 0;">Record the details of the
                                        assistance provided.</p>
                                </div>

                                <div class="card-body" style="padding: 40px;">
                                    <div class="row">

                                        {{-- Date of Assistance --}}
                                        <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Date
                                                of Assistance <span style="color: #dc3545;">*</span></label>
                                            <input type="date" name="assisted_at" class="form-control" required
                                                value="{{ date('Y-m-d') }}" readonly
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">

                                        </div>

                                        {{-- Type of Assistance (Used a dropdown here for better UX) --}}
                                        <div class="form-group col-md-12" style="margin-bottom: 30px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Type
                                                of Assistance</label>
                                            {{-- TIP: For Type of Assistance, a SELECT dropdown with common options (Medical, Pharmacy, Burial, Food) is better UX than a free text field. --}}
                                            {{--  <input type="text" name="type" class="form-control" placeholder="e.g. Medical, Pharmacy"
                                            style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;"> --}}

                                            {{-- EXAMPLE OF A DROPDOWN OPTION: --}}
                                            <select name="type" class="form-control"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                <option value="">Select Type</option>
                                                <option value="Medical">Medical</option>
                                                <option value="Pharmacy">Pharmacy</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                {{-- Card Footer - Actions (Right aligned) --}}
                                <div class="card-footer"
                                    style="padding: 25px 40px; background-color: #f7f7f7; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">

                                    {{-- Cancel Button --}}
                                    <a href="{{ url('staff/client/list') }}" class="btn btn-secondary ml-2"
                                        style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                        Cancel
                                    </a>

                                    {{-- Save Button (Primary) --}}
                                    <button class="btn btn-primary" type="submit"
                                        style="background-color: #28a745; border-color: #28a745; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);">
                                        <i class="fas fa-check-circle mr-1"></i> Save Assistance Log
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
