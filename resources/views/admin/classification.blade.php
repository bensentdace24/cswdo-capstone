@extends('layouts.app')

@section('content')

    <div class="content-wrapper" style="background-color: #f4f6f7; min-height: 100vh;">

        {{-- HEADER --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #dcdcdc;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0" style="font-size: 2.2rem; font-weight: 700; color: #1f4e8a;">
                    Classification Analysis (Random Forest)
                </h1>

                <div class="d-flex flex-column align-items-end">
                    <a href="{{ route('admin.classification.run') }}" class="btn mb-2"
                        style="background-color: #3498db; border-radius: 8px; font-weight: 600; padding: 8px 18px; color: white;">
                        <i class="fas fa-play mr-1"></i> Run Analysis
                    </a>

                    <a href="{{ route('admin.classification.export') }}" class="btn"
                        style="background-color: #2ecc71; border-radius: 8px; font-weight: 600; padding: 8px 18px; color: white;">
                        <i class="fas fa-file-csv mr-1"></i> Export CSV
                    </a>
                </div>
            </div>
        </section>

        {{-- BODY --}}
        <section class="content py-4">
            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @php
                    // Safely check if results exist and have data
                    $hasResults = !empty($results) && is_array($results);
                    $hasSummary = $hasResults && isset($results['summary']) && is_array($results['summary']);
                    $hasAnomalies = $hasResults && isset($results['anomalies']) && is_array($results['anomalies']);
                    $hasFeatureImportance = $hasResults && isset($results['feature_importance']) && is_array($results['feature_importance']);
                @endphp

                @if (!$hasResults)
                    <div class="alert alert-info">No results yet. Click "Run Random Forest Analysis" to generate classification.</div>
                @else
                    <div class="row">

                        {{-- URGENCY CHART - SAME SIZE AS FEATURE IMPORTANCE --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm"
                                style="border-radius: 20px; border: 1px solid #e1e1e1; background-color: #ffffff; height: 500px;">

                                <div class="card-header" style="border-bottom: 1px solid #ededed; padding: 18px 20px;">
                                    <h5 class="mb-0" style="font-size: 1.25rem; color: #2c3e50; font-weight: 700;">
                                        Urgency Distribution
                                    </h5>
                                    <p class="m-0" style="color: #7f8c8d; font-size: 0.9rem;">
                                        Classification breakdown by urgency level
                                    </p>
                                </div>

                                <div class="card-body d-flex flex-column align-items-center" style="padding: 20px;">

                                    <canvas id="urgencySummaryChart"
                                        style="max-height: 300px; width:100%; height:300px;"></canvas>

                                    {{-- Horizontal Legend / Summary Box --}}
                                    <div class="mt-3" style="width: 100%; display: flex; justify-content: center;">
                                        <div
                                            style="display: flex; justify-content: space-around; width: 80%; background: #f8f9fa; border-radius: 12px; padding: 10px 0; box-shadow: inset 0 0 5px rgba(0,0,0,0.05);">

                                            <div style="text-align: center;">
                                                <div style="color: #e74c3c; font-weight: 700;">High</div>
                                                <div style="color: #e74c3c;">
                                                    {{ $results['summary']['High Urgency'] ?? $results['summary']['high'] ?? 0 }}
                                                </div>
                                            </div>

                                            <div style="text-align: center;">
                                                <div style="color: #f39c12; font-weight: 700;">Medium</div>
                                                <div style="color: #f39c12;">
                                                    {{ $results['summary']['Medium Urgency'] ?? $results['summary']['medium'] ?? 0 }}
                                                </div>
                                            </div>

                                            <div style="text-align: center;">
                                                <div style="color: #2ecc71; font-weight: 700;">Low</div>
                                                <div style="color: #2ecc71;">
                                                    {{ $results['summary']['Low Urgency'] ?? $results['summary']['low'] ?? 0 }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        {{-- FEATURE IMPORTANCE (SAME SIZE) --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm"
                                style="border-radius: 20px; border: 1px solid #e1e1e1; background-color: #ffffff; height: 500px;">

                                <div class="card-header" style="border-bottom: 1px solid #ededed; padding: 18px 20px;">
                                    <h5 class="mb-0" style="font-size: 1.25rem; color: #2c3e50; font-weight: 700;">
                                        Feature Importance
                                    </h5>
                                    <p class="m-0" style="color: #7f8c8d; font-size: 0.9rem;">
                                        Model impact by feature
                                    </p>
                                </div>

                                <div class="card-body">
                                    @if($hasFeatureImportance)
                                        <canvas id="featureImportanceChart"
                                            style="max-height: 400px; width:100%; height:300px;"></canvas>
                                    @else
                                        <p class="text-muted text-center">No feature importance data available</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- FLAGGED CASES (BOTTOM SECTION EXACT SAME DESIGN) --}}
                    <div class="card shadow-sm mt-3"
                        style="border-radius: 25px; border: 1px solid #e1e1e1; padding: 25px; background-color: #ffffff;">

                        {{-- Top Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h4 style="font-weight: 700; color: #2c3e50; display: flex; align-items:center;">
                                    <span style="font-size: 12px; color: #e74c3c; margin-right: 10px;">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                    Flagged Cases
                                </h4>
                                <p style="color: #7f8c8d; margin-top: -5px; font-size: .9rem;">
                                    High urgency cases requiring attention
                                </p>
                            </div>

                            @php
                                $highUrgencyCount = 0;
                                if ($hasAnomalies) {
                                    $highUrgencyCount = collect($results['anomalies'])
                                        ->where('predicted_urgency', 'High Urgency')
                                        ->where('predicted_urgency', 'high')
                                        ->count();
                                }
                            @endphp

                            <span
                                style="background-color: #e74c3c20; color:#e74c3c; padding:5px 14px; border-radius: 8px; font-weight:600;">
                                {{ $highUrgencyCount }} cases
                            </span>
                        </div>

                        {{-- Inner Card Like Screenshot --}}
                        <div class="p-3"
                            style="background-color: #fafafa; border-radius: 20px; border: 1px solid #e6e6e6;">

                            @php
                                $highUrgencyAnomalies = [];
                                if ($hasAnomalies) {
                                    $highUrgencyAnomalies = array_filter($results['anomalies'], function ($row) {
                                        return isset($row['predicted_urgency']) && 
                                               (strtolower($row['predicted_urgency']) === 'high urgency' || 
                                                strtolower($row['predicted_urgency']) === 'high');
                                    });
                                }
                            @endphp

                            @if (empty($highUrgencyAnomalies))
                                <p class="text-muted">No high urgency cases found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table mb-0" style="font-size: 0.95rem;">
                                        <thead>
                                            <tr>
                                                <th>Client ID</th>
                                                <th>Barangay</th>
                                                <th>Assistances</th>
                                                <th>Total Amount</th>
                                                <th>Urgency</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($highUrgencyAnomalies as $row)
                                                <tr>
                                                    <td>{{ $row['client_id'] ?? $row['id'] ?? 'N/A' }}</td>
                                                    <td>{{ $row['barangay'] ?? $row['baranggay'] ?? 'N/A' }}</td>
                                                    <td>{{ $row['total_assistances'] ?? $row['assistances'] ?? 0 }}</td>
                                                    <td>
                                                        @php
                                                            $amount = $row['total_amount'] ?? $row['amount'] ?? 0;
                                                        @endphp
                                                        {{ $amount ? '₱' . number_format($amount, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            style="background:#e74c3c; color:white; padding:5px 10px; border-radius: 8px; font-size: .85rem;">
                                                            High
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                @endif
            </div>
        </section>
    </div>

    @if (!empty($results) && isset($results['summary']))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const rawSummary = @json($results['summary'] ?? []);
                    const rawImportance = @json($results['feature_importance'] ?? []);

                    // Always force 3 keys with safe defaults
                    const summary = {
                        "High Urgency": rawSummary["High Urgency"] ?? rawSummary["high"] ?? 0,
                        "Medium Urgency": rawSummary["Medium Urgency"] ?? rawSummary["medium"] ?? 0,
                        "Low Urgency": rawSummary["Low Urgency"] ?? rawSummary["low"] ?? 0
                    };

                    // Urgency Donut Chart
                    const urgencyCtx = document.getElementById('urgencySummaryChart');
                    if (urgencyCtx) {
                        new Chart(urgencyCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ["High", "Medium", "Low"],
                                datasets: [{
                                    data: [
                                        summary["High Urgency"],
                                        summary["Medium Urgency"],
                                        summary["Low Urgency"]
                                    ],
                                    backgroundColor: ["#e74c3c", "#f39c12", "#2ecc71"]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: "60%",
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }

                    // Feature Importance Bar Chart
                    const featureCtx = document.getElementById('featureImportanceChart');
                    if (featureCtx && rawImportance && rawImportance.length > 0) {
                        new Chart(featureCtx, {
                            type: 'bar',
                            data: {
                                labels: rawImportance.map(f => f.feature || 'Unknown'),
                                datasets: [{
                                    data: rawImportance.map(f => f.importance || 0),
                                    backgroundColor: "#3498db"
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Chart initialization error:', error);
                }
            });
        </script>
    @endif

@endsection
