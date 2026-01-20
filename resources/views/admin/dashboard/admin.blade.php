@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">Good {{ \Carbon\Carbon::now()->format('H') < 12 ? 'Morning' : (\Carbon\Carbon::now()->format('H') < 18 ? 'Afternoon' : 'Evening') }}, {{ Auth::user()->name ?? 'Admin' }}!</h4>
                                    <p class="text-muted mb-0">Here's what's happening with your job portal
                                        today.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <a href="{{ route('jobs.create') }}" class="btn btn-soft-success"><i
                                            class="ri-add-circle-line align-middle me-1"></i>
                                        Add Job</a>
                                </div>
                            </div><!-- end card header -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Jobs</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-briefcase-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $totalJobs }}">{{ $totalJobs }}</span>
                                            </h4>
                                            <a href="{{ route('jobs.index') }}" class="text-decoration-underline">View all jobs</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-briefcase-line text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Categories</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-info fs-14 mb-0">
                                                <i class="ri-folder-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $totalCategories }}">{{ $totalCategories }}</span></h4>
                                            <a href="{{ route('categories.index') }}" class="text-decoration-underline">View all categories</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                <i class="ri-folder-line text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Skills</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-warning fs-14 mb-0">
                                                <i class="ri-star-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $totalSkills }}">{{ $totalSkills }}</span>
                                            </h4>
                                            <a href="{{ route('skills.index') }}" class="text-decoration-underline">View all skills</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                <i class="ri-star-line text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Job Types</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-primary fs-14 mb-0">
                                                <i class="ri-file-list-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $totalJobTypes }}">{{ $totalJobTypes }}</span>
                                            </h4>
                                            <a href="{{ route('job-types.index') }}" class="text-decoration-underline">View all job types</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="ri-file-list-line text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Users</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-user-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $totalUsers }}">{{ $totalUsers }}</span>
                                            </h4>
                                            <a href="{{ route('users.index') }}" class="text-decoration-underline">View all users</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-user-line text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Website Visitors</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-info fs-14 mb-0">
                                                <i class="ri-eye-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $visitorCount }}">{{ $visitorCount }}</span>
                                            </h4>
                                            <a href="javascript:void(0);" class="text-decoration-underline">Last 24 hours</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                <i class="ri-eye-line text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p
                                                class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Visitors</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-primary fs-14 mb-0">
                                                <i class="ri-global-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                    class="counter-value" data-target="{{ $totalVisitors }}">{{ $totalVisitors }}</span>
                                            </h4>
                                            <a href="javascript:void(0);" class="text-decoration-underline">All time visitors</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="ri-global-line text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Visitor Statistics (Last 7 Days)</h4>
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-light-subtle">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value"
                                                        data-target="{{ $totalJobs }}">{{ $totalJobs }}</span></h5>
                                                <p class="text-muted mb-0">Total Jobs</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value"
                                                        data-target="{{ $totalCategories }}">{{ $totalCategories }}</span></h5>
                                                <p class="text-muted mb-0">Categories</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value"
                                                        data-target="{{ $totalSkills }}">{{ $totalSkills }}</span></h5>
                                                <p class="text-muted mb-0">Skills</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div
                                                class="p-3 border border-dashed border-start-0 border-end-0">
                                                <h5 class="mb-1 text-info"><span class="counter-value"
                                                        data-target="{{ $visitorCount }}">{{ $visitorCount }}</span></h5>
                                                <p class="text-muted mb-0">24h Visitors</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body p-0 pb-2">
                                    <div class="w-100">
                                        <div id="visitor_statistics_chart"
                                            data-colors='["--vz-primary", "--vz-success", "--vz-info"]'
                                            class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                </div> <!-- end .h-100-->

            </div> <!-- end col -->
        </div>

    </div>
    <!-- container-fluid -->
</div>

@section('stylesheet')
<style>
    #visitor_statistics_chart {
        min-height: 350px;
    }
</style>
@endsection

@endsection

@section('scripts')
<script>
    // Visitor Statistics Chart Data
    var visitorChartData = @json($weeklyVisitors);

    // Initialize Visitor Statistics Chart
    function initVisitorChart() {
        if (!visitorChartData || visitorChartData.length === 0) {
            console.warn('No visitor data available');
            return;
        }
        
        var dates = visitorChartData.map(item => item.date);
        var visitors = visitorChartData.map(item => item.visitors);

        var options = {
            series: [{
                name: 'Visitors',
                data: visitors
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: ['#405189'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 3
            },
            xaxis: {
                categories: dates,
                labels: {
                    style: {
                        colors: '#787878',
                        fontSize: '12px',
                        fontFamily: 'inherit'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#787878',
                        fontSize: '12px',
                        fontFamily: 'inherit'
                    }
                }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function(val) {
                        return val + " visitors";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#visitor_statistics_chart"), options);
        chart.render();

        return chart;
    }

    // Initialize chart when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ApexCharts !== 'undefined') {
            initVisitorChart();
        }
    });
</script>
@endsection
