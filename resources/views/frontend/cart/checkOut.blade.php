@extends('layouts.frontend')

@section('title', 'Chechout')

@section('css')

    <!-- woocommerce - css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/woocommerce-2.css') }}">

    <style>
        .error {
            background: none;
            border: none;
            padding: 0 !important;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>

@endsection

@section('content')

    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.cart.index') }}">Back To Cart</a></li>
                <li>Chechout</li>
            </ul>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="checkout-section section_space">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="woocommerce">

                        <form action="{{ url('/pay') }}" method="POST"
                            class="checkout woocommerce-checkout needs-validation">
                            @csrf

                            {{-- Form Strat --}}

                            <div class="col2-set" id="customer_details">

                                {{-- First Form --}}
                                <div class="coll-1">
                                    <div class="woocommerce-billing-fields">
                                        <h3>Billing Details</h3>

                                        <p class="form-row form-row form-row-wide">

                                            <label for="billing_first_name"
                                                class="@error('billing_name') text-danger @enderror">Name
                                            </label>

                                            <input type="text" class="input-text " name="billing_name"
                                                placeholder="Your Name"
                                                value="{{ old('billing_name', auth()->user()->name) }}">

                                        </p>

                                        <div class="clear"></div>

                                        <p class="form-row form-row form-row-first validate-required validate-email">

                                            <label for="billing_email"
                                                class="@error('billing_email') text-danger @enderror">Email Address</label>

                                            <input type="email" class="input-text " name="billing_email"
                                                placeholder="Your Email"
                                                value="{{ old('billing_email', auth()->user()->email) }}">

                                        </p>

                                        <p class="form-row form-row form-row-last validate-required validate-phone">

                                            <label for="billing_phone"
                                                class="@error('billing_phone') text-danger @enderror">Phone</label>

                                            <input type="tel" class="input-text " name="billing_phone"
                                                placeholder="Your Phone"
                                                value="{{ old('billing_phone', auth()->user()->UserInfo->phone ?? '') }}">

                                        </p>

                                        <p class="form-row form-row form-row-wide address-field validate-required">

                                            <label for="billing_address"
                                                class="@error('billing_address') text-danger @enderror">Address</label>

                                            <input type="text" class="input-text " name="billing_address"
                                                placeholder="Your Address"
                                                value="{{ old('billing_address', auth()->user()->UserInfo->address ?? '') }}">

                                        </p>

                                        <p class="form-row form-row validate-required form-row-first">

                                            <label for="billing_city">City</label>

                                            <input type="text" class="input-text " name="billing_city"
                                                placeholder="Your City"
                                                value="{{ old('billing_city', auth()->user()->UserInfo->city ?? '') }}">

                                        </p>

                                        <p class="form-row form-row validate-required form-row-first">

                                            <label for="billing_postcode" class="">Postcode / ZIP</label>

                                            <input type="text" class="input-text " name="billing_postcode"
                                                placeholder="Your Zip"
                                                value="{{ old('billing_postcode', auth()->user()->UserInfo->zip ?? '') }}">

                                        </p>

                                        <div class="clear"></div>

                                        <p class="form-row form-row notes">

                                            <label for="order_comments" class="">Order Notes</label>

                                            <textarea name="order_comments" class="input-text " placeholder="Notes about your order" rows="2" cols="5"></textarea>

                                        </p>
                                    </div>
                                </div>

                                {{-- Second Form  --}}
                                <div class="coll-2">
                                    <div class="woocommerce-shipping-fields">

                                        <h3 id="ship-to-different-address">
                                            <label class="checkbox" data-bs-toggle="collapse"
                                                data-bs-target="#shipping_dif">different
                                                address?

                                                <input id="ship-to-different-address-checkbox" class="input-checkbox"
                                                    type="checkbox" name="ship_different" value="1">
                                            </label>

                                        </h3>

                                        <div class="shipping_address collapse" id="shipping_dif">

                                            <p class="form-row form-wide validate-required" id="shipping_first_name_field">
                                                <label for="shipping_first_name" class="">Name <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_name"
                                                    id="shipping_first_name" placeholder="" autocomplete="given-name"
                                                    value="">
                                            </p>

                                            <p class="form-row form-wide validate-required"
                                                id="shipping_first_name_field">
                                                <label for="shipping_first_name" class="">Phone <abbr
                                                        class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_phone"
                                                    id="shipping_first_name" placeholder="" autocomplete="given-name"
                                                    value="">
                                            </p>

                                            <div class="clear"></div>

                                            <p class="form-row form-row form-row-wide address-field validate-required"
                                                id="shipping_address_1_field">
                                                <label for="shipping_address_1" class="">Address <abbr
                                                        class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_address"
                                                    id="shipping_address_1" placeholder="Street address"
                                                    autocomplete="address-line1" value="">
                                            </p>

                                            <p class="form-row form-row address-field form-row-first"
                                                id="billing_city_field2">
                                                <label for="billing_city" class="">City <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_city"
                                                    id="billing_city3" placeholder="" autocomplete="address-level2"
                                                    value="">
                                            </p>

                                            <p class="form-row form-row form-row-last address-field validate-required validate-postcode"
                                                id="billing_postcode_field17">
                                                <label for="billing_postcode" class="">Postcode / ZIP <abbr
                                                        class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="shipping_zip"
                                                    id="billing_postcode4" placeholder="" autocomplete="postal-code"
                                                    value="">
                                            </p>

                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Form End  --}}

                            {{-- Payment Section Start --}}

                            <h3 id="order_review_heading">Your order</h3>
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <table class="shop_table woocommerce-checkout-review-order-table">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $cart)
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    {{ $cart->inventory->product->title }}<strong
                                                        class="product-quantity">× {{ $cart->quantity }}</strong>

                                                    <span>
                                                        @if (session()->has('stock'))
                                                            <p style="font-size: 12px" class="text-danger">
                                                                {{ Session::get('stock') }}
                                                            </p>
                                                        @endif
                                                    </span>
                                                </td>

                                                <td class="product-total">
                                                    <span class="woocommerce-Price-amount amount">
                                                        {{ $cart->cart_total }}
                                                        <span class="woocommerce-Price-currencySymbol">BDT</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td>
                                                <span class="woocommerce-Price-amount amount">
                                                    {{ $cart->sum('cart_total') }}
                                                    <span class="woocommerce-Price-currencySymbol">BDT</span>
                                                </span>
                                            </td>
                                        </tr>

                                        @if (Session::has('shipping_charge'))
                                            <tr class="shipping">
                                                <th>Shipping Fee</th>
                                                <td data-title="Shipping">
                                                    +
                                                    {{ Session::get('shipping_charge') > 0 ? Session::get('shipping_charge') : 'Free Shipping' }}
                                                    <span class="woocommerce-Price-currencySymbol">BDT</span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if (Session::has('cuppon'))
                                            <tr class="coupon">
                                                <th>Coupon</th>
                                                <td data-title="coupon">
                                                    -
                                                    {{ Session::get('cuppon')['amount'] ? Session::get('cuppon')['amount'] : '' }}
                                                    <span class="woocommerce-Price-currencySymbol">BDT</span>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td>
                                                <strong>
                                                    <span class="woocommerce-Price-amount amount">

                                                        @if (Session::has('shipping_charge') && Session::has('cuppon'))
                                                            {{ $cart->sum('cart_total') + Session::get('shipping_charge') - Session::get('cuppon')['amount'] }}
                                                        @else
                                                            {{ $cart->sum('cart_total') + Session::get('shipping_charge') }}
                                                        @endif


                                                        <span class="woocommerce-Price-currencySymbol">BDT</span>
                                                    </span>
                                                </strong>
                                            </td>
                                        </tr>

                                    </tfoot>
                                </table>
                                <div id="payment" class="woocommerce-checkout-payment">
                                    <ul class="wc_payment_methods payment_methods methods">
                                        <li class="wc_payment_method payment_method_cheque">
                                            <input id="payment_method_cheque" type="radio" class="input-radio"
                                                name="payment_method" value="cheque" checked="checked"
                                                data-order_button_text="">
                                            <!--grop add span for radio button style-->
                                            <span class="grop-woo-radio-style"></span>
                                            <!--custom change-->
                                            <label for="payment_method_cheque">
                                                Check Payments </label>
                                            <div class="payment_box payment_method_cheque">
                                                <p>Please send a check to Store Name, Store Street, Store Town, Store State
                                                    / County, Store Postcode.</p>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="form-row place-order">

                                        <button type="submit" class="button alt">Place Order</button>

                                    </div>

                                </div>
                            </div>

                            {{-- Payment Section end --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

    <script>
        (function(window, document) {
            var loader = function() {
                var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(
                    7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                loader);
        })(window, document);
    </script>

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<p class="fs-5">{{ Session::get('error') }}</p>',
                showConfirmButton: false,
                timer: 1500,
            })
        </script>
    @endif

@endsection
