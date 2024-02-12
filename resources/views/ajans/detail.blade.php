@extends('layouts.master')
@section('title') @lang('translation.create-product') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Ecommerce @endslot
@slot('title') Shoowroom @endslot
@endcomponent

<form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
    <div class="row">
        <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Kategori</label>
                                <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                <input type="text" class="form-control d-none" id="product-id-input">
                                <input type="text" class="form-control" id="product-title-input" value="" placeholder="Enter product title" required>
                                <div class="invalid-feedback">Please Enter a product title.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Araba Adı</label>
                                <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                <input type="text" class="form-control d-none" id="product-id-input">
                                <input type="text" class="form-control" id="product-title-input" value="" placeholder="Enter product title" required>
                                <div class="invalid-feedback">Please Enter a product title.</div>
                            </div>
                            
                        </div>
                        <div>
                            <label>Araba  Açıklama</label>
                            <div id="ckeditor-classic">
                                <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton. Material composition is 100% organic cotton. This is one of the world’s leading designer lifestyle brands and is internationally recognized for celebrating the essence of classic American cool style, featuring preppy with a twist designs.</p>
                                <ul>
                                    <li>Full Sleeve</li>
                                    <li>Cotton</li>
                                    <li>All Sizes available</li>
                                    <li>4 Different Color</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Araba Resimleri</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <h5 class="fs-14 mb-1">Product Gallery</h5>
                            <p class="text-muted">Add Product Gallery Images.</p>

                            <div class="dropzone">
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple">
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
                                                    <img data-dz-thumbnail class="img-fluid rounded d-block" src="#" alt="Product-Image" />
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
                                                <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
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
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
        </div>
        <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Publish</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-publish-status-input" class="form-label">Status</label>

                        <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                            <option value="Published" selected>Published</option>
                            <option value="Scheduled">Scheduled</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>

                    <div>
                        <label for="choices-publish-visibility-input" class="form-label">Visibility</label>
                        <select class="form-select" id="choices-publish-visibility-input" data-choices data-choices-search-false>
                            <option value="Public" selected>Public</option>
                            <option value="Hidden">Hidden</option>
                        </select>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
      
        </div>
    </div>
    <!-- end row -->
</form>


@endsection
@section('script')
<script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

<script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

