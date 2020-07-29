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
                <div class="row svsvs" style="display:none">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">@lang('site.orders_30_dayes')</h3>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="svsvs" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">@lang('site.orders_30_dayes')</h3>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <canvas id="orders-30-dayes" height="200"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-md-6 -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">@lang('site.sales')</h3>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <canvas id="sales" height="200"></canvas>
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
        new Chart($('#pieChart'), {
            type: 'doughnut',
            data: pieData = {
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

        new Chart($('#sales'), {
            type: 'bar',
            data: {
                labels: {!! $months !!},
                datasets: [
                    {
                        backgroundColor: '#007bff',
                        label: "@lang('site.this_year')",
                        borderColor: '#007bff',
                        data: {!! $dataInThisYear !!}
                    },
                    {
                        backgroundColor: '#ced4da',
                        label: "@lang('site.last_year')",
                        borderColor: '#ced4da',
                        data: {!! $dataInLastYear !!}
                    }
                ]
            },
            options: {
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
        var ordersDataInMonth = {!! $ordersDataInMonth !!};
        var labels = {!! $ordersLabelsInMonth !!};
        new Chart($('#orders-30-dayes'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: ordersDataInMonth,
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
                    GetDataByDay(labels[ss[0]._index]);
                    console.log('ss ', labels[ss[0]._index]);
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

        function GetDataByDay(day) {
            $('.svsvs').fadeIn(3000);

            $.get("{{ route('dashboard.day') }}?day=" + day, function (data) {
                console.log('data ', data);

                new Chart($('#svsvs'), {
                    type: 'line',
                    data: {
                        labels: data['ordersLabelsDay'],
                        datasets: [
                            {
                                backgroundColor: 'transparent',
                                borderColor: '#007bff',
                                pointBorderColor: '#007bff',
                                pointBackgroundColor: '#007bff',
                                pointHoverBackgroundColor: '#007bff',
                                pointHoverBorderColor: '#007bff',
                                data: data['ordersDataDay']
                            },

                        ]
                    },
                    options: {
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
                        maintainAspectRatio: false,
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

                        }
                    }
                })

            });
        }

    </script>
@endpush
