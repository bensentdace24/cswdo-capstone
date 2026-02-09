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
            margin-bottom: 1.5rem;
        }

        /* Modern Filter Bar Redesign */
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

        .btn-reset {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-reset:hover {
            color: #0f172a;
        }

        /* Modern Stat Cards (Glass-morphism style) */
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
        .grad-orange {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            color: white;
        }

        .grad-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            color: white;
        }

        .grad-green {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            font-family: 'Inter', sans-serif;
        }

        .content-wrapper {
            background-color: #f0f2f5 !important;
        }

        /* Lighter background for the canvas */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Softer, more prominent shadow */

        /* Dashboard Header */
        .content-header h1 {
            font-family: 'Poppins', sans-serif;
            /* Use Poppins for main heading */
            font-weight: 700;
            color: #1a1a1a;
            /* Darker text */
            font-size: 2rem;
            padding-top: 10px;
        }

        /* Summary Boxes (Small-Box) Redesign */
        .small-box {
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            /* Deeper shadow */
            color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            min-height: 150px;
            padding: 20px;
        }

        .small-box:hover {
            transform: translateY(-8px);
            /* More noticeable hover effect */
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }

        /* --- IMPROVED TEXT VISIBILITY START --- */
        .small-box .inner h3,
        .small-box .inner p {
            /* Apply a subtle dark text shadow for better contrast against light gradients */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
        }

        .small-box .inner h3 {
            font-size: 2.5rem;
            /* Larger number */
            font-weight: 700;
            margin-bottom: 5px;
        }

        .small-box .inner p {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.95;
            /* Slightly increased opacity */
        }

        /* --- IMPROVED TEXT VISIBILITY END --- */

        .small-box .icon i {
            font-size: 60px;
            /* Smaller icon */
            position: absolute;
            top: 10px;
            right: 20px;
            color: rgba(255, 255, 255, 0.3);
            /* Subtle icon */
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .small-box:hover .icon i {
            opacity: 0.7;
        }

        .small-box-footer {
            background: rgba(0, 0, 0, 0.2);
            /* Slightly darker footer background for text visibility */
            color: rgba(255, 255, 255, 0.9);
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px 15px;
            font-size: 0.85rem;
        }

        /* Gradient Colors (Mimicking the image, slightly richer gradients for better base visibility) */
        .bg-medical-grad {
            /* Orange/Pink Gradient - Slightly deeper colors */
            background-image: linear-gradient(to top right, #ff7e77 0%, #ffc0b4 100%);
        }

        .bg-pharmacy-grad {
            /* Blue/Purple Gradient - Slightly deeper colors */
            background-image: linear-gradient(120deg, #64b5f6 0%, #42a5f5 100%);
        }

        .bg-beneficiary-grad {
            /* Green/Mint Gradient - Slightly deeper colors */
            background-image: linear-gradient(120deg, #a5d6a7 0%, #81c784 100%);
        }

        /* System Summary Card */
        .card-summary {
            background-color: #ffffff;
            border-left: 5px solid #34495e;
            /* Used the primary purple accent color */
        }

        /* Chart Card */
        .chart-card {
            margin-top: 30px;
        }

        .chart-header-purple {
            background-color: #34495e !important;
            /* A deep purple for the header */
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 1rem 1.5rem;
        }

        .chart-overview-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            border: 1px solid #e9ecef;
            margin-top: 15px;
            /* Add some space */
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        }
    </style>

    <div class="content-wrapper">
<<<<<<< HEAD
        <div class="container-fluid">

            <h1 class="dashboard-title">Admin Dashboard</h1>

            <form method="GET" class="filter-container">
                <label class="filter-label">Filter by Month</label>
                <input type="month" name="month" value="{{ request('month') }}" class="month-input">
                <button type="submit" class="btn-apply shadow-sm">Apply Filter</button>
                <a href="{{ url()->current() }}" class="btn-reset">Reset</a>
            </form>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('admin/reports') }}" class="text-decoration-none">
                        <div class="stat-card grad-orange shadow-sm">
                            <div class="inner">
                                <h3>{{ $medicalCount }}</h3>
                                <p>Medical Assistance</p>
                            </div>
                            <div class="icon-bg"><i class="fas fa-notes-medical"></i></div>
                            <div class="stat-footer">
                                <span>Explore Records</span> <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('admin/reports') }}" class="text-decoration-none">
                        <div class="stat-card grad-blue shadow-sm">
                            <div class="inner">
                                <h3>{{ $pharmacyCount }}</h3>
                                <p>Pharmacy Support</p>
                            </div>
                            <div class="icon-bg"><i class="fas fa-prescription-bottle-alt"></i></div>
                            <div class="stat-footer">
                                <span>Explore Records</span> <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ url('admin/client/list') }}" class="text-decoration-none">
                        <div class="stat-card grad-green shadow-sm">
                            <div class="inner">
                                <h3>{{ $clientCount }}</h3>
                                <p>Total Clients</p>
                            </div>
                            <div class="icon-bg"><i class="fas fa-users"></i></div>
                            <div class="stat-footer">
                                <span>Manage Directory</span> <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="overview-card shadow-sm">
                <div class="overview-icon shadow-sm">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="overview-text">
                    <p class="mb-0 text-muted" style="font-size: 0.9rem; font-weight: 500;">Financial Disbursement Summary
                    </p>
                    <h5 class="mb-0" style="font-weight: 700; color: #1e293b;">
                        Total of <span class="text-primary">₱{{ number_format($totalAmount, 2) }}</span> disbursed to <span
                            class="text-primary">{{ $clientCount }}</span> verified beneficiaries.
                    </h5>
                </div>
            </div>

            <div class="main-chart-card">
                <div class="chart-header">
                    <h5><i class="fas fa-chart-line text-primary me-2"></i> Assistance Analytics</h5>
                    <select id="rangeSelector" class="form-select-sm">
                        <option value="12">Last 12 Months</option>
                        <option value="all">Historical Data</option>
                    </select>
                </div>

                <div class="card-body" style="height: 400px; padding: 20px;">
                    <canvas id="cashPatternChart"></canvas>
                </div>

                <div class="p-3 bg-light border-top text-center">
                    <p class="chart-summary-text text-muted mb-0 font-italic" style="font-size: 0.85rem;"></p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('cashPatternChart');
            const summaryText = document.querySelector('.chart-summary-text');
=======
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">👋 Admin Dashboard</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('admin/reports') }}" class="text-decoration-none">
                            <div class="small-box bg-medical-grad">
                                <div class="inner p-3">
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

                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('admin/reports') }}" class="text-decoration-none">
                            <div class="small-box bg-pharmacy-grad">
                                <div class="inner p-3">
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

                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('admin/client_verification/list') }}" class="text-decoration-none">
                            <div class="small-box bg-beneficiary-grad">
                                <div class="inner p-3">
                                    <h3>{{ $clientCount }}</h3>
                                    <p>Total Registered Beneficiaries</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="card mt-3 p-4 card-summary">

                    <h5 class="mb-2 text-dark">
                        <i class="fas fa-info-circle text-primary"
                            style="font-size: 1.1rem; color: #007bff !important;"></i>
                        <strong style="margin-left: 5px;">System Overview</strong>
                    </h5>

                    <p class="mb-0 text-secondary" style="font-size: 0.95rem;">
                        A total of
                        <strong style="color: #007bff;">{{ $clientCount }}</strong> beneficiaries were recorded.
                        The system has processed
                        <strong style="color: #007bff;">{{ $medicalCount }}</strong> medical and
                        <strong style="color: #007bff;">{{ $pharmacyCount }}</strong> pharmacy assistance cases, totaling
                        <strong style="color: #007bff;">₱{{ number_format($totalAmount, 2) }}</strong> disbursed to date.
                    </p>
                </div>

                <div class="card chart-card shadow-sm">
                    <div
                        class="card-header chart-header-purple text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 flex-grow-1"><i class="fas fa-chart-bar me-2"></i> Pattern of Cash Assistance
                        </h5>
                        <div class="ms-auto">
                            <select id="rangeSelector" class="form-select form-select-sm bg-white text-dark"
                                style="width: 200px; border-radius: 6px;">
                                <option value="12">Last 12 Months</option>
                                <option value="all">All Available Data</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body" style="height: 400px;">
                        <canvas id="cashPatternChart"></canvas>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3 px-3">
                        <div class="chart-overview-box rounded-2 p-3">
                            <p class="text-muted mb-0" style="font-size: 0.9rem;"></p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('cashPatternChart');
            const summary = document.querySelector('.chart-overview-box p');
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            let cashChart;

            function loadCashPattern(range = '12') {
                fetch(`/admin/dashboard/cash-pattern/${range}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data || data.error) return;

<<<<<<< HEAD
=======
                        const labels = data.labels || [];
                        const medical = data.medical.map(Number);
                        const pharmacy = data.pharmacy.map(Number);
                        const totalAmount = data.totalAmount.map(Number);

>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                        if (cashChart) cashChart.destroy();

                        cashChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
<<<<<<< HEAD
                                labels: data.labels,
                                datasets: [{
                                        label: 'Medical',
                                        data: data.medical,
                                        backgroundColor: '#f97316',
                                        borderRadius: 6,
                                        yAxisKey: 'y1'
                                    },
                                    {
                                        label: 'Pharmacy',
                                        data: data.pharmacy,
                                        backgroundColor: '#3b82f6',
                                        borderRadius: 6,
                                        yAxisKey: 'y1'
                                    },
                                    {
                                        label: 'Disbursement (₱)',
                                        data: data.totalAmount,
                                        type: 'line',
                                        borderColor: '#10b981',
                                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                        borderWidth: 3,
                                        tension: 0.4,
                                        fill: true,
                                        pointRadius: 4,
=======
                                labels,
                                datasets: [{
                                        label: 'Medical Cases',
                                        data: medical,
                                        // Updated color to better match the new gradient box
                                        backgroundColor: '#ff7e77',
                                        yAxisKey: 'y1'
                                    },
                                    {
                                        label: 'Pharmacy Cases',
                                        data: pharmacy,
                                        // Updated color to better match the new gradient box
                                        backgroundColor: '#64b5f6',
                                        yAxisKey: 'y1'
                                    },
                                    {
                                        label: 'Total Amount (₱)',
                                        data: totalAmount,
                                        type: 'line',
                                        // Retained a vibrant green for the line
                                        borderColor: '#2ecc71',
                                        backgroundColor: 'rgba(46,204,113,0.1)',
                                        borderWidth: 2,
                                        tension: 0.4,
                                        fill: true,
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                                        yAxisKey: 'y2'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
<<<<<<< HEAD
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        align: 'end',
                                        labels: {
                                            usePointStyle: true,
                                            font: {
                                                weight: '600'
                                            }
                                        }
=======
                                interaction: {
                                    mode: 'index',
                                    intersect: false
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        align: 'end'
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                                    }
                                },
                                scales: {
                                    y1: {
<<<<<<< HEAD
                                        beginAtZero: true,
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y2: {
                                        position: 'right',
                                        beginAtZero: true,
                                        grid: {
                                            color: '#f1f5f9'
=======
                                        type: 'linear',
                                        position: 'left',
                                        beginAtZero: true
                                    },
                                    y2: {
                                        type: 'linear',
                                        position: 'right',
                                        beginAtZero: true,
                                        grid: {
                                            drawOnChartArea: false
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                                        }
                                    }
                                }
                            }
                        });
<<<<<<< HEAD
                        summaryText.innerText = range === '12' ?
                            "Analyzing assistance trends over the last 12-month cycle." :
                            "Visualizing comprehensive historical data for all records.";
=======

                        summary.innerHTML =
                            range === '12' ?
                            `The chart above shows the trend of **Medical** and **Pharmacy** assistance over the **last 12 months**.` :
                            `The chart above displays **all available historical data** for **Medical** and **Pharmacy** assistance.`;
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    });
            }

            loadCashPattern('12');
<<<<<<< HEAD
=======

>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            document.getElementById('rangeSelector').addEventListener('change', function() {
                loadCashPattern(this.value);
            });
        });
    </script>
@endsection
