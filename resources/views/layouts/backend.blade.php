<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- theme meta -->
    <meta name="theme-name" content="mono" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="{{ asset('asset/backend/plugins/material/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset/backend/plugins/simplebar/simplebar.css') }}" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="{{ asset('asset/backend/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- MONO CSS -->
    <link id="main-css-href" rel="stylesheet" href="{{ asset('asset/backend/css/style.css') }}" />
    <!-- FAVICON -->
    <link href="{{ asset('asset/backend/images/favicon.png') }}" rel="shortcut icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Josefin Sans', sans-serif;
        }

        a:link {
            text-decoration: none;
        }


        a:visited {
            text-decoration: none;
        }


        a:hover {
            text-decoration: none;
        }


        a:active {
            text-decoration: none;
        }

        .mr-5 {
            margin-right: 100px !important,
        }
    </style>
    @yield('css')
    {{-- page css --}}
    <!--HTML5 shim and Respond.js -->
    <script src="{{ asset('asset/backend/plugins/nprogress/nprogress.js') }}"></script>
</head>


<body class="navbar-fixed sidebar-fixed" id="body">
    <!-- ========= WRAPPER ===== -->
    <div class="wrapper">
        <!-- ======= LEFT SIDEBAR  -->
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
            <div id="sidebar" class="sidebar sidebar-with-footer">
                <!-- Aplication Brand -->
                <div class="app-brand">
                    <a href="{{ route('backend.home') }}">
                        <img src="{{ asset('asset/backend/images/logo.png') }}" alt="Mono">
                        <span class="brand-name">MONO</span>
                    </a>
                </div>
                <!-- begin sidebar scrollbar -->
                <div class="sidebar-left" data-simplebar style="height: 100%;">
                    <!-- sidebar menu -->
                    <ul class="nav sidebar-inner" id="sidebar-menu">

                        <li class="{{ Route::is('backend.home') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('backend.home') }}">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        @role('super-admin')
                            <li class="section-title">
                                ROLE MANAGEMENT
                            </li>

                            <li id="role"
                                class="has-sub {{ Route::is('backend.role.*', 'backend.permission.*', 'backend.user.*') ? 'active' : '' }}">

                                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                                    data-target="#ROLE" aria-expanded="false" aria-controls="ROLE">

                                    <i class="mdi mdi-account-outline"></i>
                                    <span class="nav-text">Role Permission</span><b class="caret"></b>
                                </a>

                                <ul class="collapse cntr {{ Route::is('backend.role.*', 'backend.permission.*', 'backend.user.*') ? 'show' : '' }}"
                                    id="ROLE" data-parent="#sidebar-menu">
                                    <div class="sub-menu">

                                        <li class="{{ Route::is('backend.role.create') ? 'active' : '' }}">
                                            <a class="sidenav-item-link" href="{{ route('backend.role.create') }}">
                                                <span class="nav-text">Create</span>
                                            </a>
                                        </li>

                                        <li
                                            class="{{ Route::is('backend.role.users', 'backend.user.*') ? 'active' : '' }}">
                                            <a class="sidenav-item-link" href="{{ route('backend.role.users') }}">
                                                <span class="nav-text">All users</span>
                                            </a>
                                        </li>

                                        <li
                                            class="{{ Route::is('backend.role.index', 'backend.role.edit') ? 'active' : '' }}">
                                            <a class="sidenav-item-link" href="{{ route('backend.role.index') }}">
                                                <span class="nav-text">All Roles</span>
                                            </a>
                                        </li>

                                        <li
                                            class="{{ Route::is('backend.role.permission.index', 'backend.permission.*') ? 'active' : '' }}">
                                            <a class="sidenav-item-link"
                                                href="{{ route('backend.role.permission.index') }}">
                                                <span class="nav-text">All Permission</span>
                                            </a>
                                        </li>

                                    </div>
                                </ul>

                            </li>
                        @endrole

                        <li class="section-title">
                            CATEGORY MANAGEMENT
                        </li>

                        <li id="cat"
                            class="has-sub {{ Route::is('backend.product.category.*') ? 'active' : '' }}">

                            <a class="sidenav-item-link" href="#" data-toggle="collapse" data-target="#CAT"
                                aria-expanded="false" aria-controls="CAT">
                                <i class="mdi mdi-account-outline"></i>
                                <span class="nav-text">Product Category</span> <b class="caret"></b>
                            </a>

                            <ul class="collapse cntr {{ Route::is('backend.product.category.*') ? 'show' : '' }}"
                                id="CAT" data-parent="#sidebar-menu">
                                <div class="sub-menu">

                                    <li
                                        class="mr-5 {{ Route::is('backend.product.category.index') ? 'active' : '' }}">
                                        <a class="sidenav-item-link"
                                            href="{{ route('backend.product.category.index') }}">
                                            <span class="nav-text">All Category</span>
                                        </a>
                                    </li>

                                    <li
                                        class="mr-5 {{ Route::is('backend.product.category.create') ? 'active' : '' }}">
                                        <a class="sidenav-item-link"
                                            href="{{ route('backend.product.category.create') }}">
                                            <span class="nav-text">Create Category</span>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </li>

                        <li class="section-title">
                            PRODUCT MANAGEMENT
                        </li>

                        <li class="has-sub" id="product">

                            <a class="sidenav-item-link" href="#" data-toggle="collapse"
                                data-target="#PRODUCT" aria-expanded="false" aria-controls="PRODUCT">
                                <i class="mdi mdi-account-outline"></i>
                                <span class="nav-text">Products</span> <b class="caret"></b>
                            </a>

                            <ul class="collapse cntr {{ Route::is('backend.product.index', 'backend.product.show', 'backend.product.create', 'backend.product.store', 'backend.product.edit', 'backend.product.update', 'backend.product.updateGall', 'backend.product.editGallImg', 'backend.product.updateGallImg', 'backend.product.delteGallImg', 'backend.product.softDel', 'backend.product.proUndo', 'backend.product.destroy') ? 'show' : '' }}"
                                id="PRODUCT" data-parent="#sidebar-menu">

                                <div class="sub-menu">
                                    <li
                                        class="mr-5 {{ Route::is('backend.product.index', 'backend.product.show', 'backend.product.create', 'backend.product.store', 'backend.product.edit', 'backend.product.update', 'backend.product.updateGall', 'backend.product.editGallImg', 'backend.product.updateGallImg', 'backend.product.delteGallImg', 'backend.product.softDel', 'backend.product.proUndo', 'backend.product.destroy') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('backend.product.index') }}">
                                            <span class="nav-text">All Products</span>
                                        </a>
                                    </li>
                                </div>

                            </ul>

                        </li>

                        <li class="{{ Route::is('backend.product.coupon.*') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('backend.product.coupon.index') }}">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Coupon</span>
                            </a>
                        </li>

                        <li class="{{ Route::is('backend.product.shipping.*') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('backend.product.shipping.index') }}">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Shipping Condition</span>
                            </a>
                        </li>

                        <li class="section-title">
                            ORDER MANAGEMENT
                        </li>

                        <li class="{{ Route::is('backend.order.*') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('backend.order.index') }}">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">All Orders</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </aside>

        <!-- ========= PAGE WRAPPER ===== -->
        <div class="page-wrapper">
            <!-- Header -->
            <header class="main-header" id="header">
                <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                    <!-- Sidebar toggle button -->
                    <button id="sidebar-toggler" class="sidebar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                    </button>

                    <span class="page-title">
                        @yield('breadcamp')
                    </span>

                    <div class="navbar-right ">

                        <!-- search form -->
                        <div class="search-form">
                            <form action="index.html" method="get">
                                <div class="input-group input-group-sm" id="input-group-search">
                                    <input type="text" autocomplete="off" name="query" id="search-input"
                                        class="form-control" placeholder="Search..." />
                                    <div class="input-group-append">
                                        <button class="btn" type="button">/</button>
                                    </div>
                                </div>
                            </form>

                            <ul class="dropdown-menu dropdown-menu-search">

                                <li class="nav-item">
                                    <a class="nav-link" href="index.html">Morbi leo risus</a>
                                </li>

                            </ul>
                        </div>

                        <ul class="nav navbar-nav">
                            <!-- User Account -->
                            <li class="dropdown user-menu">
                                <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="fa fa-user"></i>
                                    <span class="d-none d-lg-inline-block"> {{ Auth::user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li>
                                        <a class="dropdown-link-item" href="user-profile.html">
                                            <i class="mdi mdi-account-outline"></i>
                                            <span class="nav-text">My Profile</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-footer">
                                        <a class="dropdown-link-item link-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- ======  CONTENT WRAPPER ====== -->
            <div class="content-wrapper">
                <div class="content">

                    <div class="row">

                        @yield('content')

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        &copy; <span id="copy-year"></span> Develop With Php Laravel by <a class="text-primary"
                            href="" target="_blank">Anik</a>.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    {{-- js  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('asset/backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/backend/plugins/simplebar/simplebar.min.js') }}"></script>
    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
    <script src="{{ asset('asset/backend/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('asset/backend/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('asset/backend/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{ asset('asset/backend/js/mono.js') }}"></script>
    <script src="{{ asset('asset/backend/js/chart.js') }}"></script>
    <script src="{{ asset('asset/backend/js/map.js') }}"></script>
    <script src="{{ asset('asset/backend/js/custom.js') }}"></script>
    {{-- page js --}}
    @yield('js')
    <!--  -->
</body>

</html>
