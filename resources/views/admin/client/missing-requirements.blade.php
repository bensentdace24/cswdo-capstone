@extends('layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0 text-dark">📋 Clients with Missing Requirements</h4>
        </div>

        <div class="row mb-4">
            {{-- Box 1: Clients Missing Requirements --}}
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; background-color: #fcebeb;">
                    {{-- Adjusted padding and centered text --}}
                    <div
                        class="card-body py-2 px-3 text-center d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center">
                            <h6 class="text-uppercase text-danger mb-1 font-weight-bold" style="font-size: 0.7rem;">CLIENTS
                                MISSING REQUIREMENTS</h6>
                            <div class="d-flex align-items-center">
                                <h4 class="font-weight-bolder mb-0 me-2 text-danger" style="font-size: 1.4rem;">
                                    {{ $clients->count() }}</h4>
                                <i class="fas fa-exclamation-triangle text-danger opacity-7" style="font-size: 1.2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Box 2: Requirement Types Defined --}}
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; background-color: #fff9e6;">
                    {{-- Adjusted padding and centered text --}}
                    <div
                        class="card-body py-2 px-3 text-center d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center">
                            <h6 class="text-uppercase text-warning mb-1 font-weight-bold" style="font-size: 0.7rem;">
                                REQUIREMENT TYPES DEFINED</h6>
                            <div class="d-flex align-items-center">
                                <h4 class="font-weight-bolder mb-0 me-2 text-warning" style="font-size: 1.4rem;">
                                    {{ count($requirementKeys) }}</h4>
                                <i class="fas fa-list-check text-warning opacity-7" style="font-size: 1.2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-lg border-0" style="border-radius: 12px;">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form method="GET" action="{{ url('admin/client/missing-requirements') }}" class="d-flex"
                        style="gap: 10px;">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0"
                                style="border-radius: 8px 0 0 8px; border-color: #e0e0e0;"><i
                                    class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0"
                                value="{{ request('search') }}" placeholder="Search client name..."
                                style="border-radius: 0; border-color: #e0e0e0;">
                        </div>

                        <button type="submit" class="btn btn-primary" style="border-radius: 8px;">Search</button>

                        @if (request('search'))
                            <a href="{{ url('admin/client/missing-requirements') }}" class="btn btn-outline-secondary"
                                style="border-radius: 8px;">
                                Reset
                            </a>
                        @endif
                    </form>

                    <div class="d-flex" style="gap: 10px;">
                        {{-- All excess buttons removed --}}
                    </div>
                </div>

                @if ($clients->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle custom-table">
                            <thead class="bg-light" style="border-bottom: 1px solid #e0e0e0;">
                                <tr>
                                    <th style="width: 30px;"><input class="form-check-input" type="checkbox" disabled></th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 client-name-col">
                                        Client Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Incomplete Requirements</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-nowrap">
                                        Status</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    @php
                                        $missing = [];
                                        foreach ($requirementKeys as $key) {
                                            $req = $client->requirements->firstWhere('requirement_key', $key);
                                            if (!$req || !$req->is_submitted) {
                                                $missing[] = ucwords(str_replace('_', ' ', $key));
                                            }
                                        }
                                    @endphp
                                    <tr style="border-bottom: 1px solid #f0f0f0;">
                                        <td><input class="form-check-input" type="checkbox" disabled></td>
                                        <td class="client-name-cell">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $client->full_name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $client->email ?? 'N/A' }}</p>
                                            </div>
                                        </td>

                                        <td>
                                            @if (count($missing) > 0)
                                                @foreach ($missing as $item)
                                                    <span class="badge missing-req-badge me-1 my-1">
                                                        {{ $item }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-success-soft text-success"
                                                    style="background-color: #eaf8ed; color: #28a745; border-radius: 4px; padding: 6px 10px;">
                                                    All Submitted
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-nowrap">
                                            @if (count($missing) > 0)
                                                <span class="badge bg-danger-soft text-danger"
                                                    style="background-color: #fcebeb; color: #dc3545; border-radius: 4px; padding: 6px 10px;">
                                                    PENDING
                                                </span>
                                            @else
                                                <span class="badge bg-success-soft text-success"
                                                    style="background-color: #eaf8ed; color: #28a745; border-radius: 4px; padding: 6px 10px;">
                                                    COMPLETE
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <a href="{{ url('admin/client/' . $client->id . '/requirements') }}"
                                                class="btn btn-sm btn-icon-only text-secondary"
                                                style="background: none; border: none;" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View Checklist">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- DELETE BUTTON/ICON REMOVED --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION REMOVED HERE --}}
                @else
                    <div class="text-center p-5">
                        <p class="text-muted fs-5">All clients have submitted their requirements 🎉</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection