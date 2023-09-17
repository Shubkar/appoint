<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <title>Login</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description"
          content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="colorlib"/>
    <!-- Favicon icon -->

    <link rel="apple-touch-icon" sizes="57x57" href="files/fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="files/fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="files/fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="files/fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="files/fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="files/fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="files/fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="files/fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="files/fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="files/fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="files/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="files/fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="files/fav/favicon-16x16.png">
    <link rel="manifest" href="files/fav/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="files/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="files/assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="files/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/pages.css">
    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="files/assets/pages/notification/notification.css">
</head>

<body themebg-pattern="theme1">
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="loader-track">
        <div class="preloader-wrapper">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pre-loader end -->
<section class="login-block">
    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <form class="md-float-material form-material" method="post" action="{{ route('login') }}">
                    <div class="text-center">
                        <img src="files/assets/images/logo.png" alt="logo.png">
                    </div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center txt-primary">Sign In</h3>
                                </div>
                            </div>
                            <p class="text-muted text-center p-b-5">Sign in to Dashboard</p>
                            <div class="form-group form-primary">
                                <input type="text" name="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       required="">
                                <span class="form-bar"></span>
                                <label class="float-label">Email</label>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                                @endif
                            </div>
                            <div class="form-group form-primary">
                                <input type="password" name="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       required="">
                                <span class="form-bar"></span>
                                <label class="float-label">Password</label>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
                                @endif
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                        LOGIN
                                    </button>
                                    {{--<button type="button" class="btn btn-primary waves-effect" data-type="danger"
                                            data-from="top" data-align="center" data-icon="fa fa-comments"
                                            data-title="Header" data-message="Invalid Username and Password"
                                            onclick="notify(this)">Top Center


                                    </button>--}}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>


                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end of form -->
            </div>
            <!-- Authentication card end -->
        </div>
        <!-- end of col-sm-12 -->
    </div>
    <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>
<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="files/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="files/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="files/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="files/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="files/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>

</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="files/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="files/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="files/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- waves js -->
<script src="files/assets/pages/waves/js/waves.min.js" type="text/javascript"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="files/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="files/bower_components/modernizr/js/css-scrollbars.js"></script>
<script type="text/javascript" src="files/assets/js/common-pages.js"></script>

<!-- notification js -->
<script type="text/javascript" src="files/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="files/assets/pages/notification/notification.js"></script>
<script src="files/assets/js/pcoded.min.js" type="text/javascript"></script>
<script src="files/assets/js/vertical/vertical-layout.min.js" type="text/javascript"></script>
<script src="files/assets/js/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>
<!-- Custom js -->
<script type="text/javascript" src="files/assets/js/script.js"></script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/a2bd7673/cloudflare-static/rocket-loader.min.js"
        defer=""></script>

<script type="text/javascript">
        @if(isset($errMSg))
    {
        notify('top', 'center', 'fa fa-user-times', 'danger', 'animated flipInX', 'animated flipOutX', 'Invalid Username and Password');
    }
    @endif
</script>
</body>
</html>
