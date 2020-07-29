@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('site.orders')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}"><i
                                        class="fa fa-home"></i> @lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('site.orders')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.orders')
                                    <small> {{ $orders->total() }}</small></h3>
                                {{-- <div class="card-tools"> --}}
                                <form action="{{ route('dashboard.orders.index') }}" method="get">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control float-right"
                                               value="{{ request()->search }}" placeholder="@lang('site.search')">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i
                                                    class="fa fa-search"></i> @lang('site.search')</button>
                                            @can ('create_orders')
                                                <a href="{{ route('dashboard.orders.create') }}"
                                                   class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </form><!-- end of form -->
                                {{-- </div> --}}
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
                                            <th>@lang('site.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ number_format($order->total_price, 2) }}</td>
                                                <td>
                                                    <button
                                                        data-url="{{ route('dashboard.orders.update_status', $order->id) }}"
                                                        data-method="put"
                                                        class="btn {{ $order->status != __('site.order_status.delivered') ? 'btn-warning order-status-btn' : 'btn-success disabled' }} btn-sm">
                                                        {{ $order->status }}
                                                    </button>
                                                </td>
                                                <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                                <td class="py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-primary btn-sm order-products"
                                                                data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                                                data-method="get"><i class="fa fa-eye"></i>
                                                            @lang('site.show')
                                                        </button>
                                                        @can ('update_orders')
                                                            <a href="{{ route('dashboard.orders.edit', $order->id) }}"
                                                               class="btn btn-info"><i
                                                                    class="fa fa-edit"></i> @lang('site.edit')</a>
                                                        @endcan
                                                        @can ('delete_orders')
                                                            <a href="#" class="btn delete btn-danger"><i
                                                                    class="fa fa-trash"></i> @lang('site.delete')</a>
                                                            <form
                                                                action="{{ route('dashboard.orders.destroy', $order->id) }}"
                                                                method="post" style="display: inline-block">
                                                                {{ csrf_field() }}{{ method_field('delete') }}
                                                            </form><!-- end of form -->
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table><!-- end of table -->
                                    {{ $orders->appends(request()->query())->links() }}
                                </div>
                            </div>

                            <!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-bottom: 15px">@lang('site.show_products')</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                    <div class="loader"></div>
                                    <p style="margin-top: 10px">@lang('site.loading')</p>
                                </div>

                                <div id="order-product-list"></div><!-- end of order product list -->

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div><!-- end of col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div><!-- end of content wrapper -->
@endsection
@push('scripts')
    <script>
        //list all order products
        $('.order-products').on('click', function (e) {

            e.preventDefault();

            $('#loading').css('display', 'flex');

            var url = $(this).data('url');
            var method = $(this).data('method');
            $.ajax({
                url: url,
                method: method,
                success: function (data) {

                    $('#loading').css('display', 'none');
                    $('#order-product-list').empty();
                    $('#order-product-list').append(data);

                }
            })

        });//end of order products click

        //list all order products
        $('.order-status-btn').on('click', function (e) {
            e.preventDefault();
            var this_ = $(this);
            var url = $(this).data('url');
            var method = $(this).data('method');
            $.ajax({
                url: url,
                method: method,
                success: function (data) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: data.success,
                        timeout: 2000,
                        killer: true
                    }).show();
                    if (data.text == "@lang('site.order_status.delivered')") {
                        this_.removeClass('btn-warning order-status-btn').addClass('btn-success disabled');
                    }
                    this_.text(data.text);
                }
            });
        });//end of order status click

        //print order
        $(document).on('click', '.print-btn', function () {

            $('#print-area').printThis();

        });//end of click function

    </script>

@endpush
