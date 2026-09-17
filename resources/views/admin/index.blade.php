@extends('layouts.app')
@section('content')

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
        <div class="row w-100 justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card shadow-lg rounded-lg text-center" style="background-color: #f7f7f7; border: none;">
                    <div class="card-body" style="padding: 30px;">
                        <h5 class="mb-3" style="font-weight: 600; color: #333;">Total Users</h5>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #4caf50;">{{ $userCount }} users</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-lg rounded-lg text-center" style="background-color: #f7f7f7; border: none;">
                    <div class="card-body" style="padding: 30px;">
                        <h5 class="mb-3" style="font-weight: 600; color: #333;">Total Sightings</h5>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #2196f3;">{{ $totalSightings }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-lg rounded-lg text-center" style="background-color: #f7f7f7; border: none;">
                    <div class="card-body" style="padding: 30px;">
                        <h5 class="mb-3" style="font-weight: 600; color: #333;">Total Cots</h5>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #ff9800;">{{ $totalCots }} cots</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-lg rounded-lg text-center" style="background-color: #f7f7f7; border: none;">
                    <div class="card-body" style="padding: 30px;">
                        <h5 class="mb-3" style="font-weight: 600; color: #333;">This Month</h5>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #9c27b0;">{{ $thisMonth }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row w-100 justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg rounded-lg" style="border: none;">
                    <div class="card-body">
                        <h5 class="text-center" style="font-weight: 600; color: #333;">COTS by Municipality</h5>
                        <div id="pieChart" style="height: 350px;"></div>
                        <p id="noData" class="text-center text-muted mt-3" style="display: none;">No sightings for the selected period.</p>
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

</script>

@endsection
