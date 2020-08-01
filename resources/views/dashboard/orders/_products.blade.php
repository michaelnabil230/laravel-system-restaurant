<div id="print-area">
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

        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table td, .table th {
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
            <th>@lang('site.name')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.price')</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>@lang('site.total') <span>{{ number_format($order->total_price, 2) }}</span></h3>

</div>

<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> @lang('site.print')</button>
