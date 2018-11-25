@extends('layouts.app')

@section('title', 'Profile ' . Auth::user()->name)

@section('content')
<div class="row center-vh">
  <div class="col-lg-6">
    <form class="card">
      <h4 class="card-title fw-400">Account Settings</h4>

      <div class="card-body">
        <div class="flexbox gap-items-4">
          <img class="avatar avatar-xl" src="
          @if (Auth::user()->metadata['photo'] == null)
            https://cdn.pixabay.com/photo/2017/07/18/23/23/user-2517433_960_720.png
          @else
            {{ Auth::user()->metadata['photo'] }}
          @endif" alt="...">

          <div class="flex-grow">
            <h5>{{ Auth::user()->name }}</h5>
            <div class="d-flex flex-column flex-sm-row gap-items-2 gap-y mt-16">
              <div class="file-group file-group-inline">
                <button class="btn btn-sm btn-w-lg btn-outline btn-round btn-secondary file-browser" type="button">Change Picture</button>
                <input type="file">
              </div>

              <a class="btn btn-sm btn-w-lg btn-outline btn-round btn-danger" href="#">Delete Picture</a>
            </div>

          </div>
        </div>

        <hr>

        <div class="form-group">
          <label class="text-fader">Name</label>
          <input class="form-control" type="text" value="{{ Auth::user()->name }}">
        </div>


        <div class="form-group">
          <label class="text-fader">Email</label>
          <input class="form-control" type="text">
        </div>


        <div class="row">
          <div class="form-group col-md-6">
            <label class="text-fader">Country</label>
            <div class="btn-group bootstrap-select form-control"><button type="button" class="btn dropdown-toggle bs-placeholder btn-light" data-toggle="dropdown" role="button" title="&amp;nbsp;"><span class="filter-option pull-left">&nbsp;</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open" role="combobox"><div class="dropdown-menu inner" role="listbox" aria-expanded="false"><a class="dropdown-item" data-original-index="1"><span tabindex="0" class="dropdown-item-inner " data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">United States</span><span class=" ti-check check-mark"></span></span></a><a class="dropdown-item" data-original-index="2"><span tabindex="0" class="dropdown-item-inner " data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Canada</span><span class=" ti-check check-mark"></span></span></a><a class="dropdown-item" data-original-index="3"><span tabindex="0" class="dropdown-item-inner " data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Mexico</span><span class=" ti-check check-mark"></span></span></a><a class="dropdown-item" data-original-index="4"><span tabindex="0" class="dropdown-item-inner " data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">United Kingdom</span><span class=" ti-check check-mark"></span></span></a></div></div><select class="form-control" title="&nbsp;" data-provide="selectpicker" tabindex="-98"><option class="bs-title-option" value="">&nbsp;</option>
              <option>United States</option>
              <option>Canada</option>
              <option>Mexico</option>
              <option>United Kingdom</option>
            </select></div>
          </div>

          <div class="form-group col-md-6">
            <label class="text-fader">Phone</label>
            <input class="form-control" type="text">
          </div>
        </div>

        <hr>
      </div>

      <div class="media">
        <div class="media-body">
          <p><strong>Notifications</strong></p>
          <p>Receive notifications from other users</p>
        </div>

        <label class="switch">
          <input type="checkbox" checked="">
          <span class="switch-indicator"></span>
        </label>
      </div>


      <div class="media">
        <div class="media-body">
          <p><strong>Messages</strong></p>
          <p>Allow other users to send you messages</p>
        </div>

        <label class="switch">
          <input type="checkbox">
          <span class="switch-indicator"></span>
        </label>
      </div>

      <div class="card-body">
        <button class="btn btn-block btn-round btn-bold btn-primary" type="submit">Save</button>
      </div>

    </form>
  </div>
</div>
@endsection
