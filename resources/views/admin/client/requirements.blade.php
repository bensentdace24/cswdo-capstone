@extends('layouts.app')

@section('content')
    {{-- Page Container - Use the soft light background consistent across all admin screens --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

        {{-- Top Header Section - Consistent with all modern forms --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">
                    <i class="fas fa-clipboard-check mr-2" style="color: #007bff;"></i> Requirements for Medicine Assistance
                </h1>
                {{-- Back Button (Aligned right, consistent secondary style) --}}
                <a href="{{ url('admin/client/missing-requirements') }}" class="btn btn-secondary"
                    style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                    ← Back to Missing Requirements
                </a>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                @include('_message')

                {{-- Main Card: Floating and Rounded --}}
                <div class="card shadow-lg" style="border-radius: 12px; border: none; overflow: hidden;">
                    <div class="card-body p-4">

                        {{-- Title (Kept for official context, but styled professionally) --}}
                        <h4 class="text-center mb-4" style="color: #007bff; font-weight: 600; font-size: 1.5rem;">
                            City Social Welfare and Development Office – City of Panabo
                        </h4>

                        <form method="POST" action="{{ route('client.requirements.update', $client->id) }}">
                            @csrf

                            {{-- Table: Clean Style --}}

                            <table class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background-color: #f7f7f7;">
                                    <tr>
                                        <th style="width: 5%; padding: 15px 10px; color: #333; font-weight: 700;">#</th>

                                        <th
                                            style="width: 55%; padding: 15px 20px; color: #333; font-weight: 700; text-align: left;">
                                            Requirement
                                        </th>

                                        <th style="width: 15%; padding: 15px 10px; color: #333; font-weight: 700;">
                                            <label
                                                style="display:flex; align-items:center; gap:8px; margin:0; cursor:pointer;">
                                                <span>Submitted</span>
                                                <input type="checkbox" id="checkAll"
                                                    style="width: 20px; height: 20px; border-radius: 4px; cursor: pointer;">
                                                <small style="font-weight:400;">Select All</small>
                                            </label>
                                        </th>

                                        <th style="width: 25%; padding: 15px 20px; color: #333; font-weight: 700;">
                                            Notes / Remarks
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($requirements as $index => $req)
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <td style="padding: 12px 10px; font-weight: 600;">
                                                {{ $index + 1 }}
                                            </td>

                                            <td style="padding: 12px 20px;">
                                                {{ $defaultRequirements[$req->requirement_key] ?? ucwords(str_replace('_', ' ', $req->requirement_key)) }}
                                            </td>

                                            <td style="padding: 12px 10px; text-align:center;">
                                                <input type="checkbox" class="item-checkbox"
                                                    name="is_submitted[{{ $req->id }}]" value="1"
                                                    {{ $req->is_submitted ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px; border-radius: 4px;">
                                            </td>

                                            <td style="padding: 8px 20px;">
                                                <input type="text" name="notes[{{ $req->id }}]"
                                                    value="{{ $req->notes }}" class="form-control"
                                                    placeholder="Remarks..."
                                                    style="border:none; border-bottom:1px solid #ccc; background:transparent; box-shadow:none;">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>

                    {{-- Save Button Footer --}}
                    <div class="card-footer"
                        style="padding: 25px 40px; background-color: #fcfcfc; border-top: 1px solid #eee;">
                        <div class="text-end">
                            <button type="submit" class="btn btn-success"
                                style="background-color: #2ecc71; border-color: #2ecc71; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(46, 204, 113, 0.4);">
                                <i class="fas fa-save mr-2"></i> Save Checklist
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
    </div>
    </section>
    </div>

    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            const isChecked = this.checked;
            const items = document.querySelectorAll('.item-checkbox');

            items.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        // Optional: if user manually unchecks one, update "Select All"
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.item-checkbox:checked').length ===
                    itemCheckboxes.length;
                document.getElementById('checkAll').checked = allChecked;
            });
        });
    </script>
@endsection
