@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.admins')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}">
                                    <i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.admins.index') }}">
                                    @lang('dashboard.admins')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.show')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.show')</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label" for="name"> @lang('dashboard.name')</label>
                                    <input disabled="disabled" type="text" name="name" value="{{ $admin->name }}"
                                        class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="email"> @lang('dashboard.email')</label>
                                    <input disabled="disabled" type="text" name="email" value="{{ $admin->email }}"
                                        class="form-control" id="email">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="card-title sales-30-dayes-card-header">
                                                        @lang('dashboard.sales_30_dayes')</h3>
                                                </div>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn d-none btn-sales-30-dayes btn-tool">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="position-relative mb-4">
                                                    <canvas id="sales-30-dayes" height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="card-title sales-2-years-card-header">
                                                        @lang('dashboard.sales_2_years')</h3>
                                                </div>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn d-none btn-sales-2-years btn-tool">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="position-relative mb-4">
                                                    <canvas id="sales-2-years" height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <!-- ChartJS -->
    <script src="{{ asset('dashboard/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        var text_sales_30_dayes_card_header = "@lang('dashboard.sales_30_dayes')";
        var text_sales_2_years_card_header = "@lang('dashboard.sales_2_years')";

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }
        var sales2YearsThisYear = {!! $sales2YearsThisYear !!};
        var sales2YearsLastYear = {!! $sales2YearsLastYear !!};
        var sales2YearsLabels = {!! $sales2YearsLabelsMonths !!};

        var Sales2Years = new Chart($('#sales-2-years'), {
            type: 'bar',
            data: {
                labels: sales2YearsLabels,
                datasets: [{
                        backgroundColor: '#007bff',
                        label: "@lang('dashboard.this_year')",
                        borderColor: '#007bff',
                        data: sales2YearsThisYear
                    },
                    {
                        backgroundColor: '#ced4da',
                        label: "@lang('dashboard.last_year')",
                        borderColor: '#ced4da',
                        data: sales2YearsLastYear
                    }
                ]
            },
            options: {
                onClick: function(s, ss) {
                    chartSales2YearsRequestAjex((ss[0]._index + 1));
                },
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: $.extend({
                            beginAtZero: true,
                            // Include a dollar sign in the ticks
                            callback: function(value) {
                                if (value >= 1000) {
                                    value /= 1000
                                    value += 'k'
                                }
                                return 'LE ' + value
                            }
                        }, ticksStyle)
                    }],
                }
            }
        })
        var sales30DayesDataInMonth = {!! $sales30DayesDataInMonth !!};
        var sales30DayesLabels = {!! $sales30DayesLabelsInMonth !!};
        var ChartSales30Dayes = new Chart($('#sales-30-dayes'), {
            type: 'line',
            data: {
                labels: sales30DayesLabels,
                datasets: [{
                    data: sales30DayesDataInMonth,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    pointBorderColor: '#007bff',
                    pointBackgroundColor: '#007bff',
                    pointHoverBackgroundColor: '#007bff',
                    pointHoverBorderColor: '#007bff'
                }]
            },
            options: {
                onClick: function(s, ss) {
                    chartSales30DayesRequestAjex(sales30DayesLabels[ss[0]._index])
                },
                maintainAspectRatio: false,
                tooltips: {
                    mode: 'index',
                    intersect: true
                },
                hover: {
                    mode: 'index',
                    intersect: true
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        ticks: $.extend({
                            beginAtZero: true,
                            // Include a dollar sign in the ticks
                            callback: function(value) {
                                if (value >= 1000) {
                                    value /= 1000
                                    value += 'k'
                                }

                                return 'LE ' + value
                            }
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        ticks: ticksStyle
                    }]
                }
            }
        });
        $('body').on('click', '.btn-sales-30-dayes', function(e) {
            $(this).addClass('d-none');
            $('.sales-30-dayes-card-header').text(text_sales_30_dayes_card_header);

            updateChartSales30Dayes(chartSales30Dayes,
                sales30DayesDataInMonth,
                sales30DayesLabels,
                function(s, ss) {
                    chartSales30DayesRequestAjex(sales30DayesLabels[ss[0]._index]);
                },
            )
        });
        $('body').on('click', '.btn-sales-2-years', function(e) {
            $(this).addClass('d-none');
            $('.sales-2-years-card-header').text(text_sales_2_years_card_header);
            updateChartSales2Years(
                sales2Years,
                sales2YearsThisYear,
                sales2YearsLastYear,
                sales2YearsLabels,
                function(s, ss) {
                    chartSales2YearsRequestAjex((ss[0]._index + 1));
                },
            )
        });

        function chartSales2YearsRequestAjex(month) {
            $.get("{{ route('dashboard.admins.month', $admin->id) }}?month=" + month, function(data) {
                $('.sales-2-years-card-header').text(data['text']);
                $('.btn-sales-2-years').removeClass('d-none');
                updateChartSales2Years(
                    sales2Years,
                    data['sales2YearsYearInMonth'],
                    data['sales2YearsLastYearInMonth'],
                    data['sales2YearsLabels'],
                    null)
            });
        }

        function chartSales30DayesRequestAjex(day) {
            $.get("{{ route('dashboard.admins.day', $admin->id) }}?day=" + day, function(data) {
                $('.sales-30-dayes-card-header').text(data['text']);
                $('.btn-sales-30-dayes').removeClass('d-none');

                updateChartSales30Dayes(
                    chartSales30Dayes,
                    data['sales30DayesDataDay'],
                    data['sales30DayesLabelsDay'],
                    null,
                )
            });
        }

        function updateChartSales2Years(chart, data0, data1, labels, onClick) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data0;
            chart.data.datasets[1].data = data1;
            chart.options.onClick = onClick;
            chart.update();
        }

        function updateChartSales30Dayes(chart, data, labels, onClick) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.options.onClick = onClick;
            chart.update();
        }
    </script>
@endpush
