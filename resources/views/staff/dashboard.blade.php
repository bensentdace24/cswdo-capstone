@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* Global & Layout Reset */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .content-wrapper {
            background-color: #f8fafc !important;
            padding: 2rem 1.5rem;
        }

        /* Typography */
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.25rem;
            color: #0f172a;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* Modern Filter Bar */
        .filter-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 12px 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 2rem;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            margin: 0;
        }

        .month-input {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
        }

        .month-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-apply {
            background-color: #3b82f6;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 6px 16px;
            border: none;
            font-size: 0.875rem;
            transition: 0.2s;
        }

        .btn-apply:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        /* Modern Stat Cards */
        .stat-card {
            position: relative;
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .stat-card .inner h3 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.05em;
            z-index: 2;
            position: relative;
        }

        .stat-card .inner p {
            font-size: 0.95rem;
            font-weight: 500;
            opacity: 0.9;
            z-index: 2;
            position: relative;
            margin: 5px 0 0;
        }

        .stat-card .icon-bg {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 5rem;
            opacity: 0.15;
            transform: rotate(-15deg);
            z-index: 1;
        }

        .stat-footer {
            margin-top: 1.5rem;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.8;
        }

        /* Gradient Palettes */
        .grad-medical {
            background: linear-gradient(135deg, #c54e41 0%, #e57373 100%);
            color: white;
        }

        .grad-pharmacy {
            background: linear-gradient(135deg, #4292c6 0%, #64b5f6 100%);
            color: white;
        }

        .grad-clients {
            background: linear-gradient(135deg, #c2a016 0%, #fbc02d 100%);
            color: white;
        }

        /* Overview Box */
        .overview-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 2rem;
        }

        .overview-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #eff6ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Chart Section */
        .main-chart-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .chart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-header h5 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            font-size: 1.1rem;
        }

        #rangeSelector {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 5px 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
=======
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .content-wrapper {
            background-color: #f5f6fa !important;
        }

        .small-box {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            color: #fff;
            transition: transform 0.2s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
        }

        .bg-medical {
            background-color: #c54e41ff !important;
        }

        .bg-pharmacy {
            background-color: #4292c6ff !important;
        }

        .bg-upcoming {
            background-color: #c2a016ff !important;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .chart-header-primary {
            background-color: #1D4FA1;
            color: #fff;
        }

        .chart-header-success {
            background-color: #27ae60;
            color: #fff;
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        }
    </style>

    <div class="content-wrapper">
<<<<<<< HEAD
        <div class="container-fluid">

            <h1 class="dashboard-title">Staff Dashboard</h1>
            <p class="dashboard-subtitle">Quick summary of system activity and processing</p>

            {{-- Integrated Filter --}}
            <form method="GET" class="filter-container">
                <label class="filter-label">Filter by Month</label>
                <input type="month" name="month" value="{{ request('month') }}" class="month-input">
                <button type="submit" class="btn-apply shadow-sm">Apply Filter</button>
                <a href="{{ url()->current() }}" class="btn-reset ms-2"
                    style="text-decoration:none; font-size: 0.875rem; color: #64748b;">Reset</a>
            </form>

            <div class="row">
                {{-- Medical Card --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('staff/reports') }}" class="text-decoration-none">
                        <div class="stat-card grad-medical shadow-sm">
                            <div class="inner">
                                <h3>{{ $medicalCount }}</h3>
                                <p>Medical Assistance Records</p>
                            </div>
                            <div class="icon-bg"><i class="fas fa-notes-medical"></i></div>
                            <div class="stat-footer">
                                <span>View Details</span> <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Pharmacy Card --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('staff/reports') }}" class="text-decoration-none">
                        <div class="stat-card grad-pharmacy shadow-sm">
                            <div class="inner">
                                <h3>{{ $pharmacyCount }}</h3>
                                <p>Pharmacy Assistance Records</p>
                            </div>
                            <div class="icon-bg"><i class="fas fa-prescription-bottle-alt"></i></div>
                            <div class="stat-footer">
                                <span>View Details</span> <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Clients Card --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('staff/client_verification/list') }}" class="text-decoration-none">
                        <div class="stat-card grad-clients shadow-sm">
                            <div class="inner">
                                <h3>{{ $clientCount }}</h3>
                                <p>Registered Beneficiaries</p>
                            </div>
                            <div class="icon-bg"><i class="fas fa-users"></i></div>
                            <div class="stat-footer">
                                <span>Manage Directory</span> <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Summary Overview Box --}}
            <div class="overview-card shadow-sm">
                <div class="overview-icon shadow-sm">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="overview-text">
                    <p class="mb-0 text-muted" style="font-size: 0.9rem; font-weight: 500;">Operational Summary</p>
                    <h5 class="mb-0" style="font-weight: 700; color: #1e293b;">
                        Processed <span class="text-primary">{{ $medicalCount + $pharmacyCount }}</span> total cases
                        with <span class="text-primary">₱{{ number_format($totalAmount, 2) }}</span> disbursed to date.
                    </h5>
                </div>
            </div>

            {{-- Analytics Chart Section --}}
            <div class="main-chart-card">
                <div class="chart-header">
                    <h5><i class="fas fa-chart-line text-primary me-2"></i> Activity Trends</h5>
                    <select id="rangeSelector" class="form-select-sm">
                        <option value="12">Last 12 Months</option>
                        <option value="all">Historical Data</option>
                    </select>
                </div>

                <div class="card-body" style="height: 400px; padding: 20px;">
                    <canvas id="staffActivityChart"></canvas>
                </div>

                <div class="p-3 bg-light border-top text-center">
                    <p class="chart-summary-text text-muted mb-0 font-italic" style="font-size: 0.85rem;">
                        Tracking service velocity and financial patterns.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('staffActivityChart').getContext('2d');
            const summaryText = document.querySelector('.chart-summary-text');
            let activityChart = null;

            function loadChartData(range = '12') {
                // Ensure this matches the route in your web.php exactly
                fetch("{{ url('staff/dashboard/cash-pattern') }}/" + range)
                    .then(res => {
                        if (!res.ok) {
                            // This will tell us exactly what the error is in the console
                            console.error('Server Response Error:', res.status);
                            throw new Error("Server error: " + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {
                        // Destroy existing chart if it exists to prevent overlapping
                        if (activityChart) {
                            activityChart.destroy();
                        }

                        activityChart = new Chart(ctx, { // Assigning to the variable here
                            type: 'bar', // Base type
                            data: {
                                labels: data.labels,
                                datasets: [{
                                        label: 'Medical Cases',
                                        data: data.medical,
                                        backgroundColor: '#c54e41',
                                        borderRadius: 6,
                                        yAxisID: 'y1'
                                    },
                                    {
                                        label: 'Pharmacy Cases',
                                        data: data.pharmacy,
                                        backgroundColor: '#4292c6',
                                        borderRadius: 6,
                                        yAxisID: 'y1'
                                    },
                                    {
                                        label: 'Disbursement (₱)',
                                        data: data.totalAmount, // Match the controller key
                                        type: 'line',
                                        borderColor: '#10b981',
                                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                        borderWidth: 3,
                                        tension: 0.4,
                                        fill: true,
                                        pointRadius: 4,
                                        yAxisID: 'y2'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y1: {
                                        beginAtZero: true,
                                        position: 'left',
                                        title: {
                                            display: true,
                                            text: 'Case Count'
                                        }
                                    },
                                    y2: {
                                        beginAtZero: true,
                                        position: 'right',
                                        grid: {
                                            drawOnChartArea: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Amount (₱)'
                                        }
                                    }
                                }
                            }
                        });

                        summaryText.innerText = range === '12' ?
                            "Analyzing workload and distribution over the last 12-month cycle." :
                            "Visualizing comprehensive historical operational data.";
                    })
                    .catch(err => {
                        console.error(err);
                        summaryText.innerText = "Failed to load analytics data.";
                    });
            }

            loadChartData('12');

            document.getElementById('rangeSelector').addEventListener('change', function() {
                loadChartData(this.value);
            });
        });
    </script>
=======
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0 text-dark">Staff Dashboard</h1>
                <p class="text-muted">Quick summary of system activity</p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <!-- Summary Boxes -->
                <div class="row">
                    <!-- Medical -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('staff/reports') }}" class="text-decoration-none">
                            <div class="small-box bg-medical">
                                <div class="inner p-4">
                                    <h3>{{ $medicalCount }}</h3>
                                    <p>Medical Assistance Records</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-notes-medical"></i>
                                </div>
                                <span class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></span>
                            </div>
                        </a>
                    </div>

                    <!-- Pharmacy -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('staff/reports') }}" class="text-decoration-none">
                            <div class="small-box bg-pharmacy">
                                <div class="inner p-4">
                                    <h3>{{ $pharmacyCount }}</h3>
                                    <p>Pharmacy Assistance Records</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-prescription-bottle-alt"></i>
                                </div>
                                <span class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></span>
                            </div>
                        </a>
                    </div>

                    <!-- Total Beneficiaries -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('staff/client_verification/list') }}" class="text-decoration-none">
                            <div class="small-box bg-upcoming">
                                <div class="inner p-4">
                                    <h3>{{ $clientCount }}</h3>
                                    <p>Total Registered Beneficiaries</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></span>
                            </div>
                    </div>
                </div>

                <!-- Quick Summary Card -->
                <div class="card mt-3 p-3">
                    <h5 class="mb-2 text-primary"><i class="fas fa-chart-line"></i> System Summary</h5>
                    <p class="mb-1">
                        A total of <strong>{{ $clientCount }}</strong> beneficiaries were recorded.
                        The system has processed <strong>{{ $medicalCount }}</strong> medical and
                        <strong>{{ $pharmacyCount }}</strong> pharmacy assistance cases,
                        totaling <strong>₱{{ number_format($totalAmount, 2) }}</strong> disbursed.
                    </p>
                </div>

            </div>
        </section>
    </div>
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
@endsection
