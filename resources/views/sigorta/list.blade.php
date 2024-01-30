@extends('layouts.master')
@section('title')
    @lang('translation.orders')
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
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal"><i
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
                                        <option value="talep">Talep Oluştu</option>
                                        <option value="inceleme">İncelemede</option>
                                        <option value="teklif">Teklif Oluştu</option>
                                        <option value="aktif">Aktif</option>
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
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Hepsi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="Talep" href="#talep"
                                    role="tab" aria-selected="false">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Talepler
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Pickups" data-bs-toggle="tab" id="İnceleme" href="#inceleme"
                                    role="tab" aria-selected="false">
                                    <i class="ri-truck-line me-1 align-bottom"></i> İncelemede <span
                                        class="badge bg-danger align-middle ms-1">2</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Returns" data-bs-toggle="tab" id="Teklif" href="#teklif"
                                    role="tab" aria-selected="false">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i>Teklifler
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="Aktif" href="#aktif"
                                    role="tab" aria-selected="false">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Aktif
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
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Kullanıcı Ekle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="userid" name="userid" />
                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Kullanıcı Adsoyad</label>
                                            <input type="text" id="username" name="username" class="form-control"
                                                placeholder="Adsoyad" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Kullanıcı E-posta</label>
                                            <input type="text" id="usermail" name="usermail" class="form-control"
                                                placeholder="E-posta" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Kullanıcı Telefon</label>
                                            <input type="text" id="userphone" name="userphone" class="form-control"
                                                placeholder="Telefon" required />
                                        </div>

                                        <div class="mb-3">
                                            <label for="productname-field" class="form-label">Kullanıcı Yetki</label>
                                            <select class="form-control" data-trigger id="userrole" name="userrole"
                                                required>
                                                <option value="">Lütfen seçim yapınız</option>
                                                <option value="all" selected>Hepsi</option>
                                                <option value="talep">Talep Oluştu</option>
                                                <option value="inceleme">İncelemede</option>
                                                <option value="teklif">Teklif Oluştu</option>
                                                <option value="aktif">Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Kapat</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Ekle</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>Bu kullanıcıyı silmek istediğinize emin misiniz?</h4>
                                        <p class="text-muted fs-15 mb-4">Kullanıcıyı sildiğiniz taktirde geri bu
                                            kullanıcıyı getiremezsiniz.</p>
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
                    <!--end modal -->
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
