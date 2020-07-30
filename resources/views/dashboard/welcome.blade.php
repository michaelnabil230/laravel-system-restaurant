@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.dashboard')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="active"><i class="fa fa-home"></i> @lang('site.dashboard')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $categories_count }}</h3>
                                <p>@lang('site.categories')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-th"></i>
                            </div>
                            <a href="{{ route('dashboard.categories.index') }}"
                               class="small-box-footer">@lang('site.read')
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $products_count }}</h3>
                                <p>@lang('site.products')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-th"></i>
                            </div>
                            <a href="{{ route('dashboard.products.index') }}"
                               class="small-box-footer">@lang('site.read')
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $orders_count }}</h3>
                                <p>@lang('site.orders')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>
                            <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">@lang('site.read')
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $users_count }}</h3>
                                <p>@lang('site.users')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.read')
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title sales-30-dayes-card-header">@lang('site.sales_30_dayes')</h3>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
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
                        </div><!-- /.card -->
                    </div><!-- /.col-md-6 -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title sales-2-years-card-header">@lang('site.sales_2_years')</h3>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
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
                        </div><!-- /.card -->
                    </div><!-- /.col-md-6 -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('site.last_orders',['count' => $orders->count()])</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('site.id')</th>
                                            <th>@lang('site.total_price')</th>
                                            <th>@lang('site.order_status.name')</th>
                                            <th>@lang('site.created_at')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ number_format($order->total_price, 2) }}</td>
                                                <td>
                                                    <label
                                                        class="badge badge-{{ $order->status != __('site.order_status.delivered') ? 'warning' : 'success disabled' }}">{{ $order->status }}</label>
                                                </td>
                                                <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table><!-- end of table -->
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('site.best_selling_products')</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div><!-- ./chart-responsive -->
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
@push('scripts')
    <!-- ChartJS -->
    <script src="{{ asset('dashboard/plugins/chart.js/Chart.min.js') }}"></script>
    <script>

        var text_sales_30_dayes_card_header = "@lang('site.sales_30_dayes')";
        var text_sales_2_years_card_header = "@lang('site.sales_2_years')";

        new Chart($('#pieChart'), {
            type: 'doughnut',
            data: {
                labels: {!! $labels !!},
                datasets: [
                    {
                        data: {!! $data_count !!},
                        backgroundColor: {!! $colors !!}
                    },
                ]
            },
        })
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }
        var Sales2YearsThisYear = {!! $Sales2YearsThisYear !!};
        var Sales2YearsLastYear = {!! $Sales2YearsLastYear !!};
        var Sales2YearsLabels = {!! $Sales2YearsLabelsMonths !!};

        var Sales2Years = new Chart($('#sales-2-years'), {
            type: 'bar',
            data: {
                labels: Sales2YearsLabels,
                datasets: [
                    {
                        backgroundColor: '#007bff',
                        label: "@lang('site.this_year')",
                        borderColor: '#007bff',
                        data: Sales2YearsThisYear
                    },
                    {
                        backgroundColor: '#ced4da',
                        label: "@lang('site.last_year')",
                        borderColor: '#ced4da',
                        data: Sales2YearsLastYear
                    }
                ]
            },
            options: {
                onClick: function (s, ss) {
                    ChartSales2YearsRequestAjex((ss[0]._index + 1));
                },
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: $.extend({
                            beginAtZero: true,
                            // Include a dollar sign in the ticks
                            callback: function (value) {
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
        var Sales30DayesDataInMonth = {!! $sales30DayesDataInMonth !!};
        var Sales30DayesLabels = {!! $sales30DayesLabelsInMonth !!};
        var ChartSales30Dayes = new Chart($('#sales-30-dayes'), {
            type: 'line',
            data: {
                labels: Sales30DayesLabels,
                datasets: [
                    {
                        data: Sales30DayesDataInMonth,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        pointBorderColor: '#007bff',
                        pointBackgroundColor: '#007bff',
                        pointHoverBackgroundColor: '#007bff',
                        pointHoverBorderColor: '#007bff'
                    },
                ]
            },
            options: {
                onClick: function (s, ss) {
                    ChartSales30DayesRequestAjex(Sales30DayesLabels[ss[0]._index])
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
                            callback: function (value) {
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
        $('body').on('click', '.btn-sales-30-dayes', function (e) {
            $(this).addClass('d-none');
            $('.sales-30-dayes-card-header').text(text_sales_30_dayes_card_header);

            UpdateChartSales30Dayes(ChartSales30Dayes,Sales30DayesDataInMonth,Sales30DayesLabels,function (s, ss) {
                ChartSales30DayesRequestAjex(Sales30DayesLabels[ss[0]._index]);
            })
        });
        $('body').on('click', '.btn-sales-2-years', function (e) {
            $(this).addClass('d-none');
            $('.sales-2-years-card-header').text(text_sales_2_years_card_header);
            UpdateChartSales2Years(Sales2Years,Sales2YearsThisYear,Sales2YearsLastYear,Sales2YearsLabels,function (s, ss) {
                ChartSales2YearsRequestAjex((ss[0]._index + 1));
            })
        });
        function ChartSales2YearsRequestAjex(month){
            $.get("{{ route('dashboard.month') }}?month=" + month, function (data) {
                $('.sales-2-years-card-header').text(data['text']);
                $('.btn-sales-2-years').removeClass('d-none');
                UpdateChartSales2Years(Sales2Years,data['Sales2YearsYearInMonth'],data['Sales2YearsLastYearInMonth'],data['Sales2YearsLabels'],null)
            });
        }
        function ChartSales30DayesRequestAjex(day){
            $.get("{{ route('dashboard.day') }}?day=" + day, function (data) {
                $('.sales-30-dayes-card-header').text(data['text']);
                $('.btn-sales-30-dayes').removeClass('d-none');

                UpdateChartSales30Dayes(ChartSales30Dayes,data['Sales30DayesDataDay'],data['Sales30DayesLabelsDay'],null)
            });
        }
        function UpdateChartSales2Years(chart,data0,data1,labels,onClick){
            chart.data.labels = labels;
            chart.data.datasets[0].data = data0;
            chart.data.datasets[1].data = data1;
            chart.options.onClick = onClick,
            chart.update();
        }
        function UpdateChartSales30Dayes(chart,data,labels,onClick){
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.options.onClick = onClick,
            chart.update();
        }
    </script>
@endpush
