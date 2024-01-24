$(document).ready(function () {
    testdrive();
});
let testdrivedata = [];
let csrfToken = $('meta[name="csrf-token"]').attr('content');

function testdrive() {
    $.ajax({
        url: 'https://mobiloby.app/koluman/web/getApiToken',
        type: 'GET',
        success: function (response) {
            if (response.success == 1) {
                console.log(response.token);

                $.ajax({
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/testdriveget',
                    headers: {
                        'Authorization': 'Bearer ' + response.token
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            var calendarEl = document.getElementById('calendar');

                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                timeZone: 'local',
                                editable: true,
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
                                    var indexOfSelectedEvent = data.testDrives.findIndex(function (x) {
                                        return x.drive_id == info.event.drive_id
                                    });
                                    if (data.testDrives[indexOfSelectedEvent]) {
                                        data.testDrives[indexOfSelectedEvent].drive_time = info.event.drive_time;
                                        data.testDrives[indexOfSelectedEvent].car_id = info.event.car_id;
                                        data.testDrives[indexOfSelectedEvent].user_id = info.event.user_id;
                                        data.testDrives[indexOfSelectedEvent].className = 'bg-primary-subtle';
                                    }
                                    upcomingEvent(data.testDrives);
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
                                events: data.testDrives,
                                eventReceive: function (info) {
                                    var newid = parseInt(info.event.id);
                                    var newEvent = {
                                        id: newid,
                                        title: info.event.title,
                                        start: info.event.start,
                                        allDay: info.event.allDay,
                                        className: info.event.classNames[0]
                                    };
                                    data.testDrives.push(newEvent);
                                    upcomingEvent(data.testDrives);
                                },
                                eventDrop: function (info) {
                                    var indexOfSelectedEvent = data.testDrives.findIndex(function (x) {
                                        return x.drive_id == info.event.drive_id
                                    });
                                    if (data.testDrives[indexOfSelectedEvent]) {
                                        data.testDrives[indexOfSelectedEvent].drive_time = info.event.drive_time;
                                        data.testDrives[indexOfSelectedEvent].car_id = info.event.car_id;
                                        data.testDrives[indexOfSelectedEvent].user_id = info.event.user_id;
                                        data.testDrives[indexOfSelectedEvent].className = 'bg-primary-subtle';
                                    }
                                    upcomingEvent(data.testDrives);
                                }
                            });

                            calendar.render();

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

function getInitialView() {
    if (window.innerWidth >= 768 && window.innerWidth < 1200) {
        return 'timeGridWeek';
    } else if (window.innerWidth <= 768) {
        return 'listMonth';
    } else {
        return 'dayGridMonth';
    }
}
