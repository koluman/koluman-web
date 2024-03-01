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
                                            <option value="2">Duyuru</option>
                                            <option value="3">Kampanya</option>
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


@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
    <script src="https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js"></script>
    <script src="{{ URL::asset('build/js/panel/announcements.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
