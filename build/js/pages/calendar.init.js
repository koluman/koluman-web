/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Calendar init js
*/


var start_date = document.getElementById("event-start-date");
var timepicker1 = document.getElementById("timepicker1");
var timepicker2 = document.getElementById("timepicker2");
var date_range = null;
var T_check = null;
document.addEventListener("DOMContentLoaded", function () {

    testdrive();

    function testdrive() {
        flatPickrInit();
        var addEvent = new bootstrap.Modal(document.getElementById('event-modal'), {
            keyboard: false
        });
        document.getElementById('event-modal');
        var modalTitle = document.getElementById('modal-title');
        var formEvent = document.getElementById('form-event');
        var selectedEvent = null;
        var forms = document.getElementsByClassName('needs-validation');
        /* initialize the calendar */

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var Draggable = FullCalendar.Draggable;
        var externalEventContainerEl = document.getElementById('external-events');
        var defaultEvents = [];
        $.ajax({
            url: 'https://mobiloby.app/koluman/web/getApiToken',
            type: 'GET',
            success: function (response) {
                if (response.success == 1) {

                    $.ajax({
                        type: 'GET',
                        url: 'https://mobiloby.app/koluman/web/api/testdriveget',
                        headers: {
                            'Authorization': 'Bearer ' + response.token
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.success == 1) {
                                defaultEvents = data.testDrives;

                                new Draggable(externalEventContainerEl, {
                                    itemSelector: '.external-event',
                                    eventData: function (eventEl) {
                                        return {
                                            id: Math.floor(Math.random() * 11000),
                                            title: eventEl.innerText,
                                            allDay: true,
                                            start: new Date(),
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
                                    modalTitle.innerText = 'Add Event';
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
                                        return 'Ay';
                                    }
                                }
                        
                                var eventCategoryChoice = new Choices("#event-category", {
                                    searchEnabled: false
                                });
                        
                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                    timeZone: 'local',
                                    editable: true,
                                    locale: 'tr', // Bu satırı ekleyin
                                    droppable: true,
                                    selectable: true,
                                    navLinks: true,
                                    initialView: getInitialView(),
                                    themeSystem: 'bootstrap',
                                    headerToolbar: {
                                        left: 'prev,next today',
                                        center: 'title',
                                        right: 'Ay,timeGridWeek,timeGridDay,listMonth'
                                    },
                                    windowResize: function (view) {
                                        var newView = getInitialView();
                                        calendar.changeView(newView);
                                    },
                                    eventResize: function (info) {
                                        var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                                            console.log(x);
                                            return x.drive_id == info.event.id;
                                        });
                                    
                                        if (indexOfSelectedEvent !== -1) {
                                            defaultEvents[indexOfSelectedEvent].drive_time = info.event.title;
                                            defaultEvents[indexOfSelectedEvent].auto_date = info.event.start;
                                            defaultEvents[indexOfSelectedEvent].className = "bg-info-subtle";
                                        }
                                        upcomingEvent(defaultEvents);
                                    },
                                    eventClick: function (info) {
                                        document.getElementById("edit-event-btn").removeAttribute("hidden");
                                        document.getElementById('btn-save-event').setAttribute("hidden", true);
                                        document.getElementById("edit-event-btn").setAttribute("data-id", "edit-event");
                                        document.getElementById("edit-event-btn").innerHTML = "Edit";
                                        eventClicked();
                                        flatPickrInit();
                                        flatpicekrValueClear();
                                        addEvent.show();
                                        formEvent.reset();
                                        selectedEvent = info.event;
                        
                                        // First Modal
                                        document.getElementById("modal-title").innerHTML = "";
                                        document.getElementById("event-location-tag").innerHTML = selectedEvent.extendedProps.location === undefined ? "No Location" : selectedEvent.extendedProps.location;
                                        document.getElementById("event-description-tag").innerHTML = selectedEvent.extendedProps.description === undefined ? "No Description" : selectedEvent.extendedProps.description;
                        
                                        // Edit Modal
                                        document.getElementById("event-title").value = selectedEvent.title;
                                        document.getElementById("event-location").value = selectedEvent.extendedProps.location === undefined ? "No Location" : selectedEvent.extendedProps.location;
                                        document.getElementById("event-description").value = selectedEvent.extendedProps.description === undefined ? "No Description" : selectedEvent.extendedProps.description;
                                        document.getElementById("eventid").value = selectedEvent.id;
                        
                                        if (selectedEvent.classNames[0]) {
                                            eventCategoryChoice.destroy();
                                            eventCategoryChoice = new Choices("#event-category", {
                                                searchEnabled: false
                                            });
                                            eventCategoryChoice.setChoiceByValue(selectedEvent.classNames[0]);
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
                                            onChange: function (selectedDates, dateStr, instance) {
                                                var date_range = dateStr;
                                                var dates = date_range.split("to");
                                                if (dates.length > 1) {
                                                    document.getElementById('event-time').setAttribute("hidden", true);
                                                } else {
                                                    document.getElementById("timepicker1").parentNode.classList.remove("d-none");
                                                    document.getElementById("timepicker1").classList.replace("d-none", "d-block");
                                                    document.getElementById("timepicker2").parentNode.classList.remove("d-none");
                                                    document.getElementById("timepicker2").classList.replace("d-none", "d-block");
                                                    document.getElementById('event-time').removeAttribute("hidden");
                                                }
                                            },
                                        });
                                        document.getElementById("event-start-date-tag").innerHTML = r_date;
                        
                                        var gt_time = getTime(selectedEvent.start);
                                        var ed_time = getTime(selectedEvent.end);
                        
                                        if (gt_time == ed_time) {
                                            document.getElementById('event-time').setAttribute("hidden", true);
                                            flatpickr(document.getElementById("timepicker1"), {
                                                enableTime: true,
                                                noCalendar: true,
                                                dateFormat: "H:i",
                                            });
                                            flatpickr(document.getElementById("timepicker2"), {
                                                enableTime: true,
                                                noCalendar: true,
                                                dateFormat: "H:i",
                                            });
                                        } else {
                                            document.getElementById('event-time').removeAttribute("hidden");
                                            flatpickr(document.getElementById("timepicker1"), {
                                                enableTime: true,
                                                noCalendar: true,
                                                dateFormat: "H:i",
                                                defaultDate: gt_time
                                            });
                        
                                            flatpickr(document.getElementById("timepicker2"), {
                                                enableTime: true,
                                                noCalendar: true,
                                                dateFormat: "H:i",
                                                defaultDate: ed_time
                                            });
                                            document.getElementById("event-timepicker1-tag").innerHTML = tConvert(gt_time);
                                            document.getElementById("event-timepicker2-tag").innerHTML = tConvert(ed_time);
                                        }
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
                                        upcomingEvent(defaultEvents);
                                    },
                                    eventDrop: function (info) {
                                        var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                                            return x.drive_id == info.event.id;
                                        });
                                    
                                        if (indexOfSelectedEvent !== -1) {
                                            defaultEvents[indexOfSelectedEvent].drive_time = info.event.title;
                                            defaultEvents[indexOfSelectedEvent].auto_date = info.event.start;
                                            defaultEvents[indexOfSelectedEvent].className = "bg-info-subtle";
                                        }
                                        upcomingEvent(defaultEvents);
                                    }
                                });
                        
                                calendar.render();
                        
                                upcomingEvent(defaultEvents);
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

        // init draggable
       
    }

});


function flatPickrInit() {
    var config = {
        enableTime: true,
        noCalendar: true,
    };
    var date_range = flatpickr(
        start_date, {
            enableTime: false,
            mode: "range",
            minDate: "today",
            onChange: function (selectedDates, dateStr, instance) {
                var date_range = dateStr;
                var dates = date_range.split("to");
                if (dates.length > 1) {
                    document.getElementById('event-time').setAttribute("hidden", true);
                } else {
                    document.getElementById("timepicker1").parentNode.classList.remove("d-none");
                    document.getElementById("timepicker1").classList.replace("d-none", "d-block");
                    document.getElementById("timepicker2").parentNode.classList.remove("d-none");
                    document.getElementById("timepicker2").classList.replace("d-none", "d-block");
                    document.getElementById('event-time').removeAttribute("hidden");
                }
            },
        });
    flatpickr(timepicker1, config);
    flatpickr(timepicker2, config);

}

function flatpicekrValueClear() {
    start_date.flatpickr().clear();
    timepicker1.flatpickr().clear();
    timepicker2.flatpickr().clear();
}


function eventClicked() {
    document.getElementById('form-event').classList.add("view-event");
    document.getElementById("event-title").classList.replace("d-block", "d-none");
    document.getElementById("event-category").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date").parentNode.classList.add("d-none");
    document.getElementById("event-start-date").classList.replace("d-block", "d-none");
    document.getElementById('event-time').setAttribute("hidden", true);
    document.getElementById("timepicker1").parentNode.classList.add("d-none");
    document.getElementById("timepicker1").classList.replace("d-block", "d-none");
    document.getElementById("timepicker2").parentNode.classList.add("d-none");
    document.getElementById("timepicker2").classList.replace("d-block", "d-none");
    document.getElementById("event-location").classList.replace("d-block", "d-none");
    document.getElementById("event-description").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-timepicker1-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-timepicker2-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-location-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-description-tag").classList.replace("d-none", "d-block");
    document.getElementById('btn-save-event').setAttribute("hidden", true);
}

function editEvent(data) {
    var data_id = data.getAttribute("data-id");
    if (data_id == 'new-event') {
        document.getElementById('modal-title').innerHTML = "";
        document.getElementById('modal-title').innerHTML = "Add Event";
        document.getElementById("btn-save-event").innerHTML = "Add Event";
        eventTyped();
    } else if (data_id == 'edit-event') {
        data.innerHTML = "Cancel";
        data.setAttribute("data-id", 'cancel-event');
        document.getElementById("btn-save-event").innerHTML = "Update Event";
        data.removeAttribute("hidden");
        eventTyped();
    } else {
        data.innerHTML = "Edit";
        data.setAttribute("data-id", 'edit-event');
        eventClicked();
    }
}
function eventTyped() {
    document.getElementById('form-event').classList.remove("view-event");
    document.getElementById("event-title").classList.replace("d-none", "d-block");
    document.getElementById("event-category").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date").parentNode.classList.remove("d-none");
    document.getElementById("event-start-date").classList.replace("d-none", "d-block");
    document.getElementById("timepicker1").parentNode.classList.remove("d-none");
    document.getElementById("timepicker1").classList.replace("d-none", "d-block");
    document.getElementById("timepicker2").parentNode.classList.remove("d-none");
    document.getElementById("timepicker2").classList.replace("d-none", "d-block");
    document.getElementById("event-location").classList.replace("d-none", "d-block");
    document.getElementById("event-description").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-timepicker1-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-timepicker2-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-location-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-description-tag").classList.replace("d-block", "d-none");
    document.getElementById('btn-save-event').removeAttribute("hidden");
}

// upcoming Event
function upcomingEvent(a) {
    a.sort(function (o1, o2) {
        return (new Date(o1.start)) - (new Date(o2.start));
    });
    document.getElementById("upcoming-event-list").innerHTML = null;
    Array.from(a).forEach(function (element) {
        var title = element.drive_time;
        if (element.auto_date) {
            endUpdatedDay = new Date(element.auto_date);
            var updatedDay = endUpdatedDay.setDate(endUpdatedDay.getDate() - 1);
        }
        var e_dt = updatedDay ? updatedDay : undefined;
        if (e_dt == "Invalid Date" || e_dt == undefined) {
            e_dt = null;
        } else {
            const newDate = new Date(e_dt).toLocaleDateString('tr', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
            e_dt = new Date(newDate)
                .toLocaleDateString("tr-TR", {
                    day: "numeric",
                    month: "short",
                    year: "numeric",
                })
                .split(" ")
                .join(" ");
        }
        var st_date = element.auto_date ? str_dt(element.auto_date) : null;
        var ed_date = updatedDay ? str_dt(updatedDay) : null;
        if (st_date === ed_date) {
            e_dt = null;
        }
        var startDate = element.auto_date;
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
        var s="bg-info-subtle";
       // var end_dt = (e_dt) ? " to " + e_dt : '';
        var category = (s).split("-");
        var description =  "Deneme";
        var e_time_s = tConvert(getTime(element.auto_date));
        var e_time_e = tConvert(getTime(updatedDay));
        if (e_time_s == e_time_e) {
            var e_time_s = "30 dakika";
            var e_time_e = null;
        }
        var e_time_e = (e_time_e) ? " to " + e_time_e : "";

        u_event = "<div class='card mb-3'>\
                        <div class='card-body'>\
                            <div class='d-flex mb-3'>\
                                <div class='flex-grow-1'><i class='mdi mdi-checkbox-blank-circle me-2 text-" + category[1] + "'></i><span class='fw-medium'>" + startDate+ " </span></div>\
                                <div class='flex-shrink-0'><small class='badge bg-primary-subtle text-primary ms-auto'>" + e_time_s + e_time_e + "</small></div>\
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
