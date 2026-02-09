@extends('layouts.app')

@section('content')

    <div class="content-wrapper bg-gray-50 min-h-screen">

        {{-- Header Section: Consistent Title and Button Style --}}
        <section class="content-header pt-4 pb-2">
            <div class="container-fluid">
                <div class="row align-items-center mb-4">
                    <div class="col-sm-6">
                        <h1 class="text-3xl font-semibold text-gray-800">
                            Beneficiaries Records <span class="text-sm font-medium text-gray-500 ml-2">(Total:
                                {{ $getRecord->total() }})</span>
                        </h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        @if (isset($client))
                            {{-- Changed from $client to isset($client) for robustness --}}
                            {{-- Explicit 'Add Beneficiary' button --}}
                            <a href="{{ url('staff/client_verification/add/' . $client->id) }}"
                                class="btn btn-primary bg-blue-600 hover:bg-blue-700 border-none rounded-lg shadow-md transition duration-150 ease-in-out"
                                title="Add New Beneficiary" style="font-size: 1rem; padding: 10px 20px;">
                                <i class="fas fa-user-plus mr-1"></i>
                                Add New Beneficiary
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        @include('_message')

                        {{-- Table Card: Clean, modern appearance --}}
                        <div class="card shadow-sm" style="border-radius: 8px;">
                            <div class="card-header bg-white border-b" style="padding: 15px 20px;">
                                <h3 class="card-title text-xl font-medium text-gray-800">Beneficiaries History</h3>
                            </div>

                            <div class="card-body p-0" style="overflow-x: auto;">
                                <table class="table table-hover table-striped" style="min-width: 1500px;">
                                    {{-- Added min-width for complex tables --}}
                                    <thead>
                                        <tr style="background-color: #f8f9fa;">
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                #</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                Client</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px; width: 15%;">
                                                Problem Presented</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px; width: 15%;">
                                                Assessment (Client)</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                Family Condition</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                Community</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                Disaster Info</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                Created At</th>
                                            <th
                                                style="border-bottom: 2px solid #e9ecef; color: #495057; padding: 12px 20px;">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($getRecord as $item)
                                            <tr class="hover:bg-gray-50 transition duration-100">
                                                <td style="padding: 12px 20px;">{{ $item->id }}</td>
                                                <td style="padding: 12px 20px; font-weight: 600;">
                                                    {{ $item->client->full_name ?? 'N/A' }}</td>

                                                {{-- Problem Presented --}}
                                                <td style="white-space: normal; padding: 12px 20px;">
                                                    {{ Str::limit($item->problem_presented, 100) }}</td>

                                                {{-- Briefcase Assessment (Styled as badges) --}}
                                                <td style="padding: 12px 20px;">
                                                    @foreach (json_decode($item->client_assessment ?? '[]') as $ca)
                                                        <span class="badge"
                                                            style="background-color: #007bff; color: white; margin: 2px; padding: 5px 10px; border-radius: 12px; display: inline-block;">
                                                            {{ $ca }}
                                                        </span>
                                                    @endforeach
                                                </td>

                                                {{-- Family Condition --}}
                                                <td style="white-space: normal; padding: 12px 20px;">
                                                    {{ Str::limit($item->family_condition, 50) }}</td>

                                                {{-- Community Assessment (Styled as badges) --}}
                                                <td style="padding: 12px 20px;">
                                                    @php
                                                        $envOptions = [
                                                            /* ... array definition is long, omitted here ... */
                                                        ];
                                                        $envData = json_decode(
                                                            $item->community_assessment ?? '[]',
                                                            true,
                                                        );
                                                    @endphp
                                                    @if (is_array($envData))
                                                        @foreach ($envData as $envKey)
                                                            @php $display = isset($envOptions[$envKey]) ? $envOptions[$envKey] : ucfirst(str_replace('_', ' ', $envKey)); @endphp
                                                            <span class="badge"
                                                                style="background-color: #ffc107; color: #333; margin: 2px; padding: 5px 10px; border-radius: 12px; display: inline-block;">
                                                                {{ $display }}
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                </td>

                                                {{-- Disaster Info (Multi-line badges) --}}
                                                <td style="padding: 12px 20px; font-size: 0.85rem;">
                                                    <div style="font-weight: 600; color: #dc3545; margin-bottom: 5px;">
                                                        {{ $item->disaster_date ?? 'N/A' }}</div>
                                                    @php
                                                        $disasterTypes = is_array(
                                                            json_decode($item->disaster_type, true),
                                                        )
                                                            ? json_decode($item->disaster_type, true)
                                                            : [$item->disaster_type];
                                                        $householdTypes = is_array(
                                                            json_decode($item->household_type, true),
                                                        )
                                                            ? json_decode($item->household_type, true)
                                                            : [$item->household_type];
                                                    @endphp
                                                    <div style="margin-top: 5px;">
                                                        @foreach ($disasterTypes as $type)
                                                            <span class="badge"
                                                                style="background-color: #dc3545; color: white; margin: 1px; padding: 4px 8px; border-radius: 8px; display: inline-block;">{{ $type }}</span>
                                                        @endforeach
                                                        @foreach ($householdTypes as $type)
                                                            <span class="badge"
                                                                style="background-color: #6c757d; color: white; margin: 1px; padding: 4px 8px; border-radius: 8px; display: inline-block;">{{ $type }}</span>
                                                        @endforeach
                                                    </div>
                                                    {{-- Displaying living_with/damage_type data... --}}
                                                </td>

                                                <td style="padding: 12px 20px;">
                                                    {{ $item->created_at->format('d-m-Y h:i A') }}</td>

                                                <td style="padding: 12px 20px;">
                                                    <div class="d-flex">
                                                        {{-- Edit Button --}}
                                                        <a href="{{ url('staff/client_verification/edit/' . $item->id) }}"
                                                            class="btn btn-sm btn-primary" title="Edit"
                                                            style="background-color: #17a2b8; border-color: #17a2b8; border-radius: 4px; padding: 6px 10px; margin-right: 5px;">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        {{-- Delete Button --}}
                                                        <a onclick="return confirm('Are you sure you want to delete this beneficiary?')"
                                                            href="{{ url('staff/client_verification/delete/' . $item->id) }}"
                                                            class="btn btn-sm btn-danger" title="Delete"
                                                            style="background-color: #dc3545; border-color: #dc3545; border-radius: 4px; padding: 6px 10px;">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-5 text-gray-500"
                                                    style="font-style: italic;">No Beneficiaries records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination Footer --}}
                            <div class="card-footer clearfix bg-white"
                                style="padding: 15px 20px; border-radius: 0 0 8px 8px;">
                                <div class="float-right">
                                    {!! $getRecord->links() !!}
                                </div>
                                <div class="float-left pt-2 text-sm text-gray-600">
                                    @if ($getRecord->total() > 0)
                                        Showing {{ $getRecord->firstItem() }} to {{ $getRecord->lastItem() }} of
                                        {{ $getRecord->total() }} entries
                                    @else
                                        Showing 0 to 0 of 0 entries
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
