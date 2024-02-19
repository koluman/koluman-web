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
    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>

        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row gallery-wrapper">
                        @dump($shoowroomdetail);
                                @foreach ($shoowroomdetail as $galleryItem)
                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development"
                                        data-category="designing development">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ $galleryItem->car_img_url }}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ $galleryItem->car_img_url }}"
                                                        alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Glasses and laptop from above</h5>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="box-content">
                                                <div class="d-flex align-items-center mt-1">
                                                    <div class="flex-grow-1 text-muted">by <a href=""
                                                            class="text-body text-truncate">Ron Mackie</a></div>
                                                    <div class="flex-shrink-0">
                                                        <div class="d-flex gap-3">
                                                            <button type="button"
                                                                class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0 material-shadow-none">
                                                                <i
                                                                    class="ri-thumb-up-fill text-muted align-bottom me-1"></i>
                                                                2.2K
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0 material-shadow-none">
                                                                <i
                                                                    class="ri-question-answer-fill text-muted align-bottom me-1"></i>
                                                                1.3K
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Ekle</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-5">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Araba Kapak Resmi</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <p class="text-muted">Araba resişmleri ekleme formu.</p>

                            <div class="dropzone">
                                <div class="fallback">
                                    <input name="file" type="file">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                    </div>

                                    <h5>Resmi buraya yükleyiniz.</h5>
                                </div>
                            </div>

                            <ul class="list-unstyled mb-0" id="dropzone-preview3">
                                <li class="mt-2" id="dropzone-preview3-list">
                                    <div class="border rounded">
                                        <div class="d-flex p-2">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm bg-light rounded">
                                                    <img data-dz-thumbnail class="img-fluid rounded d-block" src="#"
                                                        alt="Product-Image" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="pt-1">
                                                    <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                    <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-3">
                                                <button data-dz-remove class="btn btn-sm btn-danger">Sil</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- end dropzon-preview -->
                        </div>
                    </div>
                </div>
                <!-- end card -->

            </div>
        </div>
        </div>
    </form>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/gallery.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/dropzone/dropzone3-min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/gallery-create.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
