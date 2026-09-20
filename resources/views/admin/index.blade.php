@extends('layouts.app')
@section('content')

<style>
    .small-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin: 0 auto 10px;
    }
</style>

<div class="content-wrapper">
    <div class="container d-flex justify-content-center align-items-center flex-column mt-5">

        <!-- Date range filter -->
        <div class="row w-100 justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card shadow-lg rounded-lg" style="border: none;">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="from" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{ $from }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="to" class="form-label">To</label>
                                <input type="date" id="to" name="to" value="{{ $to }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="row w-100 justify-content-center g-3">

            <!-- Big: Total Users -->
            <div class="col-md-6 mb-4">
                <div class="card big-card h-100" style="border: none; border-radius: 18px; background: linear-gradient(135deg, #0ea5e9, #0056b3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="padding: 28px 30px;">
                        <div class="text-white">
                            <h5 class="mb-2" style="font-weight: 600;">Total Users</h5>
                            <p class="mb-0" style="font-size: 2.6rem; font-weight: 800; line-height: 1;">{{ $userCount }}</p>
                            <small class="text-white-50">Registered accounts</small>
                        </div>
                        <i class="bx bxs-user text-white-50" style="font-size: 4rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Small: Total Sightings -->
            <div class="col-md-2 mb-4">
                <div class="card small-card h-100 text-center" style="border: none; border-radius: 18px;">
                    <div class="card-body d-flex flex-column justify-content-center" style="padding: 20px;">
                        <span class="small-card-icon" style="background: #dbeafe; color: #1d4ed8;"><i class="bx bxs-map-pin"></i></span>
                        <p class="mb-0" style="font-size: 1.5rem; font-weight: 800; color: #1d4ed8;">{{ $totalSightings }}</p>
                        <h6 class="mb-0 text-muted">Sightings</h6>
                    </div>
                </div>
            </div>

            <!-- Small: Total COTS -->
            <div class="col-md-2 mb-4">
                <div class="card small-card h-100 text-center" style="border: none; border-radius: 18px;">
                    <div class="card-body d-flex flex-column justify-content-center" style="padding: 20px;">
                        <span class="small-card-icon" style="background: #fff7e6; color: #ea8a00;"><i class="bx bxs-star"></i></span>
                        <p class="mb-0" style="font-size: 1.5rem; font-weight: 800; color: #ea8a00;">{{ $totalCots }}</p>
                        <h6 class="mb-0 text-muted">COTS Count</h6>
                    </div>
                </div>
            </div>

            <!-- Small: This Month -->
            <div class="col-md-2 mb-4">
                <div class="card small-card h-100 text-center" style="border: none; border-radius: 18px;">
                    <div class="card-body d-flex flex-column justify-content-center" style="padding: 20px;">
                        <span class="small-card-icon" style="background: #f3e8ff; color: #9333ea;"><i class="bx bxs-calendar"></i></span>
                        <p class="mb-0" style="font-size: 1.5rem; font-weight: 800; color: #9333ea;">{{ $thisMonth }}</p>
                        <h6 class="mb-0 text-muted">This Month</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart cards -->
        <div class="row w-100 justify-content-center g-3">
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg rounded-lg" style="border: none;">
                    <div class="card-body">
                        <h5 class="text-center" style="font-weight: 600; color: #333;">COTS by Municipality</h5>
                        <div id="pieChart" style="height: 350px;"></div>
                        <p id="noData" class="text-center text-muted mt-3" style="display: none;">No sightings for the selected period.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg rounded-lg" style="border: none;">
                    <div class="card-body">
                        <h5 class="text-center" style="font-weight: 600; color: #333;">Sightings by Month</h5>
                        <div id="barChart" style="height: 350px;"></div>
                        <p id="noDataBar" class="text-center text-muted mt-3" style="display: none;">No sightings for the selected period.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>

var municipalities = @json($municipalities);
var totalCotsArray = @json($totalCotsArray);

var baseColors = ['#f44336', '#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#3f51b5'];

// Cycle the palette so colors stay consistent between loads
var generatedColors = municipalities.map(function (_, i) {
    return baseColors[i % baseColors.length];
});

var optionsPieChart = {
    chart: {
        type: 'donut',
        height: 350,
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    series: totalCotsArray,
    labels: municipalities,
    colors: generatedColors,
    dataLabels: {
        enabled: true,
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            colors: ['#fff']
        },
        formatter: function (val, opts) {
            var totalCots = opts.series[opts.seriesIndex];
            var sum = opts.w.globals.seriesTotals.reduce(function (a, b) { return a + b; }, 0);
            var percentage = sum > 0 ? (totalCots / sum) * 100 : 0;
            return totalCots + ' cots (' + percentage.toFixed(2) + '%)';
        }
    },
    tooltip: {
        theme: 'dark',
        y: {
            formatter: function (val) {
                return val + ' cots';
            }
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '70%',
                labels: {
                    show: false
                }
            }
        }
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '14px',
        fontWeight: 'bold',
        markers: {
            width: 15,
            height: 15,
            radius: 5
        }
    }
};

if (municipalities.length > 0) {
    var chartPie = new ApexCharts(document.querySelector("#pieChart"), optionsPieChart);
    chartPie.render();
} else {
    document.querySelector("#pieChart").style.display = 'none';
    document.querySelector("#noData").style.display = 'block';
}

var monthLabels = @json($monthLabels);
var monthCounts = @json($monthCounts);

if (monthLabels.length > 0) {
    var optionsBarChart = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        series: [{ name: 'Sightings', data: monthCounts }],
        colors: ['#0056b3'],
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '50%'
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: monthLabels,
            labels: { style: { fontSize: '12px', fontWeight: '600' } }
        },
        tooltip: {
            theme: 'dark',
            y: { formatter: function (val) { return val + ' sightings'; } }
        },
        grid: { borderColor: '#e7eaf0' }
    };
    new ApexCharts(document.querySelector("#barChart"), optionsBarChart).render();
} else {
    document.querySelector("#barChart").style.display = 'none';
    document.querySelector("#noDataBar").style.display = 'block';
}

</script>

@endsection
