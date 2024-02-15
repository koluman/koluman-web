@extends('layouts.master')
@section('title')
    @lang('translation.create-product')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Shoowroom İşlemleri
        @endslot
        @slot('title')
            Shoowroom Detay
        @endslot
    @endcomponent

    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="col-6">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="company_id" id="company_id" required>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Araba Adı</label>
                                <input type="text" class="form-control" name="car_name" id="car_name" required>
                            </div>

                        </div>
                        <div>
                            <label>Araba Açıklama</label>
                            <div id="ckeditor-classic">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

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

                            <ul class="list-unstyled mb-0" id="dropzone-preview">
                                <li class="mt-2" id="dropzone-preview-list">
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

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Ekle</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detay</h5>
                    </div>
                    <div class="card-body">
                        <div class="live-preview">
                            <div>
                                <p class="text-muted">Açıklama yazılabilir</p>
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                aria-label="Text input with dropdown button">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Seçiniz</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                aria-label="Text input with dropdown button">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Seçiniz</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                aria-label="Text input with dropdown button">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Seçiniz</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                aria-label="Text input with dropdown button">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Seçiniz</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                aria-label="Text input with dropdown button">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Seçiniz</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Test Sürüş Arabası</h4>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="input-group-custom-showcode" class="form-label text-muted"></label>
                                <input class="form-check-input code-switcher" type="checkbox"
                                    id="input-group-custom-showcode">
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
            </div>
        </div>
        <!-- end row -->
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/showroomprocess.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
