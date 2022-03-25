<!-- Main content -->
<style>
    .pro-qty {
        width: 72%;
        height: 30px;
        display: inline-block;
        position: relative;
        text-align: center;
        background: #f5f5f5;
        margin-bottom: 5px;
    }

    .pro-qty .qtybtn {
        font-size: 16px;
        color: #6f6f6f;
        cursor: pointer;
        display: inline-block;
        color: white;
        width: 20px;
        height: 30px;
        text-align: center;
    }

    .dec {
        background-color: #dc3545;
        float: left;
    }

    .inc {
        background-color: #28a745;
        float: right;
    }

    .card-header .nav-item .active {
        color: #495057 !important;
    }

</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                        id="category-{{ $category->id }}-tab" aria-controls="{{ $category->id }}"
                                        href="#category-{{ $category->id }}"
                                        aria-selected="{{ $index == 0 ? 'true' : 'false' }}" role="tab"
                                        data-toggle="pill">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            @foreach ($categories as $category)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                    id="category-{{ $category->id }}" role="tabpanel"
                                    aria-labelledby="category-{{ $category->id }}-tab">
                                    <div class="row">
                                        @foreach ($category->products as $product)
                                            <div class="col-6 col-sm-3 col-md-3 col-lg-3">
                                                <img style="margin-bottom: 15px;" class="img-thumbnail"
                                                    src="{{ $product->image_path }}">
                                                <div class="text-center">
                                                    <h6>{{ $product->name }}<br>{{ number_format($product->price, 2) }}
                                                        L.E</h6>
                                                    <div class="quantity">
                                                        <div class="pro-qty">
                                                            <span class="dec qtybtn">-</span>
                                                            <span data-id="{{ $product->id }}"
                                                                data-name="{{ $product->name }}"
                                                                data-price="{{ $product->price }}"
                                                                class="number">
                                                                {{ $order ? (array_key_exists($product->id, $quantity_products) ? $quantity_products[$product->id] : '0') : '0' }}
                                                            </span>
                                                            <span class="inc qtybtn">+</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="orders-tab" aria-controls="orders" href="#orders"
                                    aria-selected="true" role="tab" data-toggle="pill">
                                    @lang('dashboard.orders')
                                </a>
                            </li>
                            @if (!$order)
                                <li class="nav-item">
                                    <a class="nav-link" id="offline-orders-tab" aria-controls="offline-orders"
                                        href="#offline-orders" aria-selected="false" role="tab" data-toggle="pill">
                                        @lang('dashboard.offline_orders')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="orders" role="tabpanel"
                                aria-labelledby="orders-tab">
                                <form action="{{ $url }}" method="post">

                                    {{ csrf_field() }}
                                    {{ method_field($method) }}

                                    @include('partials._errors')

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>@lang('dashboard.product')</th>
                                                <th>@lang('dashboard.quantity')</th>
                                                <th>@lang('dashboard.price')</th>
                                                <th>@lang('dashboard.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody class="order-list">
                                            @if ($order)
                                                @foreach ($order->products as $product)
                                                    <tr class="tr-product-{{ $product->id }}">
                                                        <td>{{ $product->name }}</td>
                                                        <td><input type="hidden"
                                                                name="products[{{ $product->id }}][quantity]"
                                                                value="{{ $product->pivot->quantity }}">{{ $product->pivot->quantity }}
                                                        </td>
                                                        <td class="product-price">
                                                            {{ number_format($product->price * $product->pivot->quantity, 2) }}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm remove-product-btn"
                                                                data-id="{{ $product->id }}">
                                                                <span class="fa fa-trash">
                                                                </span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="no_data_found">
                                                    <td colspan="15" class="text-center">
                                                        @lang('dashboard.no_data_found')
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="value_added">
                                                        @lang('dashboard.value_added')
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input disabled="disabled"
                                                            value="{{ number_format(setting('value_added', 15), 2) }}"
                                                            class="form-control input-sm" id="value_added">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-percent"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="total"> @lang('dashboard.total') :
                                                    <span class="total-price">
                                                        {{ $order ? number_format($order->total_price, 2) : 0.0 }}
                                                        L.E
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="sale">
                                                        @lang('dashboard.sale') :
                                                        <span class="sale-price">
                                                            0.00 L.E
                                                        </span>
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" step="0.01" name="sale"
                                                            value="{{ $order ? $order->sale : 0.0 }}"
                                                            class="form-control input-sm sale" id="value_added" min="0">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-percent"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="finel_total_price">
                                                    @lang('dashboard.finel_total_price') :
                                                    <span class="finel_total_price">
                                                        {{ $order ? number_format($order->finel_total_price, 2) : 0.0 }}
                                                        L.E
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="paid"> @lang('dashboard.paid')
                                                    -> @lang('dashboard.rest') :
                                                    <span class="rest-price">
                                                        0.00 L.E
                                                    </span>
                                                </label>
                                                <input type="number" step="0.01" name="paid"
                                                    class="form-control input-sm paid" min="0"
                                                    value="{{ $order ? $order->paid : 0.0 }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label" for="type_status">
                                                    @lang('dashboard.type_status')
                                                </label>
                                                <select name="type_status" id="type_status"
                                                    class="form-control type_status {{ $errors->has('type_status') ? ' is-invalid' : '' }}">
                                                    <option value="external"
                                                        {{ $order ? ($order->type_status == 'external' ? 'selected' : '') : 'selected' }}>
                                                        @lang('dashboard.external')
                                                    </option>
                                                    <option value="internal"
                                                        {{ $order ? ($order->type_status == 'internal' ? 'selected' : '') : '' }}>
                                                        @lang('dashboard.internal')
                                                    </option>
                                                </select>
                                                @if ($errors->has('type_status'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('type_status') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="payment">
                                                    @lang('dashboard.type_payment')</label>
                                                <select name="payment" id="payment"
                                                    class="form-control payment {{ $errors->has('payment') ? ' is-invalid' : '' }}">
                                                    <option value="cash"
                                                        {{ $order ? ($order->payment == 'cash' ? 'selected' : '') : 'selected' }}>
                                                        @lang('dashboard.cash')
                                                    </option>
                                                    <option value="network"
                                                        {{ $order ? ($order->payment == 'network' ? 'selected' : '') : '' }}>
                                                        @lang('dashboard.network')
                                                    </option>
                                                </select>
                                                @if ($errors->has('payment'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('payment') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="drivers">
                                                    @lang('dashboard.drivers')</label>
                                                <select name="driver_id" id="drivers"
                                                    class="form-control driver_id {{ $errors->has('drivers') ? ' is-invalid' : '' }}">
                                                    @php($select = '')
                                                    @forelse ($drivers as  $driver)
                                                        @if ($order)
                                                            @if ($order->driver_id == $driver->id)
                                                                @php($select = 'selected')
                                                            @endif
                                                        @else
                                                            @php($select = 'selected')
                                                        @endif
                                                        <option {{ $select }} value="{{ $driver->id }}">
                                                            {{ $driver->name }}
                                                        </option>
                                                    @empty
                                                        <option value="" disabled="disabled" selected>
                                                            @lang('dashboard.no_data_found')</option>
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('drivers'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('drivers') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="note">
                                                    @lang('dashboard.note')</label>
                                                <textarea name="note" id="note" class="note form-control">{{ $order ? $order->note : old('note') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary btn-block {{ $method == 'Post' ? 'disabled' : '' }}"
                                        id="form-btn-order">
                                        <i class="{{ $form_btn_order_icon }}"></i> {{ $form_btn_order_name }}
                                    </button>

                                </form>
                            </div>
                            @if (!$order)
                                <div class="tab-pane fade" id="offline-orders" role="tabpanel"
                                    aria-labelledby="offline-orders-tab">
                                    <form action="{{ route('dashboard.orders.offline') }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('post') }}
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('dashboard.total_price')</th>
                                                    <th>@lang('dashboard.action')</th>
                                                </tr>
                                            </thead>

                                            <tbody class="offline-orders-list"></tbody>
                                        </table>

                                        <button type="submit" class="btn btn-primary btn-block disabled"
                                            id="form-offline-btn-orders" onclick="localStorage.removeItem('orders');">
                                            <i class="{{ $form_btn_order_icon }}"></i> {{ $form_btn_order_name }}
                                        </button>

                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    @if ($order)
        <script>
            $(document).ready(function() {
                calculateTotal();
            });
        </script>
    @endif
    <script>
        $('.pro-qty').on('click', '.qtybtn', function() {
            var $button = $(this);
            var oldValue = parseInt($button.parent().find('span.number').text());
            if ($button.hasClass('inc')) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 0;
                }
            }

            var name = $(this).parent().find('span.number').data('name');
            var price = $(this).parent().find('span.number').data('price');
            var id = $(this).parent().find('span.number').data('id');
            var quantity = newVal;
            if (newVal == 0) {
                removeProduct(id);
            } else {
                removeProduct(id);
                addProduct(name, price, id, quantity);
            }
            $button.parent().find('span.number').text(newVal);
        });


        $('body').on('click', '.remove-product-btn', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            //to calculate total price
            calculateTotal();
            OrderListTr();
        });

        $('input[type="radio"]').on('keyup change', function() {
            if ($(this).val() == "internal") {
                $('select[name="delverry_name"]').attr("disabled", "disabled");
            } else {
                $('select[name="delverry_name"]').removeAttr("disabled", "disabled");
            }
        });

        function OrderListTr() {
            var trs = $('.order-list tr').length;
            if (trs == 0) {
                var html =
                    `<tr class="no_data_found">
                    <td colspan="15" class="text-center">@lang('dashboard.no_data_found')</td>
                </tr>`;
                $('.order-list').append(html);
            } else {
                $('.order-list .no_data_found').remove();
            }
        }

        function removeProduct(id) {
            $(`.tr-product-${id}`).remove();
            //to calculate total price
            calculateTotal();
            OrderListTr();
        }

        function addProduct(name, price, id, quantity) {
            var product = {
                id: id,
                name: name,
                quantity: quantity,
                price: (quantity * price),
            };
            var html =
                `<tr class="tr-product-${id}" data-product='${JSON.stringify(product)}'>
                    <td>${name}</td>
                    <td><input type="hidden" name="products[${id}][quantity]" value="${quantity}">${quantity}</td>
                    <td class="product-price">${$.number((quantity * price), 2)}</td>
                    <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>`;
            $('.order-list').append(html);
            calculateTotal();
            OrderListTr();
        }

        $('body').on('keyup change', '.paid', function() {
            calculateTotal();
        });

        $('body').on('keyup change', '.sale', function() {
            calculateTotal();
        });


        function calculateTotal() {
            var price = 0;

            $('.order-list .product-price').each(function(index) {
                price += parseFloat($(this).html().replace(/,/g, ''));
            });

            $('.total-price').html($.number(price, 2));

            if (price > 0) {
                $('#form-btn-order').removeClass('disabled').addClass('btn-block btn-primary');
            } else {
                $('#form-btn-order').removeClass('btn-primary').addClass('btn-primary disabled');
            }

            var paid = Number($('.paid').val());
            var sale = Number($('.sale').val());
            var value_added = Number($('#value_added').val());

            var total_price = sale > 0 ? price - (price * sale / 100) : price;
            var finel_total_price = (total_price * value_added / 100) + total_price;

            $('.rest-price').html($.number(paid - finel_total_price, 2) + ' L.E');
            $('.sale-price').html($.number(finel_total_price, 2) + ' L.E');
            $('.finel_total_price').html($.number(finel_total_price, 2) + ' L.E');
        }
    </script>
    @if (!$order)
        <script>
            var orders = JSON.parse(localStorage.getItem('orders')) || [];

            offline_orders();

            function offline_orders() {
                $('.offline-orders-list tr').remove();
                var OfflineOrders = '';
                var FinelOrder = {};
                $.each(orders, function(k, order) {
                    var products = '';
                    var data_product = {};
                    var total_price = 0;
                    $.each(order['products'], function(ks, product) {
                        products += `
                        <tr>
                            <td>${ks + 1}</td>
                            <td>${product['name']}</td>
                            <td>${product['quantity']}</td>
                            <td>${$.number(product['price'], 2)}</td>
                        </tr>`;
                        var id = product['id'];
                        data_product[id] = {
                            "quantity": product['quantity']
                        }
                        total_price += product['price'];
                    });
                    delete order['products'];
                    FinelOrder = order;
                    FinelOrder['products'] = data_product;

                    console.log('FinelOrder', FinelOrder);
                    OfflineOrders += `
                <tr>
                    <td>${k + 1}</td>
                    <td>${$.number(total_price, 2)}</td>
                    <input type="hidden" name="orders[]" value='${JSON.stringify(FinelOrder)}'>
                    <td>
                        <button data-toggle="collapse" data-target="#order-${k + 1}" onclick="event.preventDefault();" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button>
                        <tr id="order-${k + 1}" class="collapse">
                            <th colspan="9">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('dashboard.name')</th>
                                                <th>@lang('dashboard.quantity')</th>
                                                <th>@lang('dashboard.price')</th>
                                            </tr>
                                        </thead>
                                        <tbody>${products}</tbody>
                                    </table>
                    </div>
                    </th>
                    </tr>
                    </td>
                    </tr>`;
                });
                if (OfflineOrders == '') {
                    OfflineOrders =
                        `<tr class="no_data_found">
                        <td colspan="15" class="text-center">@lang('dashboard.no_data_found')</td>
                    </tr>`;
                    $('#form-offline-btn-orders').removeClass('btn-primary').addClass('btn-primary disabled');
                } else {
                    $('#form-offline-btn-orders').removeClass('disabled').addClass('btn-block btn-primary');
                }
                $('.offline-orders-list').append(OfflineOrders);

            }

            $('body').on('click', '#form-btn-order', function(e) {
                var online = navigator.onLine;
                var order = {};
                var products = [];

                if (!online) {
                    e.preventDefault();
                    $('.order-list tr').each(function(index) {
                        products.push($(this).data('product'));
                    });
                    order['products'] = products;
                    order['paid'] = Number($('.paid').val());
                    order['sale'] = Number($('.sale').val());
                    order['note'] = $('.note').val();
                    order['type_status'] = $('.type_status').val();
                    order['payment'] = $('.payment').val();
                    order['driver_id'] = $('.driver_id').val();


                    orders.push(order);
                    localStorage.removeItem('orders');

                    localStorage.setItem('orders', JSON.stringify(orders));
                    $('.order-list tr').remove();
                    calculateTotal();
                    $('span.number').text('0');
                    OrderListTr();
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: "@lang('dashboard.added_successfully')",
                        timeout: 2000,
                        killer: true
                    }).show();
                    offline_orders();
                }
            });
        </script>
    @endif
@endpush
