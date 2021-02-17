<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{$title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="/images/favicon.ico">

        <!-- App css -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">
        
        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-6 p-5">
                                        <div class="mx-auto mb-5">
                                            <a href="login">
                                                <img src="assets/images/logo-blue.png" alt="" />
                                            </a>
                                        </div>

                                        <h6 class="h5 mb-0 mt-4">Welcome back!</h6>
                                        <p class="text-muted mt-1 mb-4">Enter your username and password</p>
                                        @if(Session::has('error')) <div class="alert alert-danger">{{ Session::get('error')}}</div>@endif
                                        @if(count($errors)>0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                        <form method="POST" action="auth" id="time_form" name="time_form">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" />
                                            <div class="form-group">
                                                <label class="form-control-label">{{$username}}</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="mail"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Your username" name="txt_username" value="{{ old('txt_username')}}" />
                                                </div>
                                            </div>

                                            <div class="form-group mt-4">
                                                <label class="form-control-label">{{$password}}</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="lock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="password" class="form-control" placeholder="Your password" name="txt_password" />
                                                </div>
                                            </div>

                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit"> Log In
                                                </button>
                                            </div>
                                        </form>
                                        <div class="py-3 text-center"><span class="font-size-16 font-weight-bold"><a href="/forgot">Forgot Password?</a></span></div>
                                    </div>
                                    <div class="col-lg-6 d-none d-md-inline-block">
                                        <div class="auth-page-sidebar">
                                            <div class="overlay"></div>
                                            <div class="auth-user-testimonial">
                                                <p class="font-size-24 font-weight-bold text-white mb-1">The secret of success is simple.</p>
                                                <p class="lead">"Just use AMOR to monitor your team"</p>
                                                <p>- AMOR -</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/js/app.min.js"></script>
        
    </body>
</html>