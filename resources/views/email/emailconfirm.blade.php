<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Confirm Registration - Wangku</title>
    <meta name="description" content="Successfuly Registration Page">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Google Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/base/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/base/elisyam-1.5.min.css') }}">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body class="bg-fixed-02">
    <!-- Begin Preloader -->
    <div id="preloader">
        <div class="canvas">
            <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="loader-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- End Preloader -->
    <!-- Begin Container -->
    <div class="container-fluid h-100 overflow-y">
        <div class="row flex-row h-100">
            <div class="col-12 my-auto">
                <div class="mail-confirm mx-auto">
                    <div class="animated-icon">
                        <div class="gradient"></div>
                        <div class="icon"><i class="la la-at"></i></div>
                    </div>
                    <h3>Successfuly email verification!</h3>
                    <div class="button text-center">
                        <a href="{{ route('login') }}" class="btn btn-lg btn-gradient-01">
                            Login
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Container -->
    <!-- Begin Vendor Js -->
    <script src="{{ asset('assets/vendors/js/base/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/base/core.min.js') }}"></script>
    <!-- End Vendor Js -->
    <!-- Begin Page Vendor Js -->
    <script src="{{ asset('assets/vendors/js/app/app.min.js') }}"></script>
    <!-- End Page Vendor Js -->
</body>

</html>
