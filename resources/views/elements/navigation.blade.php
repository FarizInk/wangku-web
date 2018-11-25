<!-- Sidebar -->
<aside class="sidebar sidebar-expand-lg sidebar-light sidebar-sm sidebar-color-info">

  <header class="sidebar-header bg-info">
    <span class="logo">
      <a href="index.html"><img src="{{ asset('img/logo-light.png') }}" alt="logo"></a>
    </span>
    <span class="sidebar-toggle-fold"></span>
  </header>

  <nav class="sidebar-navigation">
    <ul class="menu menu-sm menu-bordery">

      <li class="menu-item active">
        <a class="menu-link" href="index.html">
          <span class="icon ti-home"></span>
          <span class="title">Dashboard</span>
        </a>
      </li>

      <li class="menu-item">
        <a class="menu-link" href="invoices.html">
          <span class="icon ti-receipt"></span>
          <span class="title">Invoices</span>
          <span class="badge badge-pill badge-info">2</span>
        </a>
      </li>
    </ul>
  </nav>

</aside>
<!-- END Sidebar -->



<!-- Topbar -->
<header class="topbar">
  <div class="topbar-left">
    <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>
    <a class="logo d-lg-none" href="index.html"><img src="{{ asset('img/logo-text-sm.png') }}" alt="logo" height="35"></a>

    <ul class="topbar-btns">

      <!-- Notifications -->
      <li class="dropdown d-none d-lg-block">
        <span class="topbar-btn has-new" data-toggle="dropdown"><i class="ti-bell"></i></span>
        <div class="dropdown-menu">

          <div class="media-list media-list-hover media-list-divided media-list-xs">
            <a class="media media-new" href="#">
              <span class="avatar bg-success"><i class="ti-user"></i></span>
              <div class="media-body">
                <p>New user registered</p>
                <time datetime="2017-07-14 20:00">Just now</time>
              </div>
            </a>

            <a class="media" href="#">
              <span class="avatar bg-info"><i class="ti-shopping-cart"></i></span>
              <div class="media-body">
                <p>New order received</p>
                <time datetime="2017-07-14 20:00">2 min ago</time>
              </div>
            </a>

            <a class="media" href="#">
              <span class="avatar bg-warning"><i class="ti-face-sad"></i></span>
              <div class="media-body">
                <p>Refund request from <b>Ashlyn Culotta</b></p>
                <time datetime="2017-07-14 20:00">24 min ago</time>
              </div>
            </a>

            <a class="media" href="#">
              <span class="avatar bg-primary"><i class="ti-money"></i></span>
              <div class="media-body">
                <p>New payment has made through PayPal</p>
                <time datetime="2017-07-14 20:00">53 min ago</time>
              </div>
            </a>
          </div>

          <div class="dropdown-footer">
            <div class="left">
              <a href="#">Read all notifications</a>
            </div>

            <div class="right">
              <a href="#" data-provide="tooltip" title="Mark all as read"><i class="fa fa-circle-o"></i></a>
              <a href="#" data-provide="tooltip" title="Update"><i class="fa fa-repeat"></i></a>
              <a href="#" data-provide="tooltip" title="Settings"><i class="fa fa-gear"></i></a>
            </div>
          </div>

        </div>
      </li>
      <!-- END Notifications -->

    </ul>
  </div>

  <div class="topbar-right">

    <ul class="topbar-btns">
      <li class="dropdown">
        <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="@if (Auth::user()->metadata['photo'] == null){{ asset('img/avatar/default.jpg') }}@else{{ asset('images/profile') . '/' . Auth::user()->metadata['photo'] }}@endif" alt="Photo Profile"></span>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{ route('profile') }}"><i class="ti-user"></i> {{ Auth::user()->name }}</a>
          @if (Auth::user()->roles[0]['name'] == "admin")
          <a class="dropdown-item" href="{{ route('admin.index') }}"><i class="ti-crown"></i> Admin Page</a>
          @endif
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> Logout</a>
        </div>
      </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

  </div>
</header>
<!-- END Topbar -->
