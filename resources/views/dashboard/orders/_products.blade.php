<div id="print-area" style="direction: rtl;">
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
    <div class="text-center">
        <img style="width: 130px;border-radius: .25rem;" src="{{ setting('logo_path') }}">
    </div>
    <br>
    <div class="text-center">
        <h4>فاتورة / Invoice</h4>
    </div>
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
    <h5>@lang('site.user_name') : <span>{{ $order->user_id ? $order->user->name : '' }}</span></h5>
    <h5>@lang('site.driver_name') : <span>{{ $order->driver_id ? $order->driver->name : '' }}</span></h5>

    <h5>@lang('site.note') : <span>{{ $order->note }}</span></h5>
    <h5>@lang('site.type_payment') : <span> @lang('site.'.$order->payment)</span></h5>
    <h5>@lang('site.type_status') : <span>@lang('site.'.$order->type_status)</span></h5>
    <h5>@lang('site.order_status.name') : <span>{{ $order->status }}</span></h5>
    <h5>@lang('site.paid') : <span>{{ number_format($order->paid, 2) }} L.E</span></h5>
    <h5>@lang('site.sale') : <span>{{ number_format($order->sale, 2) }} %</span></h5>
    <h5>@lang('site.value_added') : <span>{{ number_format(setting('value_added'), 2) }} %</span></h5>
    <h5>@lang('site.total_price') : <span>{{ number_format($order->total_price, 2) }} L.E</span></h5>
    <h5>@lang('site.finel_total_price') : <span>{{ number_format($order->finel_total_price, 2) }} L.E</span></h5>

</div>

<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> @lang('site.print')</button>
