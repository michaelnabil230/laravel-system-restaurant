<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('site.created_at')</th>
        <th>@lang('site.price')</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ number_format($order->total_price, 2) }}</td>
        </tr>
    @endforeach
    <tr class="label-primary">
        <td>@lang('site.orders_total')</td>
        <td>&nbsp;</td>
        <td>{{ number_format($orders_total, 2) }}</td>
    </tr>
    </tbody>
</table><!-- end of table -->
