@extends('layouts.admin')

@section('title', 'Groups')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.theme.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/js/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/friends.min.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row flex-row">
        <div class="col-xl-4 col-md-6 col-remove">
            <!-- Begin Card -->
            <div class="widget-image has-shadow">
                <div class="group-card">
                    <!-- Begin Widget Body -->
                    <div class="widget-body">
                        <div class="quick-actions">
                            <div class="dropdown">
                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">
                                    <i class="la la-circle-o-notch"></i>
                                </button>
                                <div class="dropdown-menu">
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
                            <img src="assets/img/group/01.jpg" alt="..." class="rounded-circle mx-auto">
                        </div>
                        <h4 class="name"><a href="#">Elisyam Community</a></h4>
                        <div class="category">UI Design</div>
                        <div class="stats text-center">
                            <span><i class="la la-users"></i></span>
                            <span class="counter">8,456</span>
                            <span class="text">Members</span>
                        </div>
                        <div class="group-members text-center mt-4">
                            <a href="javascript:void(0);">
                                <img src="assets/img/avatar/avatar-02.jpg" class="img-fluid rounded-circle" alt="...">
                            </a>
                            <a href="javascript:void(0);">
                                <img src="assets/img/avatar/avatar-04.jpg" class="img-fluid rounded-circle" alt="...">
                            </a>
                            <a href="javascript:void(0);">
                                <img src="assets/img/avatar/avatar-06.jpg" class="img-fluid rounded-circle" alt="...">
                            </a>
                            <a href="javascript:void(0);">
                                <img src="assets/img/avatar/avatar-07.jpg" class="img-fluid rounded-circle" alt="...">
                            </a>
                            <a href="javascript:void(0);">
                                <img src="assets/img/avatar/avatar-05.jpg" class="img-fluid rounded-circle" alt="...">
                            </a>
                        </div>
                        <div class="text-center mt-5 pb-3">
                            <a href="javascript:void(0);" class="btn btn-secondary ripple">Leave Group</a>
                        </div>
                    </div>
                    <!-- End Widget Body -->
                </div>
            </div> <!-- End Card -->
        </div>
    </div>
    <div class="row flex-row">
        <div class="col d-flex align-items-center">
            <div class="mr-auto p-2">
                <span class="display-items">Showing 1-15 / 257 Contacts</span>
            </div>
            <div class="p-2">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item">
                            <span class="page-link"><i class="ion-chevron-left"></i></span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                            <span class="page-link">2<span class="sr-only">(current)</span></span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="ion-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
