@extends('layouts.app')

@section('style')
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

        .chart-wrap {
            height: 350px;
            position: relative;
        }

        .kmeans-chart-container {
            height: 400px;
            position: relative;
        }

        .card-header.chart-header-blue {
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
        }

        .report-filter-bar {
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .filter-group {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 5px 12px;
            transition: all 0.3s ease;
        }

        .filter-group:focus-within {
            border-color: #34495e;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(52, 73, 94, 0.1);
        }

        .filter-group i {
            color: #34495e;
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .filter-select {
            border: none;
            background: transparent;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4a5568;
            outline: none;
            cursor: pointer;
            min-width: 140px;
        }

        .btn-filter-primary {
            background: #34495e;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-filter-primary:hover {
            background: #2c3e50;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .kmeans-controls {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="m-0 fw-bold">Reports & Visualization</h1>
                    </div>

                    <form method="GET" action="{{ route('admin.reports') }}" class="report-filter-bar mb-4">
                        <div class="filter-group">
                            <i class="fas fa-map-marker-alt"></i>
                            <select name="barangay" id="barangayFilter" class="filter-select">
                                <option value="">Full Distribution</option>
                                @foreach ($barangayList as $b)
                                    <option value="{{ $b }}" {{ request('barangay') == $b ? 'selected' : '' }}>
                                        {{ $b }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <i class="fas fa-calendar-alt"></i>
                            <select name="month" class="filter-select">
                                <option value="">All Months</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="filter-group">
                            <i class="fas fa-history"></i>
                            <select name="year" class="filter-select">
                                <option value="">All Years</option>
                                @for ($y = now()->year; $y >= now()->year - 10; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="btn-filter-primary">
                            <i class="fas fa-filter me-1"></i> Apply Filter
                        </button>

                        <a href="{{ route('admin.reports') }}"
                            class="btn btn-light border btn-sm py-2 px-3 fw-bold text-muted" style="border-radius: 8px;">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </form>

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
                            <strong>{{ $topBarangay }}</strong> has the highest number of assistance records, accounting
                            for approximately <strong>{{ $topBarangayPercent }}%</strong> of all beneficiaries.
                        </p>

                        <p class="mb-2">
                            <strong>Most Common Assistance Type:</strong><br>
                            <strong>{{ $topType }}</strong> assistance is the most frequently availed service,
                            representing <strong>{{ $topTypePercent }}%</strong> of all recorded transactions.
                        </p>

                        <p class="mb-0">
                            <strong>Recent Trend:</strong><br>
                            In <strong>{{ $latestMonth }}</strong>, there were <strong>{{ $latestMonthCount }}</strong>
                            recorded assistance cases. This represents a
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
                    <a href="{{ route('admin.clustering.run') }}" class="btn btn-primary"
                        onclick="return confirm('Re-run clustering? This will recompute all clusters.')">
                        🔄 Run Clustering
                    </a>
                </div>

                <div class="kmeans-controls mb-3">
                    <div class="filter-group" style="width: 280px; background: white;">
                        <i class="fas fa-bullseye" style="color: #e74c3c;"></i>
                        <span style="font-size: 0.75rem; font-weight: 800; color: #34495e; margin-right: 5px;">CLUSTER
                            VIEW:</span>
                        <select id="kmeansBarangayFilter" class="filter-select">
                            <option value="">Full Distribution</option>
                            @foreach ($barangayList as $b)
                                <option value="{{ $b }}">{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card shadow-sm report-card">
                    <div class="card-header chart-header-blue">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-project-diagram mr-2"></i> Barangay Need Clustering
                        </h5>
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
        </section>
    </div>

    <script src="{{ asset('js/chart.min.js') }}"></script>

    <script>
        let kmeansChart = null;

        document.addEventListener("DOMContentLoaded", () => {
            const brgyFilter = document.getElementById('kmeansBarangayFilter');

            function normalizeBarangay(name) {
                if (!name) return '';

                const mapping = {
                    'A O FLORIENDO': 'A._O._FLOIRENDO',
                    'A O FLOIRENDO': 'A._O._FLOIRENDO',
                    'A.O. FLORIENDO': 'A._O._FLOIRENDO',
                    'A. O. FLORIENDO': 'A._O._FLOIRENDO',
                    'JP LAUREL': 'J.P._LAUREL',
                    'J.P. LAUREL': 'J.P._LAUREL',
                    'J P LAUREL': 'J.P._LAUREL',
                    'J. P. LAUREL': 'J.P._LAUREL',
                    'BUENAVISTA': 'BUENAVISTA',
                    'CACAO': 'CACAO',
                    'CAGANGOHAN': 'CAGANGOHAN',
                    'CONSOLACION': 'CONSOLACION',
                    'DAPCO': 'DAPCO',
                    'DATU ABDUL DADIA': 'DATU_ABDUL_DADIA',
                    'GREDU': 'GREDU',
                    'KASILAK': 'KASILAK',
                    'KATIPUNAN': 'KATIPUNAN',
                    'KATUALAN': 'KATUALAN',
                    'KAUSWAGAN': 'KAUSWAGAN',
                    'KIOTOY': 'KIOTOY',
                    'LITTLE PANAY': 'LITTLE_PANAY',
                    'LOWER PANAGA': 'LOWER_PANAGA',
                    'MABUNAO': 'MABUNAO',
                    'MADUAO': 'MADUAO',
                    'MALATIVAS': 'MALATIVAS',
                    'MANAY': 'MANAY',
                    'NANYO': 'NANYO',
                    'NEW MALAGA': 'NEW_MALAGA',
                    'NEW MALITBOG': 'NEW_MALITBOG',
                    'NEW PANDAN': 'NEW_PANDAN',
                    'NEW VISAYAS': 'NEW_VISAYAS',
                    'QUEZON': 'QUEZON',
                    'SALVACION': 'SALVACION',
                    'SAN FRANCISCO': 'SAN_FRANCISCO',
                    'SAN NICOLAS': 'SAN_NICOLAS',
                    'SAN PEDRO': 'SAN_PEDRO',
                    'SAN ROQUE': 'SAN_ROQUE',
                    'SAN VICENTE': 'SAN_VICENTE',
                    'SANTA CRUZ': 'SANTA_CRUZ',
                    'SANTO NIÑO': 'SANTO_NIÑO',
                    'SANTO NINO': 'SANTO_NIÑO',
                    'SINDATON': 'SINDATON',
                    'SOUTHERN DAVAO': 'SOUTHERN_DAVAO',
                    'TAGPORE': 'TAGPORE',
                    'TIBUNGOL': 'TIBUNGOL',
                    'UPPER LICANAN': 'UPPER_LICANAN',
                    'WATERFALL': 'WATERFALL',
                };

                const trimmed = name.trim().toUpperCase();
                console.log(`Normalizing: "${trimmed}"`);

                if (mapping[trimmed]) {
                    console.log(`✅ Using mapped filename: ${mapping[trimmed]}`);
                    return mapping[trimmed];
                }

                const noSpaces = trimmed.replace(/\s+/g, '_');
                if (mapping[noSpaces]) {
                    console.log(`✅ Using mapped filename (no spaces): ${mapping[noSpaces]}`);
                    return mapping[noSpaces];
                }

                console.log(`⚠️ No mapping found for: ${trimmed}, using: ${noSpaces}`);
                return noSpaces;
            }

            function loadAndRender() {
                const selectedBrgy = brgyFilter.value;

                console.log("=== LOADING BARANGAY DATA ===");
                console.log("Selected:", selectedBrgy);

                if (!selectedBrgy) {
                    fetch("/python/cluster_results.json?v=" + Date.now())
                        .then(res => {
                            if (!res.ok) throw new Error("HTTP " + res.status);
                            return res.json();
                        })
                        .then(data => renderKMeans(data, selectedBrgy))
                        .catch(err => {
                            console.error("Full distribution error:", err);
                            document.getElementById('insightsText').innerHTML =
                                '<span class="text-danger">No full distribution data found.</span>';
                            if (kmeansChart) kmeansChart.destroy();
                        });
                    return;
                }

                const filename = normalizeBarangay(selectedBrgy);
                const url = `/python/cluster_results_${filename}.json?v=` + Date.now();

                console.log("Attempting to load:", url);

                fetch(url)
                    .then(res => {
                        console.log("Response status:", res.status);
                        console.log("Response URL:", res.url);
                        if (!res.ok) throw new Error(`HTTP ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        console.log(`✅ Successfully loaded data for ${selectedBrgy}`);
                        console.log("Data received:", data);
                        console.log("Data length:", data.length);

                        if (data.length === 0) {
                            console.log(
                            "Individual file is empty, trying to extract from full distribution...");
                            return extractBarangayData(selectedBrgy);
                        }

                        renderKMeans(data, selectedBrgy);
                    })
                    .catch(err => {
                        console.log("Individual file not found, trying to extract from full distribution...");
                        extractBarangayData(selectedBrgy);
                    });
            }

            function extractBarangayData(barangayName) {
                fetch("/python/cluster_results.json?v=" + Date.now())
                    .then(res => res.json())
                    .then(fullData => {
                        const barangayData = fullData.find(item =>
                            item.barangay?.toUpperCase() === barangayName.toUpperCase() ||
                            item.name?.toUpperCase() === barangayName.toUpperCase()
                        );

                        if (barangayData) {
                            console.log("Found barangay in full distribution:", barangayData);

                            const mockTransactions = [{
                                transaction_id: 1,
                                amount: barangayData.total_amount || barangayData.amount || 0,
                                cluster: barangayData.cluster_label || barangayData.cluster ||
                                    "Unknown",
                                assistances: barangayData.total_assistances || barangayData
                                    .assistances || 0
                            }];

                            renderKMeans(mockTransactions, barangayName);
                        } else {
                            document.getElementById('insightsText').innerHTML =
                                `<span class="text-warning"><strong>${barangayName}</strong> not found in full distribution data.</span>`;
                        }
                    })
                    .catch(err => {
                        console.error("Error loading full distribution:", err);
                        document.getElementById('insightsText').innerHTML =
                            '<span class="text-danger">Could not load full distribution data.</span>';
                    });
            }

            function renderKMeans(clusterData, selectedBrgy = "") {
                console.log("📊 renderKMeans called with:", clusterData);

                const colors = {
                    "High Need": "#e74c3c",
                    "Medium Need": "#f1c40f",
                    "Low Need": "#2ecc71"
                };

                if (!clusterData || clusterData.length === 0) {
                    document.getElementById('insightsText').innerHTML =
                        `<span class="text-warning">No transaction data for ${selectedBrgy || 'selected view'}.</span>`;

                    const canvas = document.getElementById('kmeansChart');
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    if (kmeansChart) {
                        kmeansChart.destroy();
                        kmeansChart = null;
                    }
                    return;
                }

                let points = [];

                if (!selectedBrgy) {
                    points = clusterData.map(item => ({
                        x: Number(item.total_assistances || item.assistances || 0),
                        y: Number(item.total_amount || item.amount || 0),
                        _label: item.barangay || "Unknown",
                        _cluster: item.cluster_label || item.cluster || "Unknown"
                    }));
                } else {
                    points = clusterData.map((item, index) => {
                        let cluster = item.cluster_label || item.cluster;
                        if (!cluster) {
                            if (item.amount >= 1000) cluster = "High Need";
                            else if (item.amount >= 800) cluster = "Medium Need";
                            else cluster = "Low Need";
                        }

                        return {
                            x: index + 1,
                            y: Number(item.amount),
                            _cluster: cluster,
                            _tx: item.transaction_id || index + 1
                        };
                    });
                }

                const ctx = document.getElementById('kmeansChart').getContext('2d');

                if (kmeansChart) {
                    kmeansChart.destroy();
                }

                kmeansChart = new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: selectedBrgy || 'All Barangays',
                            data: points,
                            pointRadius: 8,
                            pointHoverRadius: 10,
                            backgroundColor: points.map(p => colors[p._cluster] || "#3498db")
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const p = context.raw;
                                        if (!selectedBrgy) {
                                            return `${p._label} — ₱${p.y.toLocaleString()} (${p._cluster})`;
                                        } else {
                                            return `Transaction ${p._tx} — ₱${p.y.toLocaleString()} (${p._cluster})`;
                                        }
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: selectedBrgy ? 'Transaction Number' : 'Total Assistances'
                                },
                                beginAtZero: true
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Amount (₱)'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });

                if (!selectedBrgy) {
                    document.getElementById('insightsText').innerHTML =
                        `<strong>Showing ${clusterData.length}</strong> barangay(s)`;
                } else {
                    const highCount = points.filter(p => p._cluster === "High Need").length;
                    const mediumCount = points.filter(p => p._cluster === "Medium Need").length;
                    const lowCount = points.filter(p => p._cluster === "Low Need").length;

                    document.getElementById('insightsText').innerHTML = `
                        <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
                            <span style="color: #e74c3c; font-weight: 600;">
                                <span style="font-size: 1.2rem;">●</span> High: ${highCount}
                            </span>
                            <span style="color: #f1c40f; font-weight: 600;">
                                <span style="font-size: 1.2rem;">●</span> Medium: ${mediumCount}
                            </span>
                            <span style="color: #2ecc71; font-weight: 600;">
                                <span style="font-size: 1.2rem;">●</span> Low: ${lowCount}
                            </span>
                            <span style="color: #34495e; margin-left: auto;">
                                Total: ${points.length} transaction(s)
                            </span>
                        </div>
                    `;
                }
            }

            brgyFilter.addEventListener('change', loadAndRender);
            loadAndRender();
        });
    </script>
@endsection

@section('script')
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

        const palette = {
            blue: '#3b82c4',
            teal: '#d97027',
            warm: '#f6b042',
            green: '#4caf50',
            mutedGray: '#9aa6b2'
        };

        (function() {
            const ctx = document.getElementById('topBarangaysChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: topBarangayLabels,
                    datasets: [{
                        label: 'Entries',
                        data: topBarangayCounts,
                        backgroundColor: palette.blue,
                        borderRadius: 6,
                        barThickness: 26
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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

        (function() {
            const ctx = document.getElementById('assistanceTypeChart').getContext('2d');
            const colors = [palette.blue, palette.teal, palette.warm, palette.green];
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: assistanceLabels,
                    datasets: [{
                        data: assistanceCounts,
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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

        (function() {
            const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Monthly Entries',
                        data: monthlyTotals,
                        backgroundColor: palette.blue,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                        }
                    }
                }
            });
        })();
    </script>
@endsection
