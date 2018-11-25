@extends('layouts.admin')

@section('title', 'Users')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.theme.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/js/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/friends.min.js') }}"></script>
@endsection

@section('content')
@php
use App\Entities\User;
$success = Session::get('success');
@endphp
<div id="modal-centered" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Title</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">close</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Donec non lectus nec est porta eleifend. Morbi ut dictum augue, feugiat condimentum est. Pellentesque tincidunt justo nec aliquet tincidunt. Integer dapibus tellus non neque pulvinar mollis. Maecenas dictum laoreet diam, non
                    convallis lorem sagittis nec. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc venenatis lacus arcu, nec ultricies dui vehicula vitae.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row flex-row">
        @foreach ($admins as $admin)
        <div class="col-xl-4 col-md-6 col-remove">
            <!-- Begin Card -->
            <div class="widget-image has-shadow">
                <div class="contact-card-2">
                    <div class="cover-bg">
                        <img src="{{ asset('assets/img/cover/01.jpg') }}" class="img-fluid" alt="{{ $admin->name }}">
                    </div>
                    <!-- Begin Widget Body -->
                    <div class="widget-body">
                        <div class="quick-actions hover">
                            <div class="dropdown">
                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">
                                    <i class="la la-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" style="display: none;">
                                    <a href="#" class="dropdown-item remove">
                                        <i class="la la-trash"></i>Delete
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <i class="la la-edit"></i>Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="cover-image mx-auto">
                            <img src="@if ($admin->metadata['photo'] == null){{ asset('assets/img/avatar/avatar-01.jpg') }}@else{{ asset('images/profile') . '/' . $admin->metadata['photo'] }}@endif" alt="{{ $admin->name }}"
                            class="rounded-circle mx-auto">
                        </div>
                        <h4 class="name"><a href="#">{{ $admin->name }}</a></h4>
                        <div class="job">Admin</div>
                        <div class="social-friends owl-carousel mb-3 owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage" style="transform: translate3d(-425px, 0px, 0px); transition: all 0s ease 0s; width: 1278px;">
                                    <div class="owl-item" style="width: 212.906px;">
                                        <div class="item">
                                            <div class="stats">
                                                <div class="row d-flex justify-content-between">
                                                    <div class="col">
                                                        @php
                                                        $admin = User::find($admin->id);
                                                        $transactions = count($admin->transactions);
                                                        @endphp
                                                        <span class="counter">{{ $transactions }}</span>
                                                        <span class="text">Transactions</span>
                                                    </div>
                                                    <div class="col">
                                                        <span class="counter">52</span>
                                                        <span class="text">Photos</span>
                                                    </div>
                                                    <div class="col">
                                                        <span class="counter">997</span>
                                                        <span class="text">Videos</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 212.906px;">
                                        <div class="item">
                                            <div class="quick-about">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-12">
                                                        <h4>About</h4>
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ac orci in magna condimentum convallis.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-5 pb-3">
                            @if ($admin->email_verified_at != null)
                            <a href="#" class="btn btn-success mr-1 mb-2"><i class="la la-check"></i>Verified</a>
                            @else
                            <a href="#" class="btn btn-gradient-01 mr-1 mb-2"><i class="la la-ban"></i>Unverified</a>
                            @endif
                            <button type="button" class="btn btn-shadow mr-1 mb-2" data-target="#modal-centered" data-toggle="modal"><i class="la la-info-circle"></i>Details</button>
                        </div>
                    </div>
                    <!-- End Widget Body -->
                </div>
            </div>
            <!-- End Card -->
        </div>
        @endforeach
    </div>
    <div class="row flex-row">
        @foreach ($users as $user)
        <div class="col-xl-4 col-md-6 col-remove">
            <!-- Begin Card -->
            <div class="widget-image has-shadow">
                <div class="contact-card-2">
                    <div class="cover-bg">
                        <img src="{{ asset('assets/img/cover/01.jpg') }}" class="img-fluid" alt="{{ $user->name }}">
                    </div>
                    <!-- Begin Widget Body -->
                    <div class="widget-body">
                        <div class="quick-actions hover">
                            <div class="dropdown">
                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">
                                    <i class="la la-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" style="display: none;">
                                    <a href="#" class="dropdown-item remove">
                                        <i class="la la-trash"></i>Delete
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <i class="la la-edit"></i>Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="cover-image mx-auto">
                            <img src="@if ($user->metadata['photo'] == null){{ asset('assets/img/avatar/avatar-01.jpg') }}@else{{ asset('images/profile') . '/' . $user->metadata['photo'] }}@endif" alt="{{ $user->name }}"
                            class="rounded-circle mx-auto">
                        </div>
                        <h4 class="name"><a href="#">{{ $user->name }}</a></h4>
                        <div class="job">User</div>
                        <div class="social-friends owl-carousel mb-3 owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage" style="transform: translate3d(-425px, 0px, 0px); transition: all 0s ease 0s; width: 1278px;">
                                    <div class="owl-item" style="width: 212.906px;">
                                        <div class="item">
                                            <div class="stats">
                                                <div class="row d-flex justify-content-between">
                                                    <div class="col">
                                                        @php
                                                        $user = User::find($user->id);
                                                        $transactions = count($user->transactions);
                                                        @endphp
                                                        <span class="counter">{{ $transactions }}</span>
                                                        <span class="text">Transactions</span>
                                                    </div>
                                                    <div class="col">
                                                        <span class="counter">52</span>
                                                        <span class="text">Photos</span>
                                                    </div>
                                                    <div class="col">
                                                        <span class="counter">997</span>
                                                        <span class="text">Videos</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 212.906px;">
                                        <div class="item">
                                            <div class="quick-about">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-12">
                                                        <h4>About</h4>
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ac orci in magna condimentum convallis.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-5 pb-3">
                            @if ($user->email_verified_at != null)
                            <a href="#" class="btn btn-success mr-1 mb-2"><i class="la la-check"></i>Verified</a>
                            @else
                            <a href="#" class="btn btn-gradient-01 mr-1 mb-2"><i class="la la-ban"></i>Unverified</a>
                            @endif
                            <a href="app-chat.html" class="btn btn-shadow mr-1 mb-2"><i class="la la-info-circle"></i>Details</a> </div>
                    </div>
                    <!-- End Widget Body -->
                </div>
            </div>
            <!-- End Card -->
        </div>
        @endforeach
    </div>
    <div class="row flex-row">
        {{ $users->links('admin.elements.paginator') }}
    </div>
</div>
@endsection
