<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="Elisyam is a Web App and Admin Dashboard Template built with Bootstrap 4">
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
<link rel="stylesheet" href="{{ asset('assets/css/photoswipe/photoswipe.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/photoswipe/default-skin/default-skin.min.css') }}">
<!-- Tweaks for older IEs--><!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
<style media="screen">
  .container-fluid {
    margin-bottom: 30px;
  }
</style>
