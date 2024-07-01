@extends('layouts.frontend')

@section('title', $product->title)

@section('css')
    <style>
        .product_details_content .item_price span {
            margin-right: 0px !important;
        }

        .item_price p {
            margin-left: 5px;
        }

        .error {
            background: none;
            border: none;
            padding: 0 !important;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')

    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li>{{ $product->title }}</li>
            </ul>
        </div>
    </div>

    <section class="product_details section_space pb-0">
        <div class="container">
            <div class="row">
                <div class="col col-lg-6">
                    <div class="product_details_image">
                        <div class="details_image_carousel">

                            @forelse ($product->productGalleries as $Galleries)
                                <div class="slider_item">
                                    <img src="{{ asset('storage/product/' . $Galleries->image) }}" alt="image_not_found">
                                </div>
                            @empty
                                <div class="slider_item">
                                    <img src="{{ asset('storage/product/' . $product->image) }}" alt="image_not_found">
                                </div>
                            @endforelse

                        </div>

                        <div class="details_image_carousel_nav">

                            @forelse ($product->productGalleries as $Galleries)
                                <div class="slider_item">
                                    <img src="{{ asset('storage/product/' . $Galleries->image) }}" alt="image_not_found">
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product_details_content">
                        <h2 class="item_title">{{ $product->title }}</h2>
                        <p>{{ $product->short_description }}</p>

                        <div class="item_review">
                            <ul class="rating_star ul_li">
                                <li><i class="fas fa-star"></i>&gt;</li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star-half-alt"></i></li>
                            </ul>
                            <span class="review_value">3 Rating(s)</span>
                        </div>

                        <div class="item_price">

                            <p>
                                <span>$</span>
                                <span class="sale_price">{{ $product->sale_price ?? $product->price }}</span>
                            </p>

                            <p class="ml-5">
                                @if ($product->sale_price)
                                    $<del>{{ $product->price }}</del>
                                @endif
                            </p>


                        </div>

                        <hr>

                        <div class="item_attribute">
                            <h3 class="title_text">Options <span class="underline"></span></h3>
                            <form action="#">
                                <div class="row">
                                    <div class="col col-md-6">
                                        <div class="select_option clearfix">
                                            <h4 class="input_title">Size *</h4>
                                            <select class="select size_box">
                                                <option disabled selected data-display="All Size">Select Size</option>
                                                @foreach ($product->Inventories->unique('size_id') as $inv)
                                                    <option value="{{ $inv->size->id }}">{{ $inv->size->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col col-md-6">
                                        <div class="select_option clearfix">
                                            <h4 class="input_title">Color *</h4>
                                            <select disabled class="form-control color_box">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <span class="repuired_text">Stock - <span class="stock"> </span></span>
                            </form>
                        </div>

                        <form method="POST" action="{{ route('frontend.cart.store') }}">
                            @csrf

                            <input type="hidden" name="inventory" id="inventory_id">
                            <input type="hidden" name="total" id="total">

                            <div class="quantity_wrap">
                                <div class="quantity_input">
                                    <button disabled type="button" class="input_number_decrement">
                                        <i class="fal fa-minus"></i>
                                    </button>
                                    <input disabled name="quantity" class="input_number" type="text" value="0">
                                    <button disabled type="button" class="input_number_increment">
                                        <i class="fal fa-plus"></i>
                                    </button>
                                </div>

                                <div class="total_price">Total: $<span
                                        class="total_price_inven">{{ $product->sale_price ?? $product->price }}</span>
                                </div>
                            </div>

                            <ul class="default_btns_group ul_li">
                                <li><button type="submit" class="btn btn_primary addtocart_btn">Add To
                                        Cart</button>
                                </li>
                            </ul>
                        </form>

                    </div>
                </div>
            </div>

            <div class="details_information_tab">
                <ul class="tabs_nav nav ul_li" role="tablist">
                    <li>
                        <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button"
                            role="tab" aria-controls="description_tab" aria-selected="true">
                            Description
                        </button>
                    </li>
                    <li>
                        <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button"
                            role="tab" aria-controls="additional_information_tab" aria-selected="false">
                            Additional information
                        </button>
                    </li>
                    <li>
                        <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab"
                            aria-controls="reviews_tab" aria-selected="false">
                            Reviews(2)
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                        <p>
                            {{ $product->add_info }}
                        </p>
                    </div>

                    {{-- review part temprary close --}}
                </div>
            </div>

        </div>
    </section>

    @if (count($relatedPros) > 0)
        <section class="related_products_section section_space">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="best-selling-products related-product-area">
                            <div class="sec-title-link">
                                <h3>Related products</h3>
                                <div class="view-all"><a href="{{ route('frontend.shop') }}">View all<i
                                            class="fal fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="product-area clearfix">

                                @foreach ($relatedPros as $relatedPro)
                                    <div class="grid">
                                        <div class="product-pic">
                                            <img src="{{ asset('storage/product/' . $relatedPro->image) }}"
                                                alt="{{ $relatedPro->title }}">
                                            <div class="actions mt-1" style="right: 3px">
                                                <ul>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-heart" style="color: red"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-random" style="color: gray"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="quickview_btn" data-bs-toggle="modal"
                                                            href="#quickview_popup" role="button" tabindex="0">
                                                            <i class="fa fa-eye" style="color: gray"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <h4><a href="#">{{ Str::limit($relatedPro->title, 20, '...') }}</a></h4>
                                            <p><a
                                                    href="#">{{ Str::limit($relatedPro->short_description, 25, '...') }}</a>
                                            </p>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="price">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi> <span
                                                                class="woocommerce-Price-currencySymbol">$</span>{{ $relatedPro->sale_price ?? $relatedPro->price }}
                                                        </bdi>
                                                    </span>
                                                </ins>
                                                @if ($relatedPro->sale_price)
                                                    <del aria-hidden="true">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi> <span
                                                                    class="woocommerce-Price-currencySymbol">$</span>{{ $relatedPro->price }}
                                                            </bdi>
                                                        </span>
                                                    </del>
                                                @endif
                                            </span>
                                            <div class="add-cart-area">
                                                <a href="{{ route('frontend.single.shop', $product->slug) }}">
                                                    <button class="add-to-cart">Bye</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection


@section('js')
    <script>
        $(function() {

            var product_id = {{ $product->id }};

            var size_box = $('.size_box');

            var color_box = $('.color_box');

            var sale_price = $('.sale_price');

            var stock = $('.stock');


            var input_number_decrement = $('.input_number_decrement');

            var input_number_increment = $('.input_number_increment');

            var input_number = $('.input_number');

            var input_number_val = $('.input_number').val();

            var total_price_inven = $('.total_price_inven');

            if (!stock) {
                var total_price_inven = $('.total_price_inven').html(0);
            } else {
                var total_price_inven = $('.total_price_inven');
            }


            input_number_increment.on('click', function() {

                if (input_number_val < stock.html()) {
                    input_number_val++;
                }

                input_number.val(input_number_val);

                total_price_inven.html(parseFloat(sale_price.html() * input_number_val).toFixed(2));

                $('#total').val(sale_price.html() * input_number_val);
            });

            input_number_decrement.on('click', function() {

                if (input_number_val > 1) {
                    input_number_val--;
                }

                input_number.val(input_number_val);

                total_price_inven.html(parseFloat(sale_price.html() * input_number_val).toFixed(2));

                $('#total').val(sale_price.html() * input_number_val);
            });


            size_box.on('change', function() {

                color_box.removeAttr('disabled');

                $.ajax({
                    type: "POST",

                    url: "{{ route('frontend.single.shopColor') }}",

                    data: {
                        product_id: product_id,
                        size_id: size_box.val(),
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'JSON',

                    success: function(data) {
                        color_box.html(data);
                    },
                });

            });

            color_box.on('change', function() {

                input_number_decrement.removeAttr('disabled');
                input_number.removeAttr('disabled');
                input_number_increment.removeAttr('disabled');

                $.ajax({
                    type: "POST",

                    url: "{{ route('frontend.single.stock') }}",

                    data: {
                        product_id: product_id,
                        size_id: size_box.val(),
                        color_id: color_box.val(),
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'JSON',

                    success: function(data) {

                        size_box.on('change', function() {
                            total_price_inven.html(parseFloat(data.producPrice).toFixed(
                                2));

                            sale_price.html(parseFloat(data.producPrice).toFixed(
                                2));

                            $('#total').val(parseFloat(data.producPrice).toFixed(
                                2));
                        });

                        sale_price.html(parseFloat(data.price).toFixed(2));
                        stock.html(data.stock);

                        total_price_inven.html(parseFloat(data.price).toFixed(2));

                        $('#total').val(data.price);
                        $('#inventory_id').val(data.inventory_id);


                    },
                });
            });

        });
    </script>
@endsection
