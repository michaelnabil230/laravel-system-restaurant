@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('dashboard.orders')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}"><i class="fa fa-home"></i>
                                    @lang('dashboard.dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active">@lang('dashboard.orders')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('dashboard.orders')
                                    <small> {{ $orders->total() }}</small>
                                </h3>
                                <form action="{{ route('dashboard.orders.index') }}" method="get">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control float-right"
                                            value="{{ request()->search }}" placeholder="@lang('dashboard.search')">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                                @lang('dashboard.search')
                                            </button>
                                            @can('create_orders')
                                                <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary">
                                                    <i class="fa fa-plus"></i>
                                                    @lang('dashboard.add')
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('dashboard.id')</th>
                                                <th>@lang('dashboard.total_price')</th>
                                                <th>@lang('dashboard.order_status.name')</th>
                                                <th>@lang('dashboard.created_at')</th>
                                                <th>@lang('dashboard.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ number_format($order->total_price, 2) }} L.E</td>
                                                    <td>
                                                        <button
                                                            data-url="{{ route('dashboard.orders.update_status', $order->id) }}"
                                                            data-method="put"
                                                            class="btn {{ $order->status != __('dashboard.order_status.delivered')? 'btn-warning order-status-btn': 'btn-success disabled' }} btn-sm">
                                                            {{ $order->status }}
                                                        </button>
                                                    </td>
                                                    <td>{{ $order->created_at->format('Y-m-d g:i:s A') }}</td>
                                                    <td class="py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-primary btn-sm order-products"
                                                                data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                                                data-method="get"><i class="fa fa-eye"></i>
                                                                @lang('dashboard.show')
                                                            </button>
                                                            @can('update_orders')
                                                                <a href="{{ route('dashboard.orders.edit', $order->id) }}"
                                                                    class="btn btn-info"><i class="fa fa-edit"></i>
                                                                    @lang('dashboard.edit')
                                                                </a>
                                                            @endcan
                                                            @can('delete_orders')
                                                                <a href="#" class="btn delete btn-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('dashboard.delete')
                                                                </a>
                                                                <form
                                                                    action="{{ route('dashboard.orders.destroy', $order->id) }}"
                                                                    method="post" style="display: inline-block">
                                                                    {{ csrf_field() }}{{ method_field('delete') }}
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="15" class="text-center">@lang('dashboard.no_data_found')
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $orders->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('dashboard.show_products')</h3>
                            </div>
                            <div class="card-body">
                                <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                    <div class="loader"></div>
                                    <p style="margin-top: 10px">@lang('dashboard.loading')</p>
                                </div>
                                <div id="order-product-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        $('.order-products').on('click', function(e) {
            e.preventDefault();
            $('#loading').css('display', 'flex');
            var url = $(this).data('url');
            var method = $(this).data('method');
            $.ajax({
                url: url,
                method: method,
                success: function(data) {
                    $('#loading').css('display', 'none');
                    $('#order-product-list').empty();
                    $('#order-product-list').append(data);
                }
            })
        });

        $(document).on('click', '.print-btn', function() {
            $('#print-area').printThis();
        });

        $('.order-status-btn').on('click', function(e) {
            e.preventDefault();
            var this_ = $(this);
            var url = $(this).data('url');
            var method = $(this).data('method');
            $.ajax({
                url: url,
                method: method,
                success: function(data) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: data.success,
                        timeout: 2000,
                        killer: true
                    }).show();
                    if (data.index == 4) {
                        this_.removeClass('btn-warning order-status-btn')
                            .addClass('btn-success disabled');
                    }
                    this_.text(data.text);
                }
            });
        });
    </script>
@endpush
