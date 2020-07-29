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
                            @foreach ($categories as $index => $category)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                       id="{{ str_replace(' ', '-', $category->name) }}-tab"
                                       aria-controls="{{ str_replace(' ', '-', $category->name) }}"
                                       href="#{{ str_replace(' ', '-', $category->name) }}"
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
                            @foreach ($categories as $index => $category)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                     id="{{ str_replace(' ', '-', $category->name) }}" role="tabpanel"
                                     aria-labelledby="{{ str_replace(' ', '-', $category->name) }}-tab">
                                    <div class="row">
                                        @foreach ($category->products as $product)
                                            <div class="col-6 col-sm-3 col-md-3 col-lg-3">
                                                <img style="margin-bottom: 15px;" class="img-thumbnail"
                                                     src="{{ $product->image_path }}">
                                                <div class="text-center">
                                                    <h6>{{ $product->name }}<br>{{ number_format($product->price, 2) }}
                                                        S.R</h6>
                                                    <div class="quantity">
                                                        <div class="pro-qty">
                                                            <span class="dec qtybtn">-</span>
                                                            <span data-id="{{ $product->id }}"
                                                                  data-name="{{ $product->name }}"
                                                                  data-price="{{ number_format($product->price, 2) }}"
                                                                  class="number">
                                                                {{ $order ? array_key_exists($product->id,$quantity_products) ? $quantity_products[$product->id] : '0' : '0' }}
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
                    </div><!-- /.card -->
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="orders-tab"
                                   aria-controls="orders"
                                   href="#orders"
                                   aria-selected="true" role="tab"
                                   data-toggle="pill">
                                    @lang('site.orders')
                                </a>
                            </li>
                            @if (!$order)
                                <li class="nav-item">
                                    <a class="nav-link"
                                       id="offline-orders-tab"
                                       aria-controls="offline-orders"
                                       href="#offline-orders"
                                       aria-selected="false" role="tab"
                                       data-toggle="pill">
                                        @lang('site.offline_orders')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active"
                                 id="orders" role="tabpanel"
                                 aria-labelledby="orders-tab">
                                <form action="{{ $url }}" method="post">

                                    {{ csrf_field() }}
                                    {{ method_field($method) }}

                                    @include('partials._errors')

                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>@lang('site.product')</th>
                                            <th>@lang('site.quantity')</th>
                                            <th>@lang('site.price')</th>
                                            <th>@lang('site.action')</th>
                                        </tr>
                                        </thead>

                                        <tbody class="order-list">
                                        @if ($order)
                                            @foreach ($order->products as $product)
                                                @php($data_product = json_encode(['id' => $product->id,'name' => $product->name,'quantity' => $product->pivot->quantity]))
                                                <tr data-product="{{ $data_product }}"
                                                    class="tr-product-{{ $product->id }}">
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->pivot->quantity }}</td>
                                                    <td class="product-price">{{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm remove-product-btn"
                                                                data-id="{{ $product->id }}"><span
                                                                class="fa fa-trash"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="no_data_found">
                                                <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table><!-- end of table -->

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="total"> @lang('site.total') : <span
                                                        class="total-price">{{ $order ? number_format($order->total_price, 2) : 0}}</span></label>
                                                <input type="hidden" name="total_price"
                                                       value="{{ $order ? $order->total_price : 0 }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label" for="sale"> @lang('site.sale') : <span
                                                        class="sale-price">0.00</span></label>
                                                <input type="number" step="0.01" name="sale"
                                                       class="form-control input-sm sale" min="0"
                                                       value="0">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label" for="paid"> @lang('site.paid')
                                                    -> @lang('site.rest') : <span class="rest-price">0.00</span></label>
                                                <input type="number" step="0.01" name="paid"
                                                       class="form-control input-sm paid" min="0"
                                                       value="0">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label"
                                                       for="type_status"> @lang('site.type_status')</label>
                                                <select name="type_status" id="type_status"
                                                        class="form-control {{ $errors->has('type_status') ? ' is-invalid' : '' }}">
                                                    <option value="external" selected> @lang('site.external')</option>
                                                    <option value="internal"> @lang('site.internal')</option>
                                                </select>
                                                @if ($errors->has('type_status'))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first('type_status') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label"
                                                       for="payment"> @lang('site.type_payment')</label>
                                                <select name="payment" id="payment"
                                                        class="form-control {{ $errors->has('payment') ? ' is-invalid' : '' }}">
                                                    <option value="cash" selected> @lang('site.cash')</option>
                                                    <option value="network"> @lang('site.network')</option>
                                                </select>
                                                @if ($errors->has('payment'))
                                                    <div class="invalid-feedback">{{ $errors->first('payment') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label"
                                                       for="drivers"> @lang('site.drivers')</label>
                                                <select name="driver_id" id="drivers"
                                                        class="form-control {{ $errors->has('drivers') ? ' is-invalid' : '' }}">
                                                    @forelse ($drivers as $index => $driver)
                                                        <option
                                                            {{ $index == 0 ? 'selected' : '' }} value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                    @empty
                                                        <option value="" disabled="disabled"
                                                                selected>@lang('site.no_data_found')</option>
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('drivers'))
                                                    <div class="invalid-feedback">{{ $errors->first('drivers') }}</div>
                                                @endif
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
                                <div class="tab-pane fade"
                                     id="offline-orders" role="tabpanel"
                                     aria-labelledby="offline-orders-tab">
                                    <form action="{{ route('dashboard.orders.offline') }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('post') }}
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('site.total_price')</th>
                                                <th>@lang('site.action')</th>
                                            </tr>
                                            </thead>

                                            <tbody class="offline-orders-list"></tbody>
                                        </table><!-- end of table -->

                                        <button type="submit"
                                                class="btn btn-primary btn-block disabled"
                                                id="form-offline-btn-orders"
                                                onclick="localStorage.removeItem('orders');">
                                            <i class="{{ $form_btn_order_icon }}"></i> {{ $form_btn_order_name }}
                                        </button>

                                    </form>
                                </div>
                            @endif

                        </div>
                    </div><!-- /.card -->
                </div>
            </div><!-- end of row -->
        </div><!-- /.row-->
    </div><!-- /.container-fluid -->
</section>

@push('scripts')
    <script>
        $('.pro-qty').on('click', '.qtybtn', function () {
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


        $('body').on('click', '.remove-product-btn', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            //to calculate total price
            calculateTotal();
            OrderListTr();
        });//end of remove product btn

        $('input[type="radio"]').on('keyup change', function () {
            if ($(this).val() == "internal") {
                $('select[name="delverry_name"]').attr("disabled", "disabled");
                $('input[name="name_client"]').attr("disabled", "disabled");
                $('input[name="address_client"]').attr("disabled", "disabled");
                $('input[name="phone_client"]').attr("disabled", "disabled");
            } else {
                $('select[name="delverry_name"]').removeAttr("disabled", "disabled");
                $('input[name="name_client"]').removeAttr("disabled", "disabled");
                $('input[name="address_client"]').removeAttr("disabled", "disabled");
                $('input[name="phone_client"]').removeAttr("disabled", "disabled");
            }
        });

        function OrderListTr() {
            var trs = $('.order-list tr').length;
            if (trs == 0) {
                var html =
                    `<tr class="no_data_found">
                    <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
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
                    <td class="product-price">${quantity * price}</td>
                    <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>`;
            $('.order-list').append(html);
            calculateTotal();
            OrderListTr();
        }

        //change paid
        $('body').on('keyup change', '.paid', function () {
            calculateTotal();
        });//end of paid

        //change paid
        $('body').on('keyup change', '.sale', function () {
            calculateTotal();
        });//end of paid


        function calculateTotal() {

            var price = 0;

            $('.order-list .product-price').each(function (index) {
                price += parseFloat($(this).html().replace(/,/g, ''));
            });//end of product price

            $('.total-price').html($.number(price, 2));
            $('input[name="total_price"]').val($.number(price, 2));

            //check if price > 0
            if (price > 0) {
                $('#form-btn-order').removeClass('disabled').addClass('btn-block btn-primary');
            } else {
                $('#form-btn-order').removeClass('btn-primary').addClass('btn-primary disabled');
            }

            var paid = Number($('.paid').val());
            var sale = Number($('.sale').val());
            var total_price = sale > 0 ? price - (price * sale / 100) : price;
            $('.rest-price').html($.number(paid - total_price, 2));
            $('.sale-price').html($.number(total_price, 2));

        }//end of calculate total


    </script>
    @if (!$order)
        <script>

            var orders = JSON.parse(localStorage.getItem('orders')) || [];

            Offline_orders();

            function Offline_orders() {
                $('.offline-orders-list tr').remove();
                var OfflineOrders = '';
                var FinelOrder = {};
                $.each(orders, function (k, order) {
                    var products = '';
                    var data_product = {};
                    $.each(order['products'], function (ks, product) {
                        products += `
                        <tr>
                            <td>${ks + 1}</td>
                            <td>${product['name']}</td>
                            <td>${product['quantity']}</td>
                            <td>${product['price']}</td>
                        </tr>`;
                        var id = product['id'];
                        data_product[id] = {
                            "quantity": product['quantity']
                        }
                    });
                    FinelOrder['products'] = data_product;
                    FinelOrder['total_price'] = order['total_price'];

                    OfflineOrders += `
                <tr>
                    <td>${k + 1}</td>
                    <td>${order['total_price']}</td>
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
                                                <th>@lang('site.name')</th>
                                                <th>@lang('site.quantity')</th>
                                                <th>@lang('site.price')</th>
                                            </tr>
                                        </thead>
                                        <tbody>${products}</tbody>
                                    </table><!-- end of table -->
                    </div>
                    </th>
                    </tr>
                    </td>
                    </tr>`
                    });
                if (OfflineOrders == '') {
                    OfflineOrders =
                        `<tr class="no_data_found">
                        <td colspan="15" class="text-center">@lang('site.no_data_found')</td>
                    </tr>`;
                    $('#form-offline-btn-orders').removeClass('btn-primary').addClass('btn-primary disabled');
                } else {
                    $('#form-offline-btn-orders').removeClass('disabled').addClass('btn-block btn-primary');
                }
                $('.offline-orders-list').append(OfflineOrders);

            }

            $('body').on('click', '#form-btn-order', function (e) {
                var online = navigator.onLine;
                var order = {};
                var products = [];

                if (!online) {
                    e.preventDefault();
                    $('.order-list tr').each(function (index) {
                        products.push($(this).data('product'));
                    });
                    order['products'] = products;
                    order['total_price'] = $('input[name="total_price"]').val();

                    orders.push(order);
                    localStorage.removeItem('orders');

                    localStorage.setItem('orders', JSON.stringify(orders));
                    $('.order-list tr').remove();
                    $('span.number').text('0');
                    OrderListTr();
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: "@lang('site.added_successfully')",
                        timeout: 2000,
                        killer: true
                    }).show();
                    Offline_orders();
                }
            });//end of form btn order
        </script>
    @endif
@endpush
