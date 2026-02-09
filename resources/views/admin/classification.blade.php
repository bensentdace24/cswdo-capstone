@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    {{-- Custom Styles for this page --}}
    <style>
        .content-wrapper {
            background-color: #f8fafc !important;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.02em;
        }

        /* Modernized Buttons */
        .btn-run-analysis {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-run-analysis:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .btn-export-csv {
            background-color: #10b981;
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-export-csv:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        /* Card Styling */
        .analysis-card {
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .analysis-card .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
        }

        .analysis-card .card-header h5 {
            font-weight: 700;
            color: #334155;
            margin-bottom: 0;
        }

        /* Legend Box Styling */
        .urgency-legend {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #f1f5f9;
            width: 100%;
            display: flex;
            justify-content: space-around;
        }

        .legend-item .count {
            font-size: 1.25rem;
            font-weight: 800;
        }

        .legend-item .label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Table Styling */
        .flagged-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            border-top: none;
        }

        .urgency-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.75rem;
        }
    </style>

    <div class="content-wrapper px-4 py-4">
        {{-- HEADER SECTION --}}
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <p class="text-primary fw-bold mb-1" style="font-size: 0.85rem; text-transform: uppercase;">Machine Learning
                    Model</p>
                <h1 class="page-title">Classification Analysis</h1>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.classification.run') }}" class="btn btn-run-analysis px-4 py-2 shadow-sm">
                    <i class="fas fa-play me-2"></i> Run Random Forest
                </a>
                <a href="{{ route('admin.classification.export') }}" class="btn btn-export-csv px-4 py-2 shadow-sm">
                    <i class="fas fa-file-csv me-2"></i> Export CSV
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
        @endif

        @if (!$results)
            <div class="alert alert-info border-0 shadow-sm rounded-3">
                <i class="fas fa-info-circle me-2"></i> No active analysis. Initiate Random Forest to visualize urgency
                levels.
            </div>
        @else
            <div class="row g-4 mb-4">
                {{-- URGENCY DISTRIBUTION --}}
                <div class="col-md-6">
                    <div class="analysis-card">
                        <div class="card-header">
                            <h5>Urgency Distribution</h5>
                            <small class="text-muted">Breakdown of population by urgency classification</small>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div style="height: 280px;">
                                <canvas id="urgencySummaryChart"></canvas>
                            </div>

                            <div class="urgency-legend mt-4">
                                <div class="legend-item text-center">
                                    <div class="count text-danger">{{ $results['summary']['High Urgency'] ?? 0 }}</div>
                                    <div class="label text-muted">High</div>
                                </div>
                                <div class="legend-item text-center">
                                    <div class="count text-warning">{{ $results['summary']['Medium Urgency'] ?? 0 }}</div>
                                    <div class="label text-muted">Medium</div>
                                </div>
                                <div class="legend-item text-center">
                                    <div class="count text-success">{{ $results['summary']['Low Urgency'] ?? 0 }}</div>
                                    <div class="label text-muted">Low</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FEATURE IMPORTANCE --}}
                <div class="col-md-6">
                    <div class="analysis-card">
                        <div class="card-header">
                            <h5>Feature Importance</h5>
                            <small class="text-muted">Impact of specific variables on model predictions</small>
                        </div>
                        <div class="card-body p-4">
                            <div style="height: 380px;">
                                <canvas id="featureImportanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FLAGGED CASES --}}
            <div class="analysis-card mb-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5><i class="fas fa-exclamation-triangle text-danger me-2"></i> Flagged High Urgency Cases</h5>
                        <small class="text-muted">Individuals predicted at the highest priority level</small>
                    </div>
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold">
                        {{ count($highUrgencyAnomalies ?? []) }} High Priority Entries
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table flagged-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Client ID</th>
                                    <th>Barangay</th>
                                    <th>Assistances</th>
                                    <th>Total Disbursed</th>
                                    <th class="text-center">Classification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $highUrgencyAnomalies = array_filter($results['anomalies'] ?? [], function ($row) {
                                        return ($row['predicted_urgency'] ?? '') === 'High Urgency';
                                    });
                                @endphp

                                @forelse ($highUrgencyAnomalies as $row)
                                    <tr>
                                        <td class="ps-4 fw-bold">#{{ $row['client_id'] }}</td>
                                        <td>{{ $row['barangay'] }}</td>
                                        <td>{{ $row['total_assistances'] }}</td>
                                        <td>{{ $row['total_amount'] ? '₱' . number_format($row['total_amount'], 2) : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            <span class="urgency-badge bg-danger text-white">HIGH URGENCY</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No high-urgency anomalies
                                            detected in current run.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if ($results)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
=======

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

                @if (!$results)
                    <div class="alert alert-info">No results yet. Click “Run Random Forest Analysis” to generate
                        classification.</div>
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
                                                <div style="color: #e74c3c;">{{ $results['summary']['High Urgency'] ?? 0 }}
                                                </div>
                                            </div>

                                            <div style="text-align: center;">
                                                <div style="color: #f39c12; font-weight: 700;">Medium</div>
                                                <div style="color: #f39c12;">
                                                    {{ $results['summary']['Medium Urgency'] ?? 0 }}</div>
                                            </div>

                                            <div style="text-align: center;">
                                                <div style="color: #2ecc71; font-weight: 700;">Low</div>
                                                <div style="color: #2ecc71;">{{ $results['summary']['Low Urgency'] ?? 0 }}
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
                                    <canvas id="featureImportanceChart"
                                        style="max-height: 400px; width:100%; height:300px;"></canvas>
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

                            <span
                                style="background-color: #e74c3c20; color:#e74c3c; padding:5px 14px; border-radius: 8px; font-weight:600;">
                                {{ count($highUrgencyAnomalies ?? []) }} cases
                            </span>
                        </div>

                        {{-- Inner Card Like Screenshot --}}
                        <div class="p-3"
                            style="background-color: #fafafa; border-radius: 20px; border: 1px solid #e6e6e6;">

                            @php
                                $highUrgencyAnomalies = array_filter($results['anomalies'] ?? [], function ($row) {
                                    return ($row['predicted_urgency'] ?? '') === 'High Urgency';
                                });
                            @endphp

                            @if (empty($highUrgencyAnomalies))
                                <p class="text-muted">No high urgency cases found.</p>
                            @else
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
                                                <td>{{ $row['client_id'] }}</td>
                                                <td>{{ $row['barangay'] }}</td>
                                                <td>{{ $row['total_assistances'] }}</td>
                                                <td>{{ $row['total_amount'] ? '₱' . number_format($row['total_amount'], 2) : 'N/A' }}
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
                            @endif
                        </div>
                    </div>

                @endif
            </div>
        </section>
    </div>


    @if ($results)
        <script src="{{ asset('js/chart.js') }}"></script>
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        <script>
            const rawSummary = @json($results['summary'] ?? []);
            const rawImportance = @json($results['feature_importance'] ?? []);

<<<<<<< HEAD
            // Urgency Donut
=======
            /* ---------------------------------------------------
               1) FIX SUMMARY KEYS (Always return 3 labels)
            --------------------------------------------------- */
            const summary = {
                "High Urgency": rawSummary["High Urgency"] ?? 0,
                "Medium Urgency": rawSummary["Medium Urgency"] ?? 0,
                "Low Urgency": rawSummary["Low Urgency"] ?? 0
            };

            /* ---------------------------------------------------
               2) FIX FEATURE IMPORTANCE (Avoid empty/undefined)
            --------------------------------------------------- */
            let featureImportance = Array.isArray(rawImportance) ? rawImportance : [];

            if (featureImportance.length === 0) {
                featureImportance = [{
                        feature: "total_assistances",
                        importance: 0
                    },
                    {
                        feature: "total_amount",
                        importance: 0
                    }
                ];
            } else {
                // Replace broken values like "undefined"
                featureImportance = featureImportance.map(f => ({
                    feature: f.feature ?? "Unknown",
                    importance: (typeof f.importance === "number" && !isNaN(f.importance)) ?
                        f.importance :
                        0
                }));
            }

            /* ---------------------------------------------------
               3) URGENCY DONUT CHART (Stable always)
            --------------------------------------------------- */
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            new Chart(document.getElementById('urgencySummaryChart'), {
                type: 'doughnut',
                data: {
                    labels: ["High", "Medium", "Low"],
                    datasets: [{
                        data: [
<<<<<<< HEAD
                            rawSummary["High Urgency"] ?? 0,
                            rawSummary["Medium Urgency"] ?? 0,
                            rawSummary["Low Urgency"] ?? 0
                        ],
                        backgroundColor: ["#ef4444", "#f59e0b", "#10b981"],
                        hoverOffset: 15,
                        borderWidth: 0
=======
                            summary["High Urgency"],
                            summary["Medium Urgency"],
                            summary["Low Urgency"]
                        ],
                        backgroundColor: [
                            "#e74c3c", // red
                            "#f39c12", // yellow
                            "#2ecc71" // green
                        ]
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
<<<<<<< HEAD
                    cutout: '75%',
=======
                    cutout: "60%",
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

<<<<<<< HEAD
            // Feature Importance Bar
            new Chart(document.getElementById('featureImportanceChart'), {
                type: 'bar',
                data: {
                    labels: rawImportance.map(f => f.feature.replace('_', ' ')),
                    datasets: [{
                        label: 'Importance Score',
                        data: rawImportance.map(f => f.importance),
                        backgroundColor: "#3b82f6",
                        borderRadius: 8,
=======
            /* ---------------------------------------------------
               4) FEATURE IMPORTANCE CHART (Safe always)
            --------------------------------------------------- */
            new Chart(document.getElementById('featureImportanceChart'), {
                type: 'bar',
                data: {
                    labels: featureImportance.map(f => f.feature),
                    datasets: [{
                        data: featureImportance.map(f => f.importance),
                        backgroundColor: "#3498db"
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
<<<<<<< HEAD
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
=======
                            beginAtZero: true
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endif
<<<<<<< HEAD
=======

>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
@endsection
