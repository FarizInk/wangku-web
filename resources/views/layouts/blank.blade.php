<!DOCTYPE html>
<html lang="en">
  <head>
    @include('elements.header')
    @yield('styles')
  </head>

  <body>
    @include('elements.preloader')

    @yield('content')

    @include('elements.footer-blank')
    @include('elements.scripts')
    @yield('scripts')
  </body>
</html>
