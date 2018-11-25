<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.header')
    @yield('styles')
</head>
<body id="page-top">
    <div id="preloader">
        <div class="canvas">
            <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="loader-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- End Preloader -->
    <div class="page mail">
        <!-- Begin Page Content -->
        <div class="page-content d-flex align-items-stretch">
            <!-- Begin Header -->
            @include('admin.elements.navbar')
            <!-- End Header -->
            @include('admin.elements.sidebar')
            <!-- End Left Sidebar -->
            <div class="content-inner" style="margin-top: 70px;">
                <!-- Begin Container -->
                @yield('content')
                <!-- End Container -->
                <!-- Begin Page Footer-->
                @include('admin.elements.footer')
                <!-- End Page Footer -->
                <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    @include('admin.elements.scripts')
    @yield('scripts')
</body>

</html>
