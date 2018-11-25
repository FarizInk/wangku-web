<!DOCTYPE html>
<html lang="en">
  <head>
    @include('elements.header')
    @yield('styles')
  </head>

  <body>
    @include('elements.preloader')
    @include('elements.navigation')
    <main>
      <div class="main-content">
        @yield('content')
      </div>
      @include('elements.footer')
    </main>
    @include('elements.scripts')
    @yield('scripts')
  </body>
</html>
