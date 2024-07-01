@extends('layouts.frontend')

@section('title', 'All Products')

@section('content')
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li>Products</li>
            </ul>
        </div>
    </div>

    <section class="product_section section_space">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">

                    <div class="filter_topbar">
                        <div class="row align-items-center">
                            <div class="col col-md-4">
                                <ul class="layout_btns nav" role="tablist">
                                    <li>
                                        <button class="active"><i class="fal fa-bars"></i></button>
                                    </li>
                                </ul>
                            </div>

                            <div class="col col-md-4">
                                <form action="#">
                                    <div class="select_option clearfix">
                                        <select style="display: none;">
                                            <option data-display="Defaul Sorting">Select Your Option</option>
                                            <option value="1">Sorting By Name</option>
                                            <option value="2">Sorting By Price</option>
                                            <option value="3">Sorting By Size</option>
                                        </select>
                                        <div class="nice-select" tabindex="0"><span class="current">Defaul
                                                Sorting</span>
                                            <ul class="list">
                                                <li data-value="Select Your Option" data-display="Defaul Sorting"
                                                    class="option selected">Select Your Option</li>
                                                <li data-value="1" class="option">Sorting By Name</li>
                                                <li data-value="2" class="option">Sorting By Price</li>
                                                <li data-value="3" class="option">Sorting By Size</li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col col-md-4">
                                <div class="result_text">Showing 1-12 of 30 relults</div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="tab-content">
                        <div class="show active" id="home">
                            <div class="shop-product-area shop-product-area-col">
                                <div class="product-area shop-grid-product-area clearfix">

                                    @forelse ($products as $product)
                                        <div class="grid">
                                            <div class="product-pic">
                                                <img src="{{ asset('storage/product/' . $product->image) }}"
                                                    alt="{{ $product->title }}">
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
                                                <h4><a href="#">{{ Str::limit($product->title, 20, '...') }}</a></h4>
                                                <p><a
                                                        href="#">{{ Str::limit($product->short_description, 25, '...') }}</a>
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

                            <div class="pagination_wrap">
                                <ul class="pagination_nav">
                                    <li class="active"><a href="#!">01</a></li>
                                    <li><a href="#!">02</a></li>
                                    <li><a href="#!">03</a></li>
                                    <li class="prev_btn">
                                        <a href="#!"><i class="fal fa-angle-left"></i></a>
                                    </li>
                                    <li class="next_btn">
                                        <a href="#!"><i class="fal fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<p class="fs-5">{{ Session::get('success') }}</p>',
                showConfirmButton: false,
                timer: 1500,
            })
        </script>
    @endif

@endsection
