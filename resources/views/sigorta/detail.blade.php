@extends('layouts.master')
@section('title')
    @lang('translation.create-project')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Project
        @endslot
        @slot('title')
            Create Project
        @endslot
    @endcomponent

    <div class="row">

        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3 mb-lg-0">
                                <label for="choices-status-input" class="form-label">Poliçe Fiyat</label>
                                <input type="text" class="form-control" id="insurance_price" name="insurance_price">
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="insurance_id" name="insurance_id">
                        <div class="col-lg-6 mb-3">
                            <div>
                                <label for="datepicker-deadline-input" class="form-label">Poliçe Bitiş Tarih</label>
                                <input type="text" class="form-control" id="insurance_end_date" name="insurance_end_date"
                                    data-provider="flatpickr">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Sigorta Açıklama</label>
                            <textarea class="form-control" name="insurance_description" id="insurance_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3 mb-lg-0">
                                <label for="choices-priority-input" class="form-label">Talep Tarihi</label>
                                <input type="text" class="form-control" id="insurance_request_date"
                                    name="insurance_request_date" data-provider="flatpickr">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3 mb-lg-0">
                                <label for="choices-status-input" class="form-label">İnceleme Tarihi</label>
                                <input type="text" class="form-control" id="insurance_review_date"
                                    name="insurance_review_date" data-provider="flatpickr">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label for="datepicker-deadline-input" class="form-label">Sonuç Tarihi</label>
                                <input type="text" class="form-control" id="insurance_result_date"
                                    name="insurance_result_date" data-provider="flatpickr">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Poliçe PDf</h5>
                </div>
                <div class="card-body">
                    <div>
                        <p class="text-muted" id="polid">Poliçe Pdf Ekle.</p>

                        <div class="dropzone" id="poldiv">
                            <div class="fallback">
                                <input name="file" type="file" id="insurance_policy_url" name="insurance_policy_url">
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>

                                <h5>Drop files here or click to upload.</h5>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
                                <!-- This is used as the file preview template -->
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-sm bg-light rounded">
                                                <img src="https://mobiloby.app/koluman/web/upload/pdf.png"
                                                    alt="Project-Image" data-dz-thumbnail
                                                    class="img-fluid rounded d-block" />
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
                <button type="button" id="newbutton" class="btn btn-success w-sm">Ekle</button>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Durum</h5>
                </div>
                <div class="card-body">
                    <div>
                        <label for="choices-privacy-status-input" class="form-label">Durum</label>
                        <select class="form-select" id="insurance_state" name="insurance_state">
                            <option value="0">Lütfen Seçim Yapınız</option>
                            <option value="1">Talep Oluştu</option>
                            <option value="2">İncelemede</option>
                            <option value="3">Teklif Oluştu</option>
                            <option value="4">Aktif</option>
                        </select>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Kullanıcılar</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-lead-input" class="form-label">Kullanıcı Listesi</label>
                        <select class="form-select" id="insurance_type" name="insurance_type">
                            <option value="0">Lütfen Seçim Yapınız</option>
                            <option value="Kasko">Kasko</option>
                            <option value="Trafik Sigortası">Trafik Sigortası</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                </div>
                <!-- end card body -->
            </div>


            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Kullanıcılar</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-lead-input" class="form-label">Kullanıcı Listesi</label>
                        <select class="form-select" id="user_id" name="user_id">
                            <option value="0">Lütfen Seçim Yapınız</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->user_id }}">{{ $u->user_name . ' (' . $u->user_phone . ')' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- end card body -->
            </div>

            <div class="text-end mb-4">
                <button type="button" id="updinc" class="btn btn-info w-sm">İncelemeye Al</button>
                <button type="button" id="updsnc" class="btn btn-secondary w-sm">Sonuçlandır</button>
            </div>
            <!-- end card -->
        </div>
    </div>

    <!-- end row -->
    <div class="modal fade flip" id="deleteAll" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <div class="mt-4 text-center">
                        <h4>Sigorta talebini silmek istediğinize emin misiniz?</h4>
                        <p class="text-muted fs-15 mb-4">Bu talebi sildiğiniz taktirde işlemleri geri
                            getiremezsiniz.</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                data-bs-dismiss="modal" id="deleteRecord-close"><i
                                    class="ri-close-line me-1 align-middle"></i>
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
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/project-create.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/js/panel/sigortadetail.js') }}"></script>
@endsection
