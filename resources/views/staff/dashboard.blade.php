@extends('layouts.app')

@section('content')
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
        }

        /* Modern Filter Styles */
        .filter-container {
            background: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
        }

        .filter-label {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0;
        }

        .custom-month-input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .custom-month-input:focus {
            border-color: #64b5f6;
            box-shadow: 0 0 0 3px rgba(100, 181, 246, 0.2);
        }

        .btn-filter-apply {
            background: linear-gradient(135deg, #64b5f6 0%, #42a5f5 100%);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(66, 165, 245, 0.2);
        }

        .btn-filter-apply:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(66, 165, 245, 0.3);
            color: #fff;
        }

        .btn-filter-reset {
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            color: #718096;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-filter-reset:hover {
            background: #edf2f7;
            color: #2d3748;
            text-decoration: none;
        }
    </style>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0"> Staff Dashboard</h1>
            </div>
        </div>

        <form method="GET" class="filter-container">
            <label class="filter-label">
                <i class="fas fa-calendar-alt me-1" style="color: #64b5f6;"></i> Filter by Month:
            </label>

            <input type="month" name="month" value="{{ request('month') }}" class="custom-month-input">

            <button type="submit" class="btn-filter-apply">
                <i class="fas fa-filter me-1"></i> Apply
            </button>

            <a href="{{ url()->current() }}" class="btn-filter-reset">
                <i class="fas fa-undo me-1"></i> Reset
            </a>
        </form>


        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ url('staff/reports') }}" class="text-decoration-none">
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
                        <a href="{{ url('staff/reports') }}" class="text-decoration-none">
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
                        <a href="{{ url('staff/client_verification/list') }}" class="text-decoration-none">
                            <div class="small-box bg-beneficiary-grad">
                                <div class="inner p-3">
                                    <h3>{{ $clientCount }}</h3>
                                    <p>Total Assistance Records</p>
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
                        <strong style="color: #007bff;">{{ $clientCount }}</strong> assistance records were processed.
                        The system has recorded
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
            let cashChart;

            function loadCashPattern(range = '12') {
                fetch(`/staff/dashboard/cash-pattern/${range}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data || data.error) return;

                        const labels = data.labels || [];
                        const medical = data.medical.map(Number);
                        const pharmacy = data.pharmacy.map(Number);
                        const totalAmount = data.totalAmount.map(Number);

                        if (cashChart) cashChart.destroy();

                        cashChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels,
                                datasets: [{
                                        label: 'Medical Cases',
                                        data: medical,
                                        // Updated color to better match the new gradient box
                                        backgroundColor: '#ff7e77',
                                    },
                                    {
                                        label: 'Pharmacy Cases',
                                        data: pharmacy,
                                        // Updated color to better match the new gradient box
                                        backgroundColor: '#64b5f6',
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
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
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
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        min: 0,
                                        ticks: {
                                            precision: 0
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }

                            }
                        });

                        summary.innerHTML =
                            range === '12' ?
                            `The chart above shows the trend of **Medical** and **Pharmacy** assistance over the **last 12 months**.` :
                            `The chart above displays **all available historical data** for **Medical** and **Pharmacy** assistance.`;
                    });
            }

            loadCashPattern('12');

            document.getElementById('rangeSelector').addEventListener('change', function() {
                loadCashPattern(this.value);
            });
        });
    </script>
@endsection
