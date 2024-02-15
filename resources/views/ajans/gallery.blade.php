@extends('layouts.master')
@section('title')
    @lang('translation.gallery')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Gallery
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="card-body px-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <ul class="list-inline categories-filter animation-nav" id="filter">
                                    <li class="list-inline-item"><a class="categories active" data-filter="*">All</a></li>
                                    <li class="list-inline-item"><a class="categories" data-filter=".project">Project</a></li>
                                    <li class="list-inline-item"><a class="categories" data-filter=".designing">Designing</a></li>
                                    <li class="list-inline-item"><a class="categories" data-filter=".photography">Photography</a></li>
                                    <li class="list-inline-item"><a class="categories" data-filter=".development">Development</a></li>
                                </ul>
                            </div>

                            <div class="row gallery-wrapper">
                                <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" data-category="designing development">
                                    <div class="gallery-box card">
                                        <div class="gallery-container">
                                            <a class="image-popup" href="{{ URL::asset('build/images/small/img-1.jpg') }}" title="">
                                                <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt="" />
                                                <div class="gallery-overlay">
                                                    <h5 class="overlay-caption">Glasses and laptop from above</h5>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="box-content">
                                            <div class="d-flex align-items-center mt-1">
                                                <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Ron Mackie</a></div>
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex gap-3">
                                                        <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0 material-shadow-none">
                                                            <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 2.2K
                                                        </button>
                                                        <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0 material-shadow-none">
                                                            <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3K
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="text-center mt-2 mb-4">
                                <a href="javascript:void(0);" class="text-success material-shadow-none"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load More </a>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- ene card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/gallery.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
