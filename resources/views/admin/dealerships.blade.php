@extends('layouts.master')
@section('title')
    @lang('translation.companies')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Şubeler
        @endslot
        @slot('title')
            Şube Listesi
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <button class="btn btn-info add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                    class="ri-add-fill me-1 align-bottom"></i> Şube Ekle</button>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="hstack text-nowrap gap-2">
                                <button class="btn btn-soft-danger material-shadow-none" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card" id="companyList">
                <div class="card-header">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Şube ara...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="name" scope="col">Şube Adı</th>
                                        <th class="sort" data-sort="owner" scope="col">Şehir</th>
                                        <th class="sort" data-sort="industry_type" scope="col">Lat</th>
                                        <th class="sort" data-sort="star_value" scope="col">Long</th>
                                        <th class="sort" data-sort="location" scope="col">Telefon Numarası</th>
                                        <th scope="col">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child"
                                                    value="option1">
                                            </div>
                                        </th>
                                        <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                class="fw-medium link-primary">#VZ001</a></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src=""
                                                        alt=""
                                                        class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                </div>
                                                <div class="flex-grow-1 ms-2 name">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="owner"></td>
                                        <td class="industry_type"></td>
                                        <td><span class="star_value"></span></td>
                                        <td class="location"></td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Görüntüle">
                                                    <a href="javascript:void(0);" class="view-item-btn"><i
                                                            class="ri-eye-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Güncelle">
                                                    <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><i
                                                            class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Sil">
                                                    <a class="remove-item-btn" data-bs-toggle="modal"
                                                        href="#deleteRecordModal">
                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Üzgünüz! Arama sonucu bulunamadı</h5>
                                    <p class="text-muted mb-0">Tüm şubeler içerisinde aradık,
                                        fakat hiçbir şey bulamadık</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Geri
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    İleri
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-info-subtle p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <div class="position-absolute bottom-0 end-0">
                                                            <label for="company-logo-input" class="mb-0"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Resim Seç">
                                                                <div class="avatar-xs cursor-pointer">
                                                                    <div
                                                                        class="avatar-title bg-light border rounded-circle text-muted">
                                                                        <i class="ri-image-fill"></i>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <input class="form-control d-none" value=""
                                                                id="company-logo-input" type="file"
                                                                accept="image/png, image/gif, image/jpeg">
                                                        </div>
                                                        <div class="avatar-lg p-1">
                                                            <div class="avatar-title bg-light rounded-circle">
                                                                <img src="{{ URL::asset('build/images/users/multi-user.jpg') }}"
                                                                    alt="" id="companylogo-img"  name="companylogo-img"
                                                                    class="avatar-md rounded-circle object-fit-cover">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-13 mt-3">Şube Resmi</h5>
                                                </div>
                                                <div>
                                                    <label for="companyname-field" class="form-label">Şube Adı</label>
                                                    <input type="text" id="companyname-field" name="companyname-field" class="form-control"
                                                        placeholder="Şube Adı" required />
                                                </div>
                                            </div>
                                        
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="website-field" class="form-label">Firma</label>
                                                    <select class="form-select" id="website-field" name="website-field">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="owner-field" class="form-label">Şehir</label>
                                                    <select class="form-select" id="owner-field" name="owner-field">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="location-field" class="form-label">Telefon</label>
                                                    <input type="text" id="location-field" name="location-field" class="form-control"
                                                        placeholder="Telefon numarası" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="star_value-field" class="form-label">Long</label>
                                                    <input type="text" id="star_value-field"  name="star_value-field" class="form-control"
                                                        placeholder="Long bilgisini giriniz" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="industry_type-field" class="form-label">Lat</label>
                                                    <input type="text" id="industry_type-field" name="industry_type-field" class="form-control"
                                                        placeholder="Lat bilgisiniz giriniz" required />
                                                </div>
                                            </div>
                                         
                                            
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="employee-field" class="form-label">Açıklama</label>
                                                    <textarea type="text" id="employee-field" name="employee-field" class="form-control"
                                                        placeholder="Açıklama yazınız" required row="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="contact_email-field" class="form-label">Adres</label>
                                                    <textarea type="text" id="contact_email-field" name="contact_email-field"  class="form-control"
                                                        placeholder="Adres giriniz" required row="3"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Kapat</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Ekle</button>
                                            {{-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end add modal-->

                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                        aria-labelledby="deleteRecordLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="btn-close deleteRecord-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">Emin misin?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Şubeyi sildiğiniz takdirde geriye alınmaz.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none material-shadow-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Kapat</button>
                                            <button class="btn btn-danger" id="delete-record">Evet,
                                                Sil!!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-3">
            <div class="card" id="company-view-detail">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block">
                        <div class="avatar-md">
                            <div class="avatar-title bg-light rounded-circle material-shadow">
                                <img src="" alt=""
                                    class="avatar-sm rounded-circle object-fit-cover">
                            </div>
                        </div>
                    </div>
                    <h5 class="mt-3 mb-1"></h5>
                    <p class="text-muted"></p>

                    {{--<ul class="list-inline mb-0">
                        <li class="list-inline-item avatar-xs">
                            <a href="javascript:void(0);"
                                class="avatar-title bg-success-subtle text-success fs-15 rounded">
                                <i class="ri-global-line"></i>
                            </a>
                        </li>
                        <li class="list-inline-item avatar-xs">
                            <a href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                <i class="ri-mail-line"></i>
                            </a>
                        </li>
                        <li class="list-inline-item avatar-xs">
                            <a href="javascript:void(0);"
                                class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                <i class="ri-question-answer-line"></i>
                            </a>
                        </li>
                    </ul>--}}
                </div>
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Şube Detayı</h6>
                    <p class="text-muted mb-4"></p>
                    <div class="table-responsive table-card">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-medium" scope="row">Telefon</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Long</td>
                                    <td> <i class="ri-star-fill text-warning align-bottom"></i></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Lat</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Firma</td>
                                    <td>
                                        <a href="javascript:void(0);"
                                            class="link-primary text-decoration-underline"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium" scope="row">Adres</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/panel/companies.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
