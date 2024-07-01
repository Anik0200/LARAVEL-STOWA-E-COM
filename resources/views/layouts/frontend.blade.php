<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('asset/frontend/images/logo/favourite_icon_1.png') }}">
    <!-- fraimwork - css include -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- icon font - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/stroke-gap-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/icofont.css') }}">
    <!-- animation - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/animate.css') }}">
    <!-- carousel - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/slick-theme.css') }}">
    <!-- popup - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/magnific-popup.css') }}">
    <!-- jquery-ui - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/jquery-ui.css') }}">
    <!-- select option - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/nice-select.css') }}">
    <!-- custom - css include -->
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/frontend/css/style.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    @yield('css')
</head>

<body>

    <!-- body_wrap - start -->
    <div class="body_wrap">

        <!-- backtotop - start -->
        <div class="backtotop">
            <a href="#" class="scroll">
                <i class="far fa-arrow-up"></i>
            </a>
        </div>
        <!-- backtotop - end -->

        <!-- preloader - start -->
        <div id="preloader"></div>
        <!-- preloader - end -->

        <!-- header_section - start ======================== -->
        <header class="header_section header-style-no-collapse">
            <div class="header_top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col col-md-6">
                            <ul class="header_select_options ul_li">
                                <li><a href="#!"><i class="icofont-youtube-play"></i></a></li>
                                <li><a href="#!"><i class="icofont-instagram"></i></a></li>
                                <li><a href="#!"><i class="icofont-twitter"></i></a></li>
                                <li><a href="#!"><i class="icofont-facebook"></i></a></li>
                                <li><a href="#!"><i class="icofont-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <div class="col col-md-6">
                            <p class="header_hotline">Call us toll free: <strong>+1888 234 5678</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header_middle">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col col-lg-3 col-md-3 col-sm-12">
                            <div class="brand_logo">
                                <a class="brand_link" href="{{ route('frontend.index') }}">
                                    <img src="{{ asset('asset/frontend/images/logo/logo_1x.png') }}"
                                        srcset="{{ asset('asset/frontend/images/logo/logo_2x.png 2x') }}" alt>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <form method="GET" action="{{ route('productSrch.index') }}">
                                @csrf
                                <div class="advance_serach">

                                    <div class="select_option mb-0 clearfix">
                                        <select name="category_id" class="select">
                                            <option data-display="All Categories">Select A Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form_item">
                                        <input type="search" name="search" placeholder="Search Prudcts...">
                                        <button type="submit" class="search_btn"><i class="far fa-search"></i></button>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="header_bottom mt-5">
                    <div class="container">


                        <button class="mobile_menu_btn2 navbar-toggler mt-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_menu_dropdown" aria-controls="main_menu_dropdown"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fal fa-bars"></i>
                        </button>

                        <div class="cart_btn  mt-2">
                            <span class="cart_icon">
                                <a class="text-dark" href="{{ route('frontend.shop') }}">Shop</a>
                            </span>
                        </div>


                        <div class="col col-md-6">
                            <nav class="main_menu navbar navbar-expand-lg">
                                <div class="main_menu_inner collapse navbar-collapse" id="main_menu_dropdown">
                                    <button type="button" class="offcanvas_close">
                                        <i class="fal fa-times"></i>
                                    </button>
                                    <ul class="main_menu_list ul_li">

                                        <li>
                                            <a class="nav-link" href="{{ route('frontend.index') }}"
                                                id="shop_submenu" role="button">Home</a>
                                        </li>

                                        <li>
                                            <a class="nav-link" href="{{ route('frontend.shop') }}"
                                                id="shop_submenu" role="button">Shop</a>
                                        </li>

                                        <li>
                                            <a class="nav-link" href="{{ route('frontend.cart.index') }}"
                                                id="shop_submenu" role="button">Cart</a>
                                        </li>

                                        <li>
                                            <a class="nav-link" href="{{ route('user.orders') }}" id="shop_submenu"
                                                role="button">Your Order</a>
                                        </li>

                                        @if (Auth::guest())
                                            <li>
                                                <a class="nav-link" href="{{ route('login') }}" id="shop_submenu"
                                                    role="button">Login</a>
                                            </li>
                                        @endif

                                        @if (Auth::check())
                                            <li class="dropdown-footer">
                                                <a class="dropdown-link-item link-danger"
                                                    href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </nav>
                            <div class="offcanvas_overlay"></div>
                        </div>





                    </div>
                </div>
            </div>
        </header>
        <!-- header_section - end ======================= -->

        <!-- main body - start ====================== -->
        <main>

            {{-- <!-- sidebar cart - start ===================== -->

            <!-- sidebar cart - end ==================== --> --}}

            <!-- product quick view modal - start =============== -->

            <!-- product quick view modal - end ============== -->

            @yield('content')

            <!-- newsletter_section - start ============== -->
            {{-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX --}}
            <!-- newsletter_section - end ========================= -->

        </main>
        <!-- main body - end ====================== -->

        <!-- footer_section - start =============== -->
        <footer class="footer_section">
            <div class="footer_widget_area">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-4 col-md-6 col-sm-6">
                            <div class="footer_widget footer_about">
                                <div class="brand_logo">
                                    <a class="brand_link" href="index-2.html">
                                        <img src="{{ asset('asset/frontend/images/logo/logo_1x.png') }}"
                                            srcset="{{ asset('asset/frontend/images/logo/logo_2x.png 2x') }}"
                                            alt="logo_not_found">
                                    </a>
                                </div>
                                <ul class="social_round ul_li">
                                    <li><a href="#!"><i class="icofont-youtube-play"></i></a></li>
                                    <li><a href="#!"><i class="icofont-instagram"></i></a></li>
                                    <li><a href="#!"><i class="icofont-twitter"></i></a></li>
                                    <li><a href="#!"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="#!"><i class="icofont-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col col-lg-2 col-md-3 col-sm-6">
                            <div class="footer_widget footer_useful_links">
                                <h3 class="footer_widget_title text-uppercase">Quick Links</h3>
                                <ul class="ul_li_block">
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                    <li><a href="shop.html">Products</a></li>
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="register.html">Sign Up</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col col-lg-2 col-md-3 col-sm-6">
                            <div class="footer_widget footer_useful_links">
                                <h3 class="footer_widget_title text-uppercase">Custom area</h3>
                                <ul class="ul_li_block">
                                    <li><a href="#!">My Account</a></li>
                                    <li><a href="#!">Orders</a></li>
                                    <li><a href="#!">Tracking List</a></li>
                                    <li><a href="#!">Tearm</a></li>
                                    <li><a href="#!">Privacy Policy</a></li>
                                    <li><a href="#!">My Cart</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col col-lg-4 col-md-6 col-sm-6">
                            <div class="footer_widget footer_contact">
                                <h3 class="footer_widget_title text-uppercase">Contact Onfo</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt.
                                </p>
                                <div class="hotline_wrap">
                                    <div class="footer_hotline">
                                        <div class="item_icon">
                                            <i class="icofont-headphone-alt"></i>
                                        </div>
                                        <div class="item_content">
                                            <h4 class="item_title">Have any question?</h4>
                                            <span class="hotline_number">+ 123 456 7890</span>
                                        </div>
                                    </div>
                                    <div class="livechat_btn clearfix">
                                        <a class="btn border_primary" href="#!">Live Chat</a>
                                    </div>
                                </div>
                                <ul class="store_btns_group ul_li">
                                    <li><a href="#!"><img
                                                src="{{ asset('asset/frontend/images/app_store.png') }}"
                                                alt="app_store"></a>
                                    </li>
                                    <li><a href="#!"><img
                                                src="{{ asset('asset/frontend/images/play_store.png') }}"
                                                alt="play_store"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer_bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col col-md-6">
                            <p class="copyright_text">
                                ©2021 <a href="#!">stowaa</a>. All Rights Reserved.
                            </p>
                        </div>

                        <div class="col col-md-6">
                            <div class="payment_method">
                                <h4>Payment:</h4>
                                <img src="{{ asset('asset/frontend/images/payments_icon.png') }}"
                                    alt="image_not_found">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer_section - end ======= -->

    </div>
    <!-- body_wrap - end -->

    <!-- fraimwork - jquery include -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <!-- carousel - jquery plugins collection -->
    <script src="{{ asset('asset/frontend/js/jquery-plugins-collection.js') }}"></script>

    <!-- custom - main-js -->
    <script src="{{ asset('asset/frontend/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    @yield('js')

</body>

</html>
