@extends('layouts.master')
@section('title')
    @lang('translation.announcement')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/gridjs/theme/mermaid.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Duyurular
        @endslot
        @slot('title')
            Duyurular
        @endslot
    @endcomponent
    <div class="row">


        <div class="col-xl-12 col-lg-12">
            <div>
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row g-4">
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{ route('announcementsdetail') }}" class="btn btn-success"
                                        id="addproduct-btn"><i
                                            class="ri-add-line align-bottom me-1"></i>Duyuru/Haber/Kampanya Ekle</a>
                                </div>
                            </div>
                    <div class="row g-3">
                                <div class="col-xxl-7 col-sm-6">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control" id="searchProductList"
                                            placeholder="Ara...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-sm-6">
                                    <div>
                                        <select class="form-control" data-choices data-choices-search-false
                                            name="choices-single-default" id="idStatus">
                                            <option value="">Lütfen seçim yapınız</option>
                                            <option value="all" selected>Hepsi</option>
                                            <option value="1">Haber</option>
                                            <option value="2">Kampanya</option>
                                            <option value="3">Sigorta</option>
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
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <div class="row align-items-center">

                            <div class="col-auto">
                                <div id="selection-element">
                                    <div class="my-n1 d-flex align-items-center text-muted">
                                        Select <div id="select-content" class="text-body fw-semibold px-1"></div> Result
                                        <button type="button"
                                            class="btn btn-link link-danger p-0 ms-3 material-shadow-none"
                                            data-bs-toggle="modal" data-bs-target="#removeItemModal">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">

                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="productnav-all" role="tabpanel">
                                <div id="table-product-list-all" class="table-card gridjs-border-none"></div>
                            </div>
                            <!-- end tab pane -->

                        </div>
                        <!-- end tab content -->

                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


    <!-- removeItemModal -->
    <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Product ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger " id="delete-product">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
    <script src="https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js"></script>
    <script src="{{ URL::asset('build/js/pages/announcements.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
