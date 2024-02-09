@extends('layouts.master')
@section('title')
    @lang('translation.sigortaname')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Sigorta
        @endslot
        @slot('title')
            Sigorta Talep Et
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Sigorta Listesi</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button type="button" class="btn btn-success add-btn" id="createsigorta"><i
                                        class="ri-add-line align-bottom me-1"></i> Sigorta Talep Et</button>
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-7 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Sigorta ara...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-4 col-sm-6">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="choices-single-default" id="idStatus">
                                        <option value="">Lütfen seçim yapınız</option>
                                        <option value="all" selected>Hepsi</option>
                                        <option value="1">Talep Oluştu</option>
                                        <option value="2">İncelemede</option>
                                        <option value="3">Teklif Oluştu</option>
                                        <option value="4">Aktif</option>
                                        <option value="5">İptal Edildi</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filtrele
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="#home1"
                                    role="tab" aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Hepsi<span id="0"
                                        class="badge bg-danger align-middle ms-1"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="Talep" href="#talep"
                                    role="tab" aria-selected="false">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Talepler<span id="1"
                                        class="badge bg-danger align-middle ms-1"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Pickups" data-bs-toggle="tab" id="İnceleme" href="#inceleme"
                                    role="tab" aria-selected="false">
                                    <i class="ri-truck-line me-1 align-bottom"></i> İncelemede <span id="2"
                                        class="badge bg-danger align-middle ms-1"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Returns" data-bs-toggle="tab" id="Teklif" href="#teklif"
                                    role="tab" aria-selected="false">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i>Teklifler <span id="3"
                                        class="badge bg-danger align-middle ms-1"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="Aktif" href="#aktif"
                                    role="tab" aria-selected="false">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Aktif<span id="4"
                                        class="badge bg-danger align-middle ms-1"></span>
                                </a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" id="İptal" href="#iptal"
                                    role="tab" aria-selected="false">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> iptal Edilenler<span
                                        id="5" class="badge bg-danger align-middle ms-1"></span>
                                </a>
                            </li>
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th scope="col" style="width: 25px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="id">No</th>
                                        <th class="sort" data-sort="user_name">Kullanıcı Adı</th>
                                        <th class="sort" data-sort="insurance_type">Sigorta Türü</th>
                                        <th class="sort" data-sort="insurance_price">Fiyat</th>
                                        <th class="sort" data-sort="insurance_description">Açıklama</th>
                                        <th class="sort" data-sort="insurance_state">Durum</th>
                                        <th class="sort" data-sort="action">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="sigortalist">

                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Malesef! Listelenecek veri bulunamadı</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Geri
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    ileri
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/js/panel/sigorta.js') }}"></script>
@endsection
