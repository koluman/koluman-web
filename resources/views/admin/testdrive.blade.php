@extends('layouts.master')
@section('title')
    @lang('translation.calendar')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Test Sürüş İşlemleri
        @endslot
        @slot('title')
            Test Sürüş Listesi
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <button class="btn btn-primary w-100" id="btn-new-event"><i class="mdi mdi-plus"></i> Test Sürüş
                                Ranvusu Oluştur</button>

                            <div id="external-events">
                                <br>
                                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                <div class="external-event fc-event bg-success-subtle text-success"
                                    data-class="bg-success-subtle">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Onaylanan Randevular
                                </div>

                                <div class="external-event fc-event bg-danger-subtle text-danger"
                                    data-class="bg-danger-subtle">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Onaylanmayan Randevular
                                </div>
                            </div>

                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1">Yaklaşan Randevular</h5>
                        <p class="text-muted">Son bir haftadaki randevu listesi burada listelenmektedir.</p>
                        <div class="pe-2 me-n1 mb-3" data-simplebar style="height: 400px">
                            <div id="upcoming-event-list"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body bg-info-subtle">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i data-feather="calendar" class="text-info icon-dual-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-15">Hoşgeldiniz!</h6>
                                    <p class="text-muted mb-0">Tüm test sürüş işlemlerini etkili bir biçimde
                                        tamamlayabilirsiniz.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div> <!-- end col-->

                <div class="col-xl-9">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <!--end row-->

            <div style='clear:both'></div>

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="modal-title">Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="text-end">
                                    <a href="#" class="btn btn-sm btn-soft-primary" id="edit-event-btn"
                                        data-id="edit-event" onclick="editEvent(this)" role="button">Edit</a>
                                </div>
                                <div class="event-details">
                                    <div class="d-flex mb-2">
                                        <div class="flex-grow-1 d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="ri-calendar-event-line text-muted fs-16"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="d-block fw-semibold mb-0" id="event-start-date-tag"></h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-time-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="d-block fw-semibold mb-0"><span id="event-timepicker1-tag"></span> -
                                                <span id="event-timepicker2-tag"></span></h6>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-map-pin-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="d-block fw-semibold mb-0"> <span id="event-location-tag"></span></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-discuss-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block text-muted mb-0" id="event-description-tag"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row event-form">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Kullanıcılar</label>
                                            <select class="form-select d-none" name="user_id" id="user_id" required>
                                            </select>
                                            <div class="invalid-feedback">Lütfen Kullanıcıyı Seçiniz</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Arabalar</label>
                                            <select class="form-select d-none" name="car_id" id="car_id" required>
                                            </select>
                                            <div class="invalid-feedback">Lütfen Araba Modelini Seçiniz</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Randevu Zamanı</label>
                                            <select class="form-select d-none" name="appointment_time" id="appointment_time" required>
                                                <option value="">Lütfen Randevu Süresini Seçiniz</option>
                                                <option value="09:00">09:00</option>
                                                <option value="09:30">09:30</option>
                                                <option value="10:00">10:00</option>
                                                <option value="10:30">10:30</option>
                                                <option value="11:00">11:30</option>
                                                <option value="13:00">13:00</option>
                                                <option value="13:30">13:30</option>
                                                <option value="14:00">14:00</option>
                                                <option value="14:30">14:30</option>
                                                <option value="15:00">15:00</option>
                                                <option value="15:30">15:30</option>
                                                <option value="16:00">16:00</option>
                                                <option value="16:30">16:30</option>
                                                <option value="17:00">17:00</option>
                                            </select>
                                            <div class="invalid-feedback">Lütfen Randevu Süresini Seçiniz</div>
                                        </div>
                                    </div>
                                 
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label>Randevu Tarihi</label>
                                            <div class="input-group d-none">
                                                <input type="text" id="appointment_date" name="appointment_date"
                                                    class="form-control flatpickr flatpickr-input"
                                                    placeholder="Lütfen Randevu Tarihini Seçiniz" readonly required>
                                                <span class="input-group-text"><i
                                                        class="ri-calendar-event-line"></i></span>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <input type="hidden" id="eventid" name="eventid" value="" />
                                  
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-soft-danger" id="btn-delete-event"><i
                                            class="ri-close-line align-bottom"></i> Delete</button>
                                    <button type="submit" class="btn btn-success" id="btn-save-event">Add Event</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div> <!-- end modal-->
            <!-- end modal-->
        </div>
    </div> <!-- end row-->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ URL::asset('build/libs/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/calendar.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/js/panel/testdrive.js') }}"></script>
@endsection
