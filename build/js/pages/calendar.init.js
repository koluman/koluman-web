var start_date = document.getElementById("appointment_date");
var date_range = null;
var T_check = null;
var csrfToken = $('meta[name="csrf-token"]').attr('content');
document.addEventListener("DOMContentLoaded", function () {
    testdrive();

    function testdrive() {
        //flatPickrInit();
        var addEvent = new bootstrap.Modal(document.getElementById('event-modal'), {
            keyboard: false
        });
        document.getElementById('event-modal');
        var modalTitle = document.getElementById('modal-title');
        var formEvent = document.getElementById('form-event');
        var selectedEvent = null;
        var forms = document.getElementsByClassName('needs-validation');
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var Draggable = FullCalendar.Draggable;
        var externalEventContainerEl = document.getElementById('external-events');
        var defaultEvents = [];
        var defaultlastEvents = [];
        $.ajax({
            url: 'https://mobiloby.app/koluman/web/getApiToken',
            type: 'GET',
            success: function (response) {
                if (response.success == 1) {
                    $.ajax({
                        type: 'GET',
                        url: 'https://mobiloby.app/koluman/web/testdrivegetall',
                        headers: {
                            'Authorization': 'Bearer ' + response.token
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.success == 1) {
                                var defaultEvents = data.testDrives.map(function (event) {
                                    return {
                                        id: event.appointment_id,
                                        title: event.appointment_time, // Yeni başlık
                                        start: new Date(event.appointment_date),
                                        end: new Date(event.appointment_date), // İsterseniz aynı tarih olarak bırakabilirsiniz
                                        allDay: true,
                                        className: event.state == 0 ? 'bg-danger-subtle' : ' bg-success-subtle',
                                        location: {
                                            car_id: event.car_id,
                                            car_name: event.car_name
                                        },
                                        extendedProps: {
                                            department: event.appointment_time
                                        },
                                        description: {
                                            user_id: event.user_id,
                                            user_name: event.user_name
                                        },
                                    };
                                });
                                var defaultlastEvents = data.testlastDrives.map(function (event) {
                                    return {
                                        id: event.appointment_id,
                                        title: event.appointment_time, // Yeni başlık
                                        start: new Date(event.appointment_date),
                                        end: new Date(event.appointment_date), // İsterseniz aynı tarih olarak bırakabilirsiniz
                                        allDay: true,
                                        className: event.state == 0 ? 'bg-danger-subtle' : ' bg-success-subtle',
                                        location: event.car_name,
                                        extendedProps: {
                                            department: event.appointment_time
                                        },
                                        description: event.user_name
                                        // Diğer özellikleri ekleyin
                                    };
                                });
                                new Draggable(externalEventContainerEl, {
                                    itemSelector: '.external-event',
                                    eventData: function (eventEl) {
                                        return {
                                            appointment_id: Math.floor(Math.random() * 11000),
                                            appointment_time: eventEl.innerText,
                                            appointment_date: new Date(),
                                            className: eventEl.getAttribute('data-class')
                                        };
                                    }
                                });
                                var calendarEl = document.getElementById('calendar');

                                function addNewEvent(info) {
                                    document.getElementById('form-event').reset();
                                    document.getElementById('btn-delete-event').setAttribute('hidden', true);
                                    addEvent.show();
                                    formEvent.classList.remove("was-validated");
                                    formEvent.reset();
                                    selectedEvent = null;
                                    modalTitle.innerText = 'Randevu Ekle';
                                    newEventData = info;
                                    document.getElementById("edit-event-btn").setAttribute("data-id", "new-event");
                                    document.getElementById('edit-event-btn').click();
                                    document.getElementById("edit-event-btn").setAttribute("hidden", true);
                                }

                                function getInitialView() {
                                    if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                                        return 'timeGridWeek';
                                    } else if (window.innerWidth <= 768) {
                                        return 'listMonth';
                                    } else {
                                        return 'dayGridMonth';
                                    }
                                }
                                var eventCategoryChoice4 = new Choices("#car_id", {
                                    searchEnabled: false
                                });
                                var eventCategoryChoice2 = new Choices("#user_id", {
                                    searchEnabled: false
                                });
                                var eventCategoryChoice3 = new Choices("#appointment_time", {
                                    searchEnabled: false
                                });
                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                    timeZone: 'local',
                                    editable: true,
                                    timeZone: 'Europe/Istanbul',
                                    locale: 'tr', // Bu satırı ekleyin
                                    droppable: true,
                                    selectable: true,
                                    navLinks: true,
                                    initialView: getInitialView(),
                                    themeSystem: 'bootstrap',
                                    headerToolbar: {
                                        left: 'prev,next today',
                                        center: 'title',
                                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                                    },
                                    windowResize: function (view) {
                                        var newView = getInitialView();
                                        calendar.changeView(newView);
                                    },
                                    eventResize: function (info) {
                                        var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                                            return x.id == info.event.id
                                        });
                                        if (defaultEvents[indexOfSelectedEvent]) {
                                            defaultEvents[indexOfSelectedEvent].title = info.event.title;
                                            defaultEvents[indexOfSelectedEvent].start = info.event.start;
                                            defaultEvents[indexOfSelectedEvent].allDay = info.event.allDay;
                                            defaultEvents[indexOfSelectedEvent].className = info.event.classNames[0];
                                            defaultEvents[indexOfSelectedEvent].description = (info.event._def.extendedProps.description.user_id) ? info.event._def.extendedProps.description.user_id : '';
                                            defaultEvents[indexOfSelectedEvent].location = (info.event._def.extendedProps.location.car_id) ? info.event._def.extendedProps.location.car_id : '';
                                        }
                                        upcomingEvent(defaultlastEvents);
                                    },
                                    eventClick: function (info) {
                                        document.getElementById("edit-event-btn").removeAttribute("hidden");
                                        document.getElementById('btn-save-event').setAttribute("hidden", true);
                                        document.getElementById("edit-event-btn").setAttribute("data-id", "edit-event");
                                        document.getElementById("edit-event-btn").innerHTML = "Güncelle";
                                        eventClicked();
                                        //flatPickrInit();
                                        flatpicekrValueClear();
                                        addEvent.show();
                                        formEvent.reset();
                                        selectedEvent = info.event;
                                        console.log(selectedEvent);
                                        // First Modal
                                        document.getElementById("modal-title").innerHTML = "";
                                        document.getElementById("event-location-tag").innerHTML = selectedEvent.extendedProps.location.car_name === undefined ? "No Location" : selectedEvent.extendedProps.location.car_name;
                                        document.getElementById("event-description-tag").innerHTML = selectedEvent.extendedProps.description.user_name === undefined ? "No Description" : selectedEvent.extendedProps.description.user_name;
                                        // Edit Modal
                                        //document.getElementById("event-location").value = selectedEvent.extendedProps.location === undefined ? "No Location" : selectedEvent.extendedProps.location;
                                        //document.getElementById("event-description").value = selectedEvent.extendedProps.description === undefined ? "No Description" : selectedEvent.extendedProps.description;
                                        document.getElementById("appointment_id").value = selectedEvent.id;
                                        if (selectedEvent._def.extendedProps.location) {
                                            eventCategoryChoice4.destroy();
                                            eventCategoryChoice4 = new Choices("#car_id", {
                                                searchEnabled: false
                                            });
                                            eventCategoryChoice4.setChoiceByValue([selectedEvent._def.extendedProps.location.car_id.toString()]);
                                        }

                                        if (selectedEvent._def.extendedProps.description) {
                                            eventCategoryChoice2.destroy();
                                            eventCategoryChoice2 = new Choices("#user_id", {
                                                searchEnabled: false
                                            });
                                            eventCategoryChoice2.setChoiceByValue(selectedEvent._def.extendedProps.description.user_id);
                                        }

                                        if (selectedEvent.title) {
                                            eventCategoryChoice3.destroy();
                                            eventCategoryChoice3 = new Choices("#appointment_time", {
                                                searchEnabled: false
                                            });
                                            eventCategoryChoice3.setChoiceByValue(selectedEvent.title);
                                        }

                                        var st_date = selectedEvent.start;
                                        var ed_date = selectedEvent.end;
                                        var date_r = function formatDate(date) {
                                            var d = new Date(date),
                                                month = '' + (d.getMonth() + 1),
                                                day = '' + d.getDate(),
                                                year = d.getFullYear();
                                            if (month.length < 2)
                                                month = '0' + month;
                                            if (day.length < 2)
                                                day = '0' + day;
                                            return [year, month, day].join('-');
                                        };
                                        var updateDay = null
                                        if (ed_date != null) {
                                            var endUpdateDay = new Date(ed_date);
                                            updateDay = endUpdateDay.setDate(endUpdateDay.getDate() - 1);
                                        }
                                        var r_date = ed_date == null ? (str_dt(st_date)) : (str_dt(st_date)) + ' to ' + (str_dt(updateDay));
                                        var er_date = ed_date == null ? (date_r(st_date)) : (date_r(st_date)) + ' to ' + (date_r(updateDay));
                                        flatpickr(start_date, {
                                            defaultDate: er_date,
                                            altInput: true,
                                            altFormat: "j F Y",
                                            dateFormat: "Y-m-d",
                                            mode: ed_date !== null ? "range" : "range",
                                        });
                                        document.getElementById("event-start-date-tag").innerHTML = r_date;
                                        newEventData = null;
                                        modalTitle.innerText = selectedEvent.title;
                                        // formEvent.classList.add("view-event");
                                        document.getElementById('btn-delete-event').removeAttribute('hidden');
                                    },
                                    dateClick: function (info) {
                                        addNewEvent(info);
                                    },
                                    events: defaultEvents,
                                    eventReceive: function (info) {
                                        var newid = parseInt(info.event.id);
                                        var newEvent = {
                                            id: newid,
                                            title: info.event.title,
                                            start: info.event.start,
                                            allDay: info.event.allDay,
                                            className: info.event.classNames[0]
                                        };
                                        defaultEvents.push(newEvent);
                                        upcomingEvent(defaultlastEvents);
                                    },
                                    eventDrop: function (info) {
                                        var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                                            return x.id == info.event.id
                                        });
                                        if (defaultEvents[indexOfSelectedEvent]) {
                                            defaultEvents[indexOfSelectedEvent].title = info.event.title;
                                            defaultEvents[indexOfSelectedEvent].start = info.event.start;
                                            defaultEvents[indexOfSelectedEvent].allDay = info.event.allDay;
                                            defaultEvents[indexOfSelectedEvent].className = info.event.classNames[0];
                                            defaultEvents[indexOfSelectedEvent].description = (info.event._def.extendedProps.description.user_id) ? info.event._def.extendedProps.description.user_id : '';
                                            defaultEvents[indexOfSelectedEvent].location = (info.event._def.extendedProps.location.car_id) ? info.event._def.extendedProps.location.car_id : '';
                                        }
                                        upcomingEvent(defaultlastEvents);
                                    }
                                });
                                calendar.render();
                                upcomingEvent(defaultlastEvents);
                                formEvent.addEventListener('submit', function (ev) {
                                    ev.preventDefault();
                                    var updatedCategory = 'bg-danger-subtle';
                                    var updatedCar = $("#car_id").val();
                                    var updatedAppointment = document.getElementById('appointment_time').value;
                                    var updatedUser = $("#user_id").val();
                                    var start_date = document.getElementById("appointment_date").value;
                                    var updateStartDate = new Date(start_date.trim());
                                    var appointment_id = document.getElementById("appointment_id").value;
                                    var all_day = false;
                                    if (start_date.length > 1) {
                                        start_date = new Date(start_date[0]);
                                        all_day = true;
                                    }
                                    if (forms[0].checkValidity() === false) {
                                        forms[0].classList.add('was-validated');
                                    } else {
                                        if (appointment_id) {
                                            $.ajax({
                                                type: 'POST',
                                                url: 'https://mobiloby.app/koluman/web/updatetestdriveappointment',
                                                data: {
                                                    car_id: $("#car_id").val(),
                                                    user_id: $("#user_id").val(),
                                                    appointment_time: $("#appointment_time").val(),
                                                    appointment_date: $("#appointment_date").val(),
                                                    _token: csrfToken,
                                                    appointment_id: appointment_id
                                                },
                                                dataType: 'json',
                                                success: function (data) {
                                                    if (data.success == 1) {
                                                        selectedEvent.setProp("id", appointment_id);
                                                        selectedEvent.setProp("title", updatedAppointment);
                                                        selectedEvent.setProp("classNames", [updatedCategory]);
                                                        selectedEvent.setStart(updateStartDate);
                                                        selectedEvent.setAllDay(all_day);
                                                        selectedEvent.setExtendedProp("description", updatedCar);
                                                        selectedEvent.setExtendedProp("location", updatedUser);
                                                        var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                                                            return x.appointment_id == selectedEvent.id
                                                        });
                                                        if (defaultEvents[indexOfSelectedEvent]) {
                                                            defaultEvents[indexOfSelectedEvent].title = updatedAppointment;
                                                            defaultEvents[indexOfSelectedEvent].start = updateStartDate;
                                                            defaultEvents[indexOfSelectedEvent].allDay = all_day;
                                                            defaultEvents[indexOfSelectedEvent].className = updatedCategory;
                                                            defaultEvents[indexOfSelectedEvent].description = updatedCar;
                                                            defaultEvents[indexOfSelectedEvent].location = updatedUser;
                                                        }
                                                        calendar.render();
                                                    } else {
                                                        alert(data.message);
                                                    }
                                                }
                                            });

                                        } else {

                                            $.ajax({
                                                type: 'POST',
                                                url: 'https://mobiloby.app/koluman/web/addtestdriveappointment',
                                                data: {
                                                    car_id: $("#car_id").val(),
                                                    user_id: $("#user_id").val(),
                                                    appointment_time: $("#appointment_time").val(),
                                                    appointment_date: $("#appointment_date").val(),
                                                    _token: csrfToken,
                                                },
                                                dataType: 'json',
                                                success: function (data) {
                                                    if (data.success == 1) {
                                                        var newEvent = {
                                                            id: data.sonuc,
                                                            title: updatedAppointment,
                                                            start: updateStartDate,
                                                            allDay: all_day,
                                                            className: updatedCategory,
                                                            description: updatedCar,
                                                            location: updatedUser
                                                        };
                                                        calendar.addEvent(newEvent);
                                                        defaultEvents.push(newEvent);
                                                    } else {
                                                        alert(data.message);
                                                    }
                                                }
                                            });
                                        }
                                        addEvent.hide();
                                        upcomingEvent(defaultEvents);
                                    }
                                });
                                document.getElementById("btn-delete-event").addEventListener("click", function (e) {
                                    if (selectedEvent) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'https://mobiloby.app/koluman/web/deletetestdriveappointment',
                                            data: {
                                                appointment_id: selectedEvent.id,
                                                _token: csrfToken,
                                            },
                                            dataType: 'json',
                                            success: function (data) {
                                                if (data.success == 1) {
                                                    selectedEvent.remove();
                                                    var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                                                        return x.appointment_id == selectedEvent.id;
                                                    });
                                                    if (indexOfSelectedEvent !== -1) {
                                                        defaultEvents.splice(indexOfSelectedEvent, 1);
                                                    }
                                                    upcomingEvent(defaultEvents);
                                                    addEvent.hide();
                                                } else {
                                                    alert(data.message);
                                                }
                                            },
                                            error: function (error) {
                                                console.error(error);
                                            }
                                        });
                                    }
                                });
                                document.getElementById("btn-new-event").addEventListener("click", function (e) {
                                    flatpicekrValueClear();
                                    addNewEvent();
                                    document.getElementById("edit-event-btn").setAttribute("data-id", "new-event");
                                    document.getElementById('edit-event-btn').click();
                                    document.getElementById("edit-event-btn").setAttribute("hidden", true);
                                });
                            }
                        }
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
});

function flatpicekrValueClear() {
    start_date.flatpickr().clear();
}

function eventClicked() {
    document.getElementById('form-event').classList.add("view-event");
    document.getElementById("car_id").classList.replace("d-block", "d-none");
    document.getElementById("user_id").classList.replace("d-block", "d-none");
    document.getElementById("appointment_time").classList.replace("d-block", "d-none")
    document.getElementById("appointment_date").parentNode.classList.add("d-none");
    document.getElementById("appointment_date").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-location-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-description-tag").classList.replace("d-none", "d-block");
    document.getElementById('btn-save-event').setAttribute("hidden", true);
}

function eventTyped() {
    document.getElementById('form-event').classList.remove("view-event");
    document.getElementById("car_id").classList.replace("d-none", "d-block");
    document.getElementById("user_id").classList.replace("d-none", "d-block");
    document.getElementById("appointment_time").classList.replace("d-none", "d-block");
    document.getElementById("appointment_date").parentNode.classList.remove("d-none");
    document.getElementById("appointment_date").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-location-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-description-tag").classList.replace("d-block", "d-none");
    document.getElementById('btn-save-event').removeAttribute("hidden");
}

function upcomingEvent(a) {
    document.getElementById("upcoming-event-list").innerHTML = null;
    Array.from(a).forEach(function (element) {
        var title = element.title;
        var startDate = element.start;
        if (startDate === "Invalid Date" || startDate === undefined) {
            startDate = null;
        } else {
            const newDate = new Date(startDate).toLocaleDateString('en', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
            startDate = new Date(newDate)
                .toLocaleDateString("tr-TR", {
                    day: "numeric",
                    month: "short",
                    year: "numeric",
                })
                .split(" ")
                .join(" ");
        }
        var category = (element.className).split("-");
        var description = (element.description) ? element.description : "";
        var e_time_s = tConvert(getTime(element.start));
        var ss = (element.state == 0) ? "Onaylanmadı" : "Onaylandı";
        if (e_time_s) {
            var e_time_s = "30 dakika";
        }
        u_event = "<div class='card mb-3'>\
                        <div class='card-body'>\
                            <div class='d-flex mb-3'>\
                                <div class='flex-grow-1'><i class='mdi mdi-checkbox-blank-circle me-2 text-" + category[1] + "'></i><span class='fw-medium'>" + startDate + " </span></div>\
                                <div class='flex-shrink-0'><small class='badge bg-primary-subtle text-primary ms-auto'>" + e_time_s + "</small></div>\
                            </div>\
                            <h6 class='card-title fs-16'> " + title + "</h6>\
                            <p class='text-muted text-truncate-two-lines mb-0'> " + description + "</p>\
                        </div>\
                    </div>";
        document.getElementById("upcoming-event-list").innerHTML += u_event;
    });
};

function getTime(params) {
    params = new Date(params);
    if (params.getHours() != null) {
        var hour = params.getHours();
        var minute = (params.getMinutes()) ? params.getMinutes() : 0;
        return hour + ":" + minute;
    }
}

function tConvert(time) {
    var t = time.split(":");
    var hours = t[0];
    var minutes = t[1];
    var newformat = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return (hours + ':' + minutes + ' ' + newformat);
}
var str_dt = function formatDate(date) {
    var monthNames = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
    var d = new Date(date),
        month = '' + monthNames[(d.getMonth())],
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [day + " " + month, year].join(',');
};

function editEvent(data) {
    var data_id = data.getAttribute("data-id");
    if (data_id == 'new-event') {
        document.getElementById('modal-title').innerHTML = "";
        document.getElementById('modal-title').innerHTML = "Randevu Ekle";
        document.getElementById("btn-save-event").innerHTML = "Randevu Ekle";
        eventTyped();
    } else if (data_id == 'edit-event') {
        data.innerHTML = "Kapat";
        data.setAttribute("data-id", 'cancel-event');
        document.getElementById("btn-save-event").innerHTML = "Randevu Güncelle";
        data.removeAttribute("hidden");
        eventTyped();
    } else {
        data.innerHTML = "Güncelle";
        data.setAttribute("data-id", 'edit-event');
        eventClicked();
    }
}
$("#appointment_date").change(function () {
    // Seçilen tarihi al
    var selectedDate = $(this).val();
    var selectedCar=$("#car_id").val();
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/testdriveschedules',
        data: {
            selectedDate:selectedDate,
            selectedCar,selectedCar,
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var options = "<option value='0'>Lütfen Randevu Süresini Seçiniz</option>";
                // Tüm saatleri döngüye al ve dolu olanları işaretle
                var allTimes = ["09:00", "09:30", "10:00", "10:30", "11:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

                for (var i = 0; i < allTimes.length; i++) {
                    var time = allTimes[i];
                    var isTimeOccupied = data.schedules.some(schedule => schedule.appointment_time === time);

                    if (isTimeOccupied) {
                        options += "<option value='" + time + "' disabled>" + time + " (Dolu)</option>";
                    } else {
                        options += "<option value='" + time + "'>" + time + "</option>";
                    }
                }
                console.log(options);
                $('#appointment_time').html('');
                $('#appointment_time').html(options);
                var appointmentTimeChoices = new Choices('#appointment_time', {});

            }

        }
    });
   
});