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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <input class="form-control" name="announcement_id" id="announcement_id" type="hidden" required>
                            <input class="form-control" name="announcement_description" id="announcement_description"
                                type="hidden" required>

                            <div class="col-lg-6 mb-3">
                                <label for="choices-publish-visibility-input" class="form-label">Başlık</label>
                                <input class="form-control" name="announcement_title" id="announcement_title" type="text"
                                    required>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="choices-publish-status-input" class="form-label">Tür</label>

                                <select class="form-select" name="announcement_state" id="announcement_state" data-choices
                                    data-choices-search-false>
                                    <option value="0" selected>Lütfen Seçiniz</option>
                                    <option value="1">Duyuru</option>
                                    <option value="2">Haber</option>
                                    <option value="3">Kampanya</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label>Açıklama</label>
                            <div id="ckeditor-classic" name="ckeditor-classic">
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Resim</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <p class="text-muted" id="shid">Resim ekleme formu.</p>

                            <div class="dropzone" id="shdiv">
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

                            <ul class="list-unstyled mb-0" id="dropzone-preview4">
                                <li class="mt-2" id="dropzone-preview4-list">
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

                <div class="text-end mb-4">
                    <button type="button" id="deleteallbutton" data-bs-toggle="modal" href="#deleteAll"
                        class="btn btn-danger w-sm">Sil</button>
                    <button type="button" id="addcar" class="btn btn-success w-sm">Ekle</button>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
    </form>

    <div class="modal fade flip" id="deleteAll" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <div class="mt-4 text-center">
                        <h4>Arabayı silmek istediğinize emin misiniz?</h4>
                        <p class="text-muted fs-15 mb-4">Bu arabayı sildiğiniz taktirde işlemleri geri
                            getiremezsiniz.</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"
                                id="deleteRecord-close"><i class="ri-close-line me-1 align-middle"></i>
                                Kapat</button>
                            <button class="btn btn-danger" id="delete-record">Eminim, Sil</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('build/libs/dropzone/dropzone4-min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/showroomprocess.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
