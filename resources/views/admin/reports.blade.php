@extends('layouts.app')

@section('style')
<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Global Background and Typography */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .content-wrapper {
            background-color: #f8fafc !important;
            padding: 2rem 1.5rem;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #0f172a;
            font-size: 2.25rem;
            letter-spacing: -0.025em;
        }

        /* Unified Action Bar (Top Filter Bar) */
        .action-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 15px 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .custom-filter-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #475569;
            min-width: 150px;
            background-color: #f8fafc;
        }

        /* Modern Button Styles */
        .btn-filter-apply {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-filter-apply:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .btn-filter-reset {
            background-color: #ffffff;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-action-outline {
            background-color: #ffffff;
            color: #3b82f6;
            border: 1px solid #3b82f6;
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-action-primary {
            background: linear-gradient(135deg, #1D4FA1 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-action-primary:hover {
            color: white;
            box-shadow: 0 5px 15px rgba(29, 79, 161, 0.3);
            transform: translateY(-1px);
        }

        /* Summary Cards */
        .summary-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            height: 100%;
            transition: 0.2s;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .summary-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
        }

        /* Report Component Cards */
        .report-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card-header-modern {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
        }

        .chart-wrap {
            height: 350px;
            padding: 1.5rem;
        }

        .insight-box {
            background: #eff6ff;
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 5px solid #3b82f6;
        }

        /* AI Status Pulse Animation */
        .ai-status-pulse {
            width: 10px;
            height: 10px;
            background: #3b82f6;
            border-radius: 50%;
            box-shadow: 0 0 0 rgba(59, 130, 246, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        /* Segmented Control (The Toggle) */
        .segmented-control {
            position: relative;
            display: flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            width: 280px;
        }

        .segmented-control input {
            display: none;
        }

        .segmented-control label {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            margin: 0;
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            cursor: pointer;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .segmented-control input:checked+label {
            color: #ffffff;
        }

        /* The sliding background pill */
        .selection-slider {
            position: absolute;
            top: 4px;
            left: 4px;
            width: calc(50% - 4px);
            height: calc(100% - 8px);
            background: #3b82f6;
            border-radius: 10px;
            z-index: 1;
            transition: transform 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        #modePerson:checked~.selection-slider {
            transform: translateX(100%);
=======
    <style>
        /* Soft background and card styles (reduced contrast) */
        body {
            background-color: #f3f6fa;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: 700;
            /* CORRECT: Retain #1f4e8a for Title/Summary Numbers */
            color: #1f4e8a;
        }

        .report-card {
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(30, 45, 60, 0.06);
            border: 1px solid rgba(20, 35, 60, 0.03);
        }

        .summary-card {
            background: linear-gradient(180deg, #ffffff, #fbfdff);
            border: 1px solid rgba(20, 35, 60, 0.04);
            border-radius: 8px;
            padding: 18px;
        }

        .summary-value {
            font-size: 1.35rem;
            font-weight: 700;
            /* CORRECT: Retain #1f4e8a for Title/Summary Numbers */
            color: #1f4e8a;
        }

        .summary-label {
            font-size: 0.85rem;
            color: #576574;
        }

        /* * =============================================
                          * CHART HEIGHT CLASSES
                          * =============================================
                        */
        .chart-wrap {
            /* Container for Top 5 and Assistance Type charts */
            height: 350px;
            position: relative;
        }

        .kmeans-chart-container {
            height: 400px;
            position: relative;
        }

        /* * =============================================
                          * CHART HEADER PATCH COLOR (#34495e)
                          * =============================================
                        */
        .card-header.chart-header-blue {
            /* FIXED: Using the requested color #34495e */
            background-color: #34495e !important;
            color: #fff;
            border-bottom: none;
            padding: 0.75rem 1.25rem;
            margin: 0;
        }

        .card-header.chart-header-blue:first-child {
            border-radius: calc(0.5rem - 1px) calc(0.5rem - 1px) 0 0;
        }

        .card-header.chart-header-blue h5 {
            margin: 0;
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
<<<<<<< HEAD
        <div class="container-fluid">

            {{-- Flash Messages --}}
            @include('_message')

            {{-- Header Section --}}
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 mt-2">
                <div>
                    <p class="text-primary fw-bold mb-1"
                        style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Intelligence Hub</p>
                    <h1>Reports & Visualization</h1>
                </div>
                @if ($lastUpdated)
                    <p class="text-muted mb-1" style="font-size: 0.85rem;">
                        <i class="far fa-clock me-1"></i> Sync:
                        {{ \Carbon\Carbon::parse($lastUpdated)->format('M d, g:i A') }}
                    </p>
                @endif
            </div>

            {{-- Unified Action Bar (Filters & Exports) --}}
            <div class="action-container shadow-sm">
                <form method="GET" action="{{ route('admin.reports') }}" class="d-flex align-items-center gap-3 mb-0">
                    <select name="barangay" class="form-select custom-filter-select">
                        <option value="">All Barangays</option>
                        @foreach ($barangayList as $b)
                            <option value="{{ $b->barangay }}" {{ request('barangay') == $b->barangay ? 'selected' : '' }}>
                                {{ $b->barangay }}</option>
                        @endforeach
                    </select>

                    <select name="month" class="form-select custom-filter-select">
                        <option value="">All Months</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                    </select>

                    <select name="year" class="form-select custom-filter-select">
                        <option value="">All Years</option>
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                {{ $y }}</option>
                        @endfor
                    </select>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-filter-apply px-4">Filter</button>
                        <a href="{{ route('admin.reports') }}" class="btn-filter-reset">Reset</a>
                    </div>
                </form>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.reports.export') }}" class="btn-action-outline"><i
                            class="fas fa-file-csv me-1"></i> Export CSV</a>
                    <a href="{{ route('admin.updateAI') }}" class="btn-action-primary shadow-sm"><i
                            class="fas fa-sync-alt me-1"></i> Update AI</a>
                </div>
            </div>

            {{-- Summary Cards Row --}}
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="summary-card shadow-sm">
                        <div class="summary-label">Disbursement Total</div>
                        <div class="summary-value text-primary">₱{{ number_format($totalAssistanceAmount, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card shadow-sm">
                        <div class="summary-label">Total Beneficiaries</div>
                        <div class="summary-value">{{ number_format($totalBeneficiaries) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card shadow-sm">
                        <div class="summary-label">Top Barangay</div>
                        <div class="summary-value text-uppercase" style="font-size: 1.4rem;">{{ $topBarangayName }}</div>
                    </div>
                </div>
            </div>

            {{-- Charts Row --}}
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="report-card">
                        <div class="card-header-modern">
                            <h5><i class="fas fa-chart-bar me-2 text-primary"></i> Priority Barangays</h5>
                        </div>
                        <div class="chart-wrap"><canvas id="topBarangaysChart"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="report-card">
                        <div class="card-header-modern">
                            <h5><i class="fas fa-chart-pie me-2 text-primary"></i> Support Type Split</h5>
                        </div>
                        <div class="chart-wrap"><canvas id="assistanceTypeChart"></canvas></div>
                    </div>
                </div>
            </div>

            {{-- AI Clustering Intelligence Section --}}
            <div class="report-card mb-4 shadow-sm">
                <div class="card-header-modern d-flex align-items-center justify-content-between p-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="ai-status-pulse"></div>
                        <h5 class="mb-0 fw-bold">AI Clustering Intelligence</h5>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        {{-- Premium Toggle --}}
                        <div class="segmented-control">
                            <input type="radio" name="mode" value="barangay" id="modeBarangay" checked>
                            <label for="modeBarangay">By Barangay</label>
                            <input type="radio" name="mode" value="person" id="modePerson">
                            <label for="modePerson">By Person</label>
                            <div class="selection-slider"></div>
                        </div>

                        {{-- Barangay Selector (Only for Person Mode) --}}
                        <div id="personBarangayWrapper" style="display: none;">
                            <select id="personBarangaySelect" class="custom-filter-select"
                                style="min-width: 220px; border: 1px solid #3b82f6; background-color: #eff6ff;">
                                <option value="">Choose Barangay...</option>
                                @foreach ($barangayList as $b)
                                    @php
                                        $originalName = strtoupper($b->barangay);

                                        // 1. Specific Fix for Sto. Niño variants
                                        if (
                                            str_contains($originalName, 'STO. NIÑO') ||
                                            str_contains($originalName, 'SANTO NIÑO')
                                        ) {
                                            $safe = 'STO_NINO';
                                        }
                                        // 2. General logic for everyone else (Gredu, Lower Panaga, etc.)
                                        else {
                                            // Remove parentheses content but keep the main name
                                            // Example: "GREDU (POBLACION)" -> "GREDU"
                                            $safe = preg_replace('/\s*\(.*?\)\s*/', '', $originalName);

                                            // Clean up special characters
                                            $safe = str_replace(['.', 'Ñ'], ['', 'N'], $safe);

                                            // Replace spaces with underscores
                                            $safe = preg_replace('/\s+/', '_', trim($safe));
                                        }
                                    @endphp
                                    <option value="{{ $safe }}">{{ $b->barangay }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px;"><canvas id="kmeansChart"></canvas></div>
                    <div class="insight-box mt-4" id="insightsText">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div> Assessing
                        records...
                    </div>
                </div>
            </div>
        </div>
=======
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    <div>
                        <h1 class="m-0 fw-bold">Reports & Visualization</h1>
                    </div>

                    <div class="text-end">

                        <div class="mb-2">
                            <a href="{{ route('admin.updateAI') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-sync-alt me-1"></i> Update Analytics
                            </a>
                            <a href="{{ route('admin.reports.export') }}" class="btn btn-outline-primary btn-sm ms-2">
                                <i class="fas fa-file-csv me-1"></i> Export CSV Report
                            </a>
                        </div>

                        @if ($lastUpdated)
                            <p class="text-muted" style="font-size: 14px;">
                                🕒 Last Updated:
                                {{ \Carbon\Carbon::parse($lastUpdated)->format('F d, Y h:i A') }}
                            </p>
                        @endif

                    </div>
                </div>
            </div>
        </section>



        <section class="content">
            <div class="container-fluid">
                @include('_message')

                {{-- Summary Cards (Text color is #1f4e8a) --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div class="summary-label">Total Assistance Amount</div>
                            <div class="summary-value">₱{{ number_format($totalAssistanceAmount, 2) }}</div>
                            <div class="text-muted mt-1" style="font-size:0.85rem;">Cumulative amount paid</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="summary-card">
                            <div class="summary-label">Total Beneficiary Entries</div>
                            <div class="summary-value">{{ number_format($totalBeneficiaries) }}</div>
                            <div class="text-muted mt-1" style="font-size:0.85rem;">Distinct beneficiaries in AR</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="summary-card">
                            <div class="summary-label">Top Barangay (by entries)</div>
                            <div class="summary-value">{{ $topBarangayName }} ({{ $topBarangayCount }})</div>
                            <div class="text-muted mt-1" style="font-size:0.85rem;">Most assistance entries</div>
                        </div>
                    </div>
                </div>

                {{-- Row with Top 5 and Distribution Charts (Header is #34495e) --}}
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card report-card">
                            <div class="card-header chart-header-blue">
                                <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i> Top 5 Barangays (by beneficiaries)
                                </h5>
                            </div>
                            <div class="card-body chart-wrap p-3">
                                <canvas id="topBarangaysChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card report-card">
                            <div class="card-header chart-header-blue">
                                <h5 class="mb-0"><i class="fas fa-chart-pie mr-2"></i> Assistance Type Distribution</h5>
                            </div>
                            <div class="card-body chart-wrap p-3">
                                <canvas id="assistanceTypeChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Monthly Trend Chart (Header is #34495e) --}}
                    <div class="col-12 mb-4">
                        <div class="card report-card">
                            <div class="card-header chart-header-blue">
                                <h5 class="mb-0"><i class="fas fa-chart-line mr-2"></i> Monthly Assistance Trend (last 12
                                    months)</h5>
                            </div>
                            <div class="card-body p-3" style="height: 300px; position: relative;">
                                <canvas id="monthlyTrendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- System Insights Summary --}}
                <div class="card report-card mb-4">
                    <div class="card-header border-0 pb-0">
                        <h5 class="mb-0">System Insights Summary</h5>
                    </div>
                    <div class="card-body text-muted">
                        @php
                            $totalEntries = $barangayData->sum('total_assistances');
                            $topBarangay = $topBarangayName ?? '—';
                            $topBarangayPercent =
                                $totalEntries > 0 ? round(($topBarangayCount / $totalEntries) * 100, 1) : 0;

                            $topType = $assistanceTypeData->first()->type ?? '—';
                            $topTypeCount = $assistanceTypeData->first()->total ?? 0;
                            $totalTypeCount = $assistanceTypeData->sum('total');
                            $topTypePercent =
                                $totalTypeCount > 0 ? round(($topTypeCount / $totalTypeCount) * 100, 1) : 0;

                            $latestMonth = $monthlyTrend->last()->month ?? '—';
                            $latestMonthCount = $monthlyTrend->last()->total ?? 0;
                            $prevMonthCount =
                                $monthlyTrend->count() > 1 ? $monthlyTrend[$monthlyTrend->count() - 2]->total : 0;
                            $monthChange =
                                $prevMonthCount > 0
                                    ? round((($latestMonthCount - $prevMonthCount) / $prevMonthCount) * 100, 1)
                                    : 0;
                        @endphp

                        <p class="mb-2">
                            <strong>Overall Summary:</strong><br>
                            The system recorded a total of <strong>{{ number_format($totalEntries) }}</strong> assistance
                            entries across all barangays.
                        </p>

                        <p class="mb-2">
                            <strong>Top Barangay:</strong><br>
                            <strong>{{ $topBarangay }}</strong> has the highest number of assistance records,
                            accounting for approximately <strong>{{ $topBarangayPercent }}%</strong> of all beneficiaries.
                        </p>

                        <p class="mb-2">
                            <strong>Most Common Assistance Type:</strong><br>
                            <strong>{{ $topType }}</strong> assistance is the most frequently availed service,
                            representing <strong>{{ $topTypePercent }}%</strong> of all recorded transactions.
                        </p>

                        <p class="mb-0">
                            <strong>Recent Trend:</strong><br>
                            In <strong>{{ $latestMonth }}</strong>, there were
                            <strong>{{ $latestMonthCount }}</strong> recorded assistance cases.
                            This represents a
                            @if ($monthChange > 0)
                                <span class="text-success">+{{ $monthChange }}%</span> increase
                            @elseif($monthChange < 0)
                                <span class="text-danger">{{ $monthChange }}%</span> decrease
                            @else
                                no change
                            @endif
                            compared to the previous month.
                        </p>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <a href="{{ route('admin.reports.exportCluster') }}" class="btn btn-outline-primary">
                        <i class="fas fa-download"></i> Export K-Means Results (CSV)
                    </a>
                </div>

                {{-- K-Means Chart Section (Header is #34495e) --}}
                <div class="row mt-4">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm report-card">
                            <div class="card-header chart-header-blue">
                                <h5 class="card-title mb-0"><i class="fas fa-project-diagram mr-2"></i> Barangay Need
                                    Clustering (K-Means Visualization)</h5>
                            </div>
                            <div class="card-body">
                                <div class="kmeans-chart-container">
                                    <canvas id="kmeansChart"></canvas>
                                </div>
                                <hr>
                                <div id="insightsText" class="mt-3 text-muted" style="font-size: 1.05rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    fetch('/python/cluster_results.json?v=' + Date.now())
                    document.addEventListener("DOMContentLoaded", async () => {
                        try {
                            const response = await fetch("/python/cluster_results.json?v=" + Date.now());
                            const clusterData = await response.json();

                            const colors = {
                                "High Need": "#e74c3c", // Red
                                "Medium Need": "#f1c40f", // Yellow
                                "Low Need": "#2ecc71" // Green
                            };

                            const datasets = clusterData.map(item => ({
                                label: item.barangay,
                                data: [{
                                    x: item.total_assistances,
                                    y: item.total_amount
                                }],
                                backgroundColor: colors[item.cluster_label] || "#3498db",
                                pointRadius: 8,
                                pointHoverRadius: 10
                            }));

                            const ctx = document.getElementById('kmeansChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'scatter',
                                data: {
                                    datasets
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const d = context.raw;
                                                    const barangay = context.dataset.label;
                                                    const cluster = clusterData.find(x => x.barangay ===
                                                        barangay)?.cluster_label || 'Unknown';
                                                    return `${barangay} (${cluster}) — Assistances: ${d.x}, Amount: ₱${d.y.toLocaleString()}`;
                                                }
                                            }
                                        },
                                        legend: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Clustering of Barangays Based on Assistance Volume and Amount',
                                            font: {
                                                size: 16,
                                                weight: '600'
                                            } // Slightly smaller title
                                        }
                                    },
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Total Assistances'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Total Amount (₱)'
                                            },
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            const highNeed = clusterData.filter(x => x.cluster_label === "High Need").length;
                            const medNeed = clusterData.filter(x => x.cluster_label === "Medium Need").length;
                            const lowNeed = clusterData.filter(x => x.cluster_label === "Low Need").length;
                            const total = clusterData.length;

                            // Find the barangay with the highest combined demand for the summary
                            const topBarangay = clusterData.reduce((a, b) =>
                                a.total_amount + a.total_assistances > b.total_amount + b.total_assistances ? a : b
                            );

                            document.getElementById('insightsText').innerHTML = `
                        <strong>Insights Summary:</strong><br>
                        • Out of <strong>${total}</strong> barangays, <strong>${highNeed}</strong> are categorized as <span style="color:${colors["High Need"]};">High Need</span>.<br>
                        • Barangay <strong>${topBarangay.barangay}</strong> shows the highest total assistance demand (₱${topBarangay.total_amount.toLocaleString()} across ${topBarangay.total_assistances} assistances).<br>
                        • These insights help prioritize areas that require urgent welfare support.
                    `;
                        } catch (error) {
                            console.error("Error loading cluster data:", error);
                        }
                    });
                </script>


            </div>
        </section>
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
    </div>
@endsection

@section('script')
<<<<<<< HEAD
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <script src="{{ asset('js/chartjs-plugin-datalabels@2.js') }}"></script>

    <script>
        const palette = {
            blue: '#3b82f6',
            orange: '#f97316',
            green: '#10b981',
            yellow: '#facc15',
            red: '#ef4444'
        };
        let currentChart = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Priority Barangays Horizontal Bar
            new Chart(document.getElementById('topBarangaysChart'), {
                type: 'bar',
                data: {
                    labels: @json($topBarangays->pluck('barangay')),
                    datasets: [{
                        data: @json($topBarangays->pluck('total_assistances')),
                        backgroundColor: palette.blue,
                        borderRadius: 6
=======
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/chartjs-plugin-datalabels@2.js') }}"></script>

    <script>
        const topBarangayLabels = @json($topBarangays->pluck('barangay'));
        const topBarangayCounts = @json($topBarangays->pluck('total_assistances'));
        const topBarangayAmounts = @json($topBarangays->pluck('total_amount'));
        const assistanceLabels = @json($assistanceTypeData->pluck('type'));
        const assistanceCounts = @json($assistanceTypeData->pluck('total'));
        const monthlyLabels = @json($monthlyTrend->pluck('month'));
        const monthlyTotals = @json($monthlyTrend->pluck('total'));

        // Soft color palette
        const palette = {
            // Reverting this to the color that gives the correct Pharmacy/Bar chart look
            blue: '#3b82c4',
            // CORRECTED: Explicitly defined 'teal' as the requested orange for the Medical slice
            teal: '#d97027',
            warm: '#f6b042',
            green: '#4caf50',
            mutedGray: '#9aa6b2'
        };

        // NOTE: The K-Means points are NOT using this palette, they use their own defined colors.
        // However, the Top 5 and Monthly charts rely on palette.blue.

        // Top 5 Barangays (horizontal bar)
        (function() {
            const ctx = document.getElementById('topBarangaysChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: topBarangayLabels,
                    datasets: [{
                        label: 'Entries',
                        data: topBarangayCounts,
                        backgroundColor: palette.blue, // Uses '#3b82c4'
                        borderRadius: 6,
                        barThickness: 26
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
<<<<<<< HEAD
                        }
                    }
                }
            });

            // Assistance Type Doughnut
            new Chart(document.getElementById('assistanceTypeChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($assistanceTypeData->pluck('type')),
                    datasets: [{
                        data: @json($assistanceTypeData->pluck('total')),
                        backgroundColor: [palette.blue, palette.orange, palette.green, palette
                            .yellow
                        ],
                        borderWidth: 0
=======
                        },
                        datalabels: {
                            color: '#fff',
                            anchor: 'end',
                            align: 'end',
                            formatter: v => v,
                            font: {
                                weight: '600'
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: palette.mutedGray
                            }
                        },
                        y: {
                            ticks: {
                                color: palette.mutedGray
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        })();

        // Assistance Type pie chart (MODIFIED)
        (function() {
            const ctx = document.getElementById('assistanceTypeChart').getContext('2d');

            // This array defines the color order: [Pharmacy, Medical, ...]
            // The first slice (Pharmacy) uses palette.blue ('#3b82c4').
            // The second slice (Medical) uses palette.teal ('#d97027').
            const colors = [palette.blue, palette.teal, palette.warm, palette.green];
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: assistanceLabels,
                    datasets: [{
                        data: assistanceCounts,
                        backgroundColor: colors
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
<<<<<<< HEAD
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // --- AI Clustering Logic ---
            const barangayRadio = document.getElementById('modeBarangay');
            const personRadio = document.getElementById('modePerson');
            const barangayWrapper = document.getElementById('personBarangayWrapper');
            const personSelect = document.getElementById('personBarangaySelect');

            loadClusterData('barangay');

            function handleModeChange() {
                if (personRadio.checked) {
                    barangayWrapper.style.display = 'block';
                    document.getElementById('insightsText').innerHTML =
                        "Select a barangay to analyze specific person clusters.";
                    if (currentChart) currentChart.destroy();
                } else {
                    barangayWrapper.style.display = 'none';
                    loadClusterData('barangay');
                }
            }

            barangayRadio.addEventListener('change', handleModeChange);
            personRadio.addEventListener('change', handleModeChange);
            personSelect.addEventListener('change', function() {
                if (this.value !== '') loadClusterData('person', this.value);
            });
        });

        async function loadClusterData(mode = 'barangay', barangayKey = '') {
            let url = mode === 'person' ? `/python/cluster_results_tx_${barangayKey}.json?v=` + Date.now() :
                "/python/cluster_results.json?v=" + Date.now();
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error("JSON Missing");
                const data = await response.json();
                renderKMeans(data, mode);
            } catch (err) {
                document.getElementById('insightsText').innerHTML = "Data not yet available for this selection.";
                if (currentChart) currentChart.destroy();
            }
        }

        function renderKMeans(clusterData, mode = 'barangay') {
            const ctx = document.getElementById('kmeansChart').getContext('2d');
            if (currentChart) currentChart.destroy();

            const colors = {
                "High Need": palette.red,
                "Medium Need": palette.yellow,
                "Low Need": palette.green
            };

            currentChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: mode === 'barangay' ?
                        clusterData.map(item => ({
                            label: item.barangay,
                            data: [{
                                x: item.total_assistances,
                                y: item.total_amount
                            }],
                            backgroundColor: colors[item.cluster_label] || palette.blue,
                            pointRadius: 10
                        })) : [{
                            label: 'Records',
                            data: clusterData.map((item, i) => ({
                                x: i + 1,
                                y: item.total_amount,
                                cluster: item.cluster_label
                            })),
                            pointBackgroundColor: clusterData.map(item => colors[item.cluster_label] || palette
                                .blue),
                            pointRadius: 6
                        }]
=======
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: palette.mutedGray
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            formatter: (value, ctx) => {
                                const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                if (total === 0) return '';
                                return Math.round(value / total * 100) + '%';
                            },
                            font: {
                                weight: '600'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        })();

        // Monthly trend
        (function() {
            const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Monthly Entries',
                        data: monthlyTotals,
                        backgroundColor: palette.blue, // Uses '#3b82c4'
                        borderRadius: 4
                    }]
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
<<<<<<< HEAD
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: mode === 'barangay' ? 'Assistance Count' : 'Record Index'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Funds (₱)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
=======
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: palette.mutedGray
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: palette.mutedGray
                            }
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                        }
                    }
                }
            });
<<<<<<< HEAD

            const highCount = clusterData.filter(x => x.cluster_label === "High Need").length;
            document.getElementById('insightsText').innerHTML =
                `<strong>Intelligence Report:</strong> AI detected <strong>${highCount}</strong> High-Need segments requiring immediate priority in resource planning.`;
        }
=======
        })();
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
    </script>
@endsection
