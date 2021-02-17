<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/app.min.css" rel="stylesheet" type="text/css" />


    </head>

    <body class="left-side-menu-dark">
        <div id="wrapper">

            <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
                <div class="container-fluid">

                    <a href="#" class="navbar-brand mr-0 mr-md-2 logo">
                        <span class="logo-lg">
                            <img src="/images/logo-blue.png" alt="" width="80" />
                        </span>
                        <span class="logo-sm">
                            <img src="/images/logo-blue.png" alt="" width="80">
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
                        <li class="text-info"><?php echo 'company_name' ?></li>              
                    </ul>
                </div>

            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">
                <div class="media user-profile mt-2 mb-2">
                    <div class="media-body">
                        <h6 class="pro-user-name mt-0 mb-0"><?php echo 'full_name' ?></h6>
                        <span class="pro-user-desc"><?php echo 'username' ?></span>
                    </div>
                    <div class="dropdown align-self-center profile-dropdown-menu">
                        <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <span data-feather="chevron-down"></span>
                        </a>
                        <div class="dropdown-menu profile-dropdown">
                            <a href="password" class="dropdown-item notify-item">
                                <i data-feather="key" class="icon-dual icon-xs mr-2"></i>
                                <span>Change Password</span>
                            </a>
                            <a href="logout" class="dropdown-item notify-item">
                                <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-content">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu" class="slimscroll-menu">
                        <ul class="metismenu" id="menu-bar">
                            <li class="menu-title">Navigation</li>
                            @foreach($menu1 as $m)
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="{{ $m->nav_header_icon}}"></i>
                                    <span> {{ $m->nav_header_name }} </span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul class="nav-second-level" aria-expanded="false">
                                    @foreach($menu2 as $m2)
                                    <li>
                                        <a href="{{ $m2->nav_menu_url }}">&nbsp;{{ $m2->nav_menu_name }}</a>
                                    </li>
                                    @endforeach    
                                </ul>
                            </li>
                            @endforeach
                            <li><a href="logout">Logout</a></li>  
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
        </div>

        <div class="rightbar-overlay"></div>
        <script src="/js/vendor.min.js"></script>
        <script src="/js/app.min.js"></script>
    </body>
</html>