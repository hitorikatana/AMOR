<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}">
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/css/app.min.css') }}" rel="stylesheet" type="text/css" />


    </head>

    <body class="left-side-menu-dark">
        <!--<div id="wrapper">-->

            <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
                <div class="container-fluid">

                    <a href="{{ route('home') }}" class="navbar-brand mr-0 mr-md-2 logo">
                        <span class="logo-lg">
                            <img src="{{ asset('/images/logo-blue.png') }}" alt="" width="80" />
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('/images/logo-blue.png') }}" alt="" width="80">
                        </span>
                    </a>

                    <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
                        <li class="">
                            <button class="button-menu-mobile open-left disable-btn">
                                <i data-feather="menu" class="menu-icon"></i>
                                <i data-feather="x" class="close-icon"></i>
                            </button>
                        </li>
                    </ul>

                    <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
                        <li class="text-info">{{ Session::get('full_name') }}</li>
                    </ul>
                </div>

            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">
                <br/>
                <div class="sidebar-content">
                    <div id="sidebar-menu" class="slimscroll-menu">
                        <ul class="metismenu" id="menu-bar">
                            <li class="menu-title">Navigation</li>
                            @foreach(Session::get('menu') as $m)
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="{{ $m->nav_icon}}"></i>
                                    <span> {{ $m->nav_name }} </span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul class="nav-second-level" aria-expanded="false">
                                    @foreach($m->children as $submenu)
                                    <li>
                                        <a href="{{ route($submenu->nav_url) }}">&nbsp;{{ $submenu->nav_name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- Pre-loader -->
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>
                </div>
            </div>
            <!-- End Preloader-->

            @yield('content')
            <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                2020 &copy; AMOR. All Rights Reserved. Built with <i class='uil uil-heart text-danger font-size-12'></i> by <a href="https://satukode.com" target="_blank">Satukode Dotcom</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        <!--</div>-->

        <script src="{{ asset('/js/vendor.min.js') }}"></script>
        <script src="{{ asset('/js/app.min.js') }}"></script>
    </body>
</html>
