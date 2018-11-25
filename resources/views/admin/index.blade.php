@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row flex-row">
        <div class="col-xl-4">
            <div class="widget-32 widget-image bg-image">
                <div class="overlay"></div>
                <div class="content">
                    <div id="events-day">Sun</div>
                    <div id="events-date">25</div>
                    <div id="events-year">November 2018</div>
                </div>
                <div class="real-time">
                    <div id="events-time">6:11 PM </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <!-- Line Chart 01 -->
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center">
                    <h4><b>Transactions</b> Chart</h4>
                </div>
                <div class="widget-body">
                    <div class="chart">
                        <canvas id="line-chart-01"></canvas>
                    </div>
                </div>
            </div>
            <!-- End Line Chart 01 -->
        </div>
        <div class="col-xl-4">
            <!-- Area Chart 01 -->
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center">
                    <h4><b>Activities</b> Chart</h4>
                </div>
                <div class="widget-body">
                    <div class="chart">
                        <canvas id="area-chart-01"></canvas>
                    </div>
                </div>
            </div>
            <!-- End Area Chart 01 -->
        </div>
    </div>
    <div class="row flex-row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="widget widget-12 has-shadow">
                <div class="widget-body">
                    <div class="media">
                        <div class="align-self-center ml-3 mr-3">
                            <i class="ion-person text-dark"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="number">{{ $data['users'] }} Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="widget widget-12 has-shadow">
                <div class="widget-body">
                    <div class="media">
                        <div class="align-self-center ml-3 mr-3">
                            <i class="ion-clipboard text-dark"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="number">{{ $data['transactions'] }} Transactions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="widget widget-12 has-shadow">
                <div class="widget-body">
                    <div class="media">
                        <div class="align-self-center ml-3 mr-3">
                            <i class="ion-person-stalker text-dark"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="number">{{ $data['groups'] }} Groups</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="widget widget-12 has-shadow">
                <div class="widget-body">
                    <div class="media">
                        <div class="align-self-center ml-3 mr-3">
                            <i class="ion-podium text-dark"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="number">{{ $data['activities'] }} Activities</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/js/chart/chart.min.js') }}"></script>
<script type="text/javascript">
    var a = document.getElementById("line-chart-01").getContext("2d");
    var b = new Chart(a, {
        type: "line",
        data: {
            labels: ["Sep", "Oct", "Nov", "Dec", "Jan"],
            datasets: [{
                label: "Sales",
                borderColor: "#08a6c3",
                pointBackgroundColor: "#08a6c3",
                pointHoverBorderColor: "#08a6c3",
                pointHoverBackgroundColor: "#08a6c3",
                pointBorderColor: "#fff",
                pointBorderWidth: 3,
                pointRadius: 6,
                fill: true,
                backgroundColor: "transparent",
                borderWidth: 3,
                data: [10, 60, 20, 40, 45]
            }]
        },
        options: {
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgba(47, 49, 66, 0.8)",
                titleFontSize: 13,
                titleFontColor: "#fff",
                caretSize: 0,
                cornerRadius: 4,
                xPadding: 10,
                displayColors: false,
                yPadding: 10
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: true,
                        beginAtZero: true
                    },
                    gridLines: {
                        drawBorder: true,
                        display: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: true,
                        display: true
                    },
                    ticks: {
                        display: true
                    }
                }]
            }
        }
    });
    var a = document.getElementById("area-chart-01").getContext("2d");
    var b = new Chart(a, {
        type: "line",
        data: {
            labels: ["Sep", "Oct", "Nov", "Dec", "Jan"],
            datasets: [{
                label: "Sales",
                borderColor: "#08a6c3",
                pointBackgroundColor: "#08a6c3",
                pointHoverBorderColor: "#08a6c3",
                pointHoverBackgroundColor: "#08a6c3",
                pointBorderColor: "#fff",
                pointBorderWidth: 3,
                pointRadius: 6,
                fill: true,
                backgroundColor: "#08a6c3",
                borderWidth: 3,
                data: [10, 60, 20, 40, 45]
            }]
        },
        options: {
            legend: {
                display: true,
                position: "top",
                labels: {
                    fontColor: "#2e3451",
                    usePointStyle: true,
                    fontSize: 13
                }
            },
            tooltips: {
                backgroundColor: "rgba(47, 49, 66, 0.8)",
                titleFontSize: 13,
                titleFontColor: "#fff",
                caretSize: 0,
                cornerRadius: 4,
                xPadding: 10,
                displayColors: false,
                yPadding: 10
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: true,
                        beginAtZero: true
                    },
                    gridLines: {
                        drawBorder: true,
                        display: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: true,
                        display: true
                    },
                    ticks: {
                        display: true
                    }
                }]
            }
        }
    });
</script>
@endsection
