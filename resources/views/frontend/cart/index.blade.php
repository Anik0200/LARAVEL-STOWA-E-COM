@extends('layouts.frontend')

@section('title', 'Product Cart')

@section('content')

    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </div>

    <!-- cart_section - start ============= -->

    <section class="cart_section section_space">
        <div class="container">
            <div class="cart_update_wrap">
                <p class="mb-0"><i class="fal fa-check-square"></i> Shipping costs updated.</p>
            </div>

            <div class="cart_table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Size-Color</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($carts as $cart)
                            <tr class="cart_parent">
                                <td>
                                    <div class="cart_product">
                                        <img src="{{ asset('storage/product/' . $cart->inventory->product->image) }}"
                                            alt="image_not_found">
                                        <h3><a
                                                href="{{ route('frontend.single.shop', $cart->inventory->product->slug) }}">{{ $cart->inventory->product->title }}</a>
                                        </h3>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ $cart->inventory->size->name }}
                                    -
                                    {{ $cart->inventory->color->name }}
                                </td>
                                <td class="text-center">
                                    <span>$</span>
                                    <span class="price_text price">
                                        @if ($cart->inventory->product->sale_price)
                                            {{ $salle_price = $cart->inventory->product->sale_price + $cart->inventory->additional_price }}
                                        @else
                                            {{ $price = $cart->inventory->product->price + $cart->inventory->additional_price }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="#">
                                        <div class="quantity_input">
                                            <input type="hidden" class="cart_id" value="{{ $cart->id }}">
                                            <input type="hidden" class="stock_limit" value="{{ $cart->inventory->stock }}">
                                            <button type="button" class="input_number_decrement">
                                                <i class="fal fa-minus"></i>
                                            </button>
                                            <input name="quantity[]" class="input_number" type="text"
                                                value="{{ $cart->quantity }}" />
                                            <button type="button" class="input_number_increment">
                                                <i class="fal fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>

                                <td class="text-center">{{ $cart->inventory->stock }}</td>

                                <td class="text-center">
                                    <span>$</span>
                                    <span class="price_text total_price">
                                        @if ($cart->inventory->product->sale_price)
                                            {{ ($cart->inventory->product->sale_price + $cart->inventory->additional_price) * $cart->quantity }}
                                        @else
                                            {{ ($cart->inventory->product->price + $cart->inventory->additional_price) * $cart->quantity }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('frontend.cart.destroy', $cart) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove_btn">
                                            <i class="fal fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="cart_btns_wrap">
                <div class="row">
                    <div class="col col-lg-6">
                        <form action="{{ route('frontend.cart.couponn.apply') }}" method="POST">
                            @csrf
                            <div class="coupon_form form_item mb-0">

                                <input type="text" name="coupon" placeholder="Coupon Code..."
                                    value="@if (Session::has('cuppon')) {{ Session::get('cuppon')['name'] }} @endif">

                                <button type="submit" class="btn btn_dark">Apply Coupon</button>

                            </div>
                        </form>

                        @if (Session::has('form_error'))
                            <p class="error">{{ Session::get('form_error') }}</p>
                        @endif

                    </div>

                    <div class="col col-lg-3">
                        <ul class="btns_group ul_li_right">
                            <li><a href="{{ route('frontend.shop') }}" class="btn btn_dark">Continue Shopping</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col col-lg-3">
                        <ul class="btns_group ul_li_right">
                            <li><a class="btn btn_dark Checkout">Checkout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-lg-6">
                    <div class="calculate_shipping">
                        <h3 class="wrap_title">Shipping <span class="icon"><i class="far fa-arrow-up"></i></span></h3>
                        <form action="#">
                            <div class="select_option clearfix">
                                <select class="select select_shippimg shippingCondition">
                                    <option data-display="Select Your Currency" disabled selected>Select Location</option>

                                    @foreach ($shippingConditions as $shippingCondition)
                                        <option value="{{ $shippingCondition->id }}">{{ $shippingCondition->location }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col col-lg-6">
                    <div class="cart_total_table">
                        <h3 class="wrap_title">Cart Totals</h3>
                        <ul class="ul_li_block">
                            <li>
                                <span>Cart Subtotal</span>
                                <span>$ <strong id="subtotal">{{ $carts->sum('cart_total') }}</strong></span>
                            </li>

                            <li class="shipping_add" style="display: none">
                                <span class="shipping_location"></span>
                                <span class="shipping_cost"></span>
                            </li>


                            @if (Session::has('cuppon'))
                                <li>
                                    <span>Coupon ({{ Session::get('cuppon')['name'] }})</span>
                                    <span>- {{ Session::get('cuppon')['amount'] }}</span>
                                </li>
                            @endif

                            <li>
                                <span>Order Total</span>
                                <span class="total_price">

                                    $<strong id="grand_total">
                                        @if (Session::has('cuppon'))
                                            {{ $carts->sum('cart_total') - Session::get('cuppon')['amount'] }}
                                        @else
                                            {{ $carts->sum('cart_total') }}
                                        @endif
                                    </strong>

                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart_section - end ============= -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            var input_number_decrement = $('.input_number_decrement');

            var input_number_increment = $('.input_number_increment');

            var subtotal = $('#subtotal');
            var grand_total = $('#grand_total');

            var shipping_cost = $('.shipping_cost');
            var shipping_id = $('.select_shippimg');

            $('.Checkout').html('Select Shipping Then CheckOut!');

            $('.shippingCondition').on('change', function() {

                $(".Checkout").attr("href", "{{ route('frontend.checkOut.view') }}").html('Cheackout');

            });

            input_number_increment.on('click', function() {

                var price = $(this).parents('.cart_parent').find('.price');

                var total_price = $(this).parents('.cart_parent').find('.total_price');


                var number = $(this).parent('.quantity_input').children('.input_number');

                var stock_limit = $(this).parent('.quantity_input').children('.stock_limit').val();

                var cart_id = $(this).parent('.quantity_input').children('.cart_id').val();

                var inc = number.val();

                if (parseInt(stock_limit) > inc) {
                    inc++;
                }

                number.val(inc);

                console.log(parseInt(price.html()) * inc);

                total_price.html(parseFloat(price.html() * inc).toFixed(2));

                $.ajax({
                    type: "POST",

                    url: "{{ route('frontend.cart.update') }}",

                    data: {
                        shipping_id: shipping_id.val(),
                        quantity: inc,
                        cart_id: cart_id,
                        total_price: total_price.html(),
                        user_id: '{{ auth()->user()->id }}',
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'JSON',

                    success: function(data) {

                        subtotal.html(data.cart_total);
                        grand_total.html(data.grand_total);

                    },
                });

            });


            input_number_decrement.on('click', function() {

                var price = $(this).parents('.cart_parent').find('.price');

                var total_price = $(this).parents('.cart_parent').find('.total_price');

                var number = $(this).parent('.quantity_input').children('.input_number');

                var cart_id = $(this).parent('.quantity_input').children('.cart_id').val();

                var dnc = number.val();

                if (dnc > 1) {
                    dnc--;
                }

                number.val(dnc);

                total_price.html(parseFloat(price.html() * dnc).toFixed(2));

                $.ajax({
                    type: "POST",

                    url: "{{ route('frontend.cart.update') }}",

                    data: {
                        shipping_id: shipping_id.val(),
                        quantity: dnc,
                        cart_id: cart_id,
                        total_price: total_price.html(),
                        user_id: '{{ auth()->user()->id }}',
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'JSON',

                    success: function(data) {

                        subtotal.html(data.cart_total);
                        grand_total.html(data.grand_total);

                    },
                });

            });

            $('.select_shippimg').on('change', function() {

                $('.shipping_add').removeAttr('style');

                $.ajax({
                    type: "POST",

                    url: "{{ route('frontend.cart.select.shipping') }}",

                    data: {
                        shipping_id: shipping_id.val(),
                        user_id: '{{ auth()->user()->id }}',
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'JSON',

                    success: function(data) {

                        if (parseInt(data.shipping_amount) > 0) {

                            shipping_cost.html("+" + parseInt(data.shipping_amount));

                            $('.shipping_location').html(data.location);

                            grand_total.html(parseInt(data.grand_total));

                        } else {

                            shipping_cost.html("Free");
                        }

                    },
                });

            });

        });
    </script>
@endsection

@section('css')
    <style>
        .error {
            background: none;
            border: none;
            padding: 0 !important;
            margin-top: 5px;
            font-weight: bold;
            color: red;
        }
    </style>
@endsection
