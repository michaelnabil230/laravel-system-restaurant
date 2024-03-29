<style>
    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    table {
        direction: rtl;
        border-collapse: collapse;
    }

    .table-bordered thead td,
    .table-bordered thead th {
        border-bottom-width: 2px;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table td,
    .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    th {
        text-align: inherit;
    }

</style>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>@lang('dashboard.created_at')</th>
            <th>@lang('dashboard.price')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ number_format($order->total_price, 2) }} L.E</td>
            </tr>
        @endforeach
        <tr class="label-primary">
            <td>@lang('dashboard.orders_total')</td>
            <td>&nbsp;</td>
            <td>{{ number_format($orders_total, 2) }} L.E</td>
        </tr>
    </tbody>
</table>
