@php
  use App\Entities\User;
  use App\Entities\Group;

  $count['users'] = count(User::all());
  $count['groups'] = count(Group::all());
@endphp
<div class="default-sidebar">
    <!-- Begin Side Navbar -->
    <nav class="side-navbar box-scroll sidebar-scroll">
        <span class="heading mt-3">Menu</span>
        <ul class="list-unstyled">
            <li><a href="{{ route('admin.index') }}"><i class="la la-home"></i>Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}"><i class="la la-user"></i>Users<span class="nb-new badge-rounded info badge-rounded-small">{{ $count['users'] }}</span></a></li>
            <li><a href="{{ route('admin.transaction') }}"><i class="la la-newspaper-o"></i>Transaction</a>
            </li>
            <li><a href="{{ route('admin.groups') }}"><i class="la la-group"></i>Groups<span class="nb-new badge-rounded info badge-rounded-small">{{ $count['groups'] }}</span></a></li>
        </ul>
        <span class="heading">Labels</span>
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('admin.users.banned') }}">
                    <div class="text">
                        <div class="link"><span class="badge-rounded mr-2 danger"></span>Banned</div>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Side Navbar -->
</div>
