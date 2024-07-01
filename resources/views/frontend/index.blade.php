@extends('layouts.frontend')

@section('title', 'home')

@section('css')
    <style>
        .new_arrivals_section {
            padding-top: 50px !important;
            padding-bottom: 30px !important;
        }
    </style>
@endsection

@section('content')
    <!-- slider_section - start =============== -->

    <section class="slider_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main_slider" data-slick='{"arrows": false}'>
                        <div class="slider_item set-bg-image"
                            data-background="{{ asset('asset/frontend/images/slider/slide-2.jpg') }}">
                            <div class="slider_content">
                                <h3 class="small_title" data-animation="fadeInUp2" data-delay=".2s">Clothing</h3>
                                <h4 class="big_title" data-animation="fadeInUp2" data-delay=".4s">Smart blood <span>Pressure
                                        monitor</span></h4>
                                <p data-animation="fadeInUp2" data-delay=".6s">The best gadgets collection 2021</p>
                                <div class="item_price" data-animation="fadeInUp2" data-delay=".6s">
                                    <del>$430.00</del>
                                    <span class="sale_price">$350.00</span>
                                </div>
                                <a class="btn btn_primary" href="shop_details.html" data-animation="fadeInUp2"
                                    data-delay=".8s">Start Buying</a>
                            </div>
                        </div>
                        <div class="slider_item set-bg-image"
                            data-background="{{ asset('asset/frontend/images/slider/slide-3.jpg') }}">
                            <div class="slider_content">
                                <h3 class="small_title" data-animation="fadeInUp2" data-delay=".2s">Clothing</h3>
                                <h4 class="big_title" data-animation="fadeInUp2" data-delay=".4s">Smart blood <span>Pressure
                                        monitor</span></h4>
                                <p data-animation="fadeInUp2" data-delay=".6s">The best gadgets collection 2021</p>
                                <div class="item_price" data-animation="fadeInUp2" data-delay=".6s">
                                    <del>$430.00</del>
                                    <span class="sale_price">$350.00</span>
                                </div>
                                <a class="btn btn_primary" href="shop_details.html" data-animation="fadeInUp2"
                                    data-delay=".8s">Start Buying</a>
                            </div>
                        </div>
                        <div class="slider_item set-bg-image"
                            data-background="{{ asset('asset/frontend/images/slider/slide-1.jpg') }}">
                            <div class="slider_content">
                                <h3 class="small_title" data-animation="fadeInUp2" data-delay=".2s">Clothing</h3>
                                <h4 class="big_title" data-animation="fadeInUp2" data-delay=".4s">Smart blood <span>Pressure
                                        monitor</span></h4>
                                <p data-animation="fadeInUp2" data-delay=".6s">The best gadgets collection 2021</p>
                                <div class="item_price" data-animation="fadeInUp2" data-delay=".6s">
                                    <del>$430.00</del>
                                    <span class="sale_price">$350.00</span>
                                </div>
                                <a class="btn btn_primary" href="shop_details.html" data-animation="fadeInUp2"
                                    data-delay=".8s">Start Buying</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider_section - end ============ -->

    <!-- policy_section - start ======================== -->
    <section class="policy_section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="policy-wrap">
                        <div class="policy_item">
                            <div class="item_icon">
                                <i class="icon icon-Truck"></i>
                            </div>
                            <div class="item_content">
                                <h3 class="item_title">Free Shipping</h3>
                                <p>
                                    Free shipping on all US order
                                </p>
                            </div>
                        </div>

                        <div class="policy_item">
                            <div class="item_icon">
                                <i class="icon icon-Headset"></i>
                            </div>
                            <div class="item_content">
                                <h3 class="item_title">Support 24/ 7</h3>
                                <p>
                                    Contact us 24 hours a day
                                </p>
                            </div>
                        </div>

                        <div class="policy_item">
                            <div class="item_icon">
                                <i class="icon icon-Wallet"></i>
                            </div>
                            <div class="item_content">
                                <h3 class="item_title">100% Money Back</h3>
                                <p>
                                    You have 30 days to Return
                                </p>
                            </div>
                        </div>

                        <div class="policy_item">
                            <div class="item_icon">
                                <i class="icon icon-Starship"></i>
                            </div>
                            <div class="item_content">
                                <h3 class="item_title">90 Days Return</h3>
                                <p>
                                    If goods have problems
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- policy_section - end =================== -->


    <!-- promotion_section - start=========== -->

    <section class="promotion_section">
        <div class="container">
            <div class="row promotion_banner_wrap">

                @foreach ($products->take(2) as $product)
                    <div class="col col-lg-6">
                        <div class="promotion_banner">
                            <div class="item_image">
                                <img src="{{ asset('storage/product/' . $product->image) }}" width="100%">
                            </div>
                            <div class="item_content">
                                <h3 class="item_title">{{ Str::limit($product->title, 22, '...') }}</h3>
                                <p>{{ Str::limit($product->short_description, 40, '...') }}</p>
                                <a class="btn btn_primary" href="{{ route('frontend.single.shop', $product->slug) }}">Bye
                                    Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- promotion_section - end ======= -->

    <!-- new_arrivals_section - start ========= -->
    <section class="new_arrivals_section section_space">
        <div class="container">
            <div class="sec-title-link">
                <h3>New Arrivals</h3>
            </div>

            <div class="row newarrivals_products">
                <div class="col col-lg-5">
                    <div class="deals_product_layout1">
                        <div class="bg_area">
                            <h3 class="item_title">Best <span>Product</span> Deals</h3>
                            <p>
                                Get Cashback when buying Product.
                            </p>
                            <a class="btn btn_primary" href="{{ route('frontend.shop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-7">
                    <div class="new-arrivals-grids clearfix">

                        @forelse ($products->take(4) as $product)
                            <div class="grid">
                                <div class="product-pic">
                                    <img src="{{ asset('storage/product/' . $product->image) }}"
                                        alt="{{ $product->title }}" width="100%">
                                </div>
                                <div class="details">
                                    <h4><a href="#">{{ Str::limit($product->title, 20, '...') }}</a></h4>
                                    <p><a href="#">{{ Str::limit($product->short_description, 25, '...') }}</a>
                                    </p>

                                    <span class="price">
                                        <ins>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi> <span
                                                        class="woocommerce-Price-currencySymbol">$</span>{{ $product->sale_price ?? $product->price }}
                                                </bdi>
                                            </span>
                                        </ins>
                                        @if ($product->sale_price)
                                            <del aria-hidden="true">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span
                                                            class="woocommerce-Price-currencySymbol">$</span>{{ $product->price }}
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
                        @empty
                            <p class="text-center text-danger">No Product Available</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- new_arrivals_section - end ========= -->

    <!-- brand_section - start ============== -->
    <div class="brand_section pb-0">
        <div class="container">
            <div class="brand_carousel">
                <div class="slider_item">
                    <a class="product_brand_logo" href="#!">
                        <img src="{{ asset('asset/frontend/images/brand/brand_1.png') }}" alt="image_not_found">
                        <img src="{{ asset('asset/frontend/images/brand/brand_1.png') }}" alt="image_not_found">
                    </a>
                </div>
                <div class="slider_item">
                    <a class="product_brand_logo" href="#!">
                        <img src="{{ asset('asset/frontend/images/brand/brand_2.png') }}" alt="image_not_found">
                        <img src="{{ asset('asset/frontend/images/brand/brand_2.png') }}" alt="image_not_found">
                    </a>
                </div>
                <div class="slider_item">
                    <a class="product_brand_logo" href="#!">
                        <img src="{{ asset('asset/frontend/images/brand/brand_3.png') }}" alt="image_not_found">
                        <img src="{{ asset('asset/frontend/images/brand/brand_3.png') }}" alt="image_not_found">
                    </a>
                </div>
                <div class="slider_item">
                    <a class="product_brand_logo" href="#!">
                        <img src="{{ asset('asset/frontend/images/brand/brand_4.png') }}" alt="image_not_found">
                        <img src="{{ asset('asset/frontend/images/brand/brand_4.png') }}" alt="image_not_found">
                    </a>
                </div>
                <div class="slider_item">
                    <a class="product_brand_logo" href="#!">
                        <img src="{{ asset('asset/frontend/images/brand/brand_5.png') }}" alt="image_not_found">
                        <img src="{{ asset('asset/frontend/images/brand/brand_5.png') }}" alt="image_not_found">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- brand_section - end ================ -->

@endsection

@section('js')
@endsection
