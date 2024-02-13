var start_date = document.getElementById("appointment_date");
var date_range = null;
var T_check = null;
var csrfToken = $('meta[name="csrf-token"]').attr('content');
var eventCategoryChoice5;
var eventCategoryChoice4;
var eventCategoryChoice2;
var company;
var step1;
var step2;
var csrfToken = $('meta[name="csrf-token"]').attr('content');

document.addEventListener("DOMContentLoaded", function () {
    eventCategoryChoice5 = new Choices("#appointment_time", {
        searchEnabled: false
    });
    eventCategoryChoice4 = new Choices("#car_id", {
        searchEnabled: false
    });
    eventCategoryChoice2 = new Choices("#user_id", {
        searchEnabled: false
    });
    company = new Choices("#company_id", {
        searchEnabled: false
    });
    step1 = new Choices("#step1", {
        searchEnabled: false
    });
    step2 = new Choices("#step2", {
        searchEnabled: false
    });

    testdrive();

    function testdrive() {
        flatPickrInit();
        yukle();
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
            type: 'GET',
            url: 'https://mobiloby.app/koluman/web/testdrivegetall',
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    var defaultEvents = data.testDrives.map(function (event) {
                        var className;

                        if (event.state === 0) {
                            className = 'bg-danger-subtle';
                        } else if (event.state === 1) {
                            className = 'bg-success-subtle';
                        } else {
                            className = 'bg-warning-subtle';
                        }
                        return {
                            id: event.appointment_id,
                            title: event.appointment_time, // Yeni başlık
                            start: new Date(event.appointment_date),
                            end: new Date(event.appointment_date), // İsterseniz aynı tarih olarak bırakabilirsiniz
                            allDay: true,
                            className: className,
                            location: {
                                car_id: event.car_id,
                                car_name: event.car_name,
                                appointment_date: event.appointment_date
                            },
                            extendedProps: {
                                department: event.appointment_time,
                                state: event.state,
                                company_id: event.company_id,
                                step1: event.step1,
                                step2: event.step2
                            },
                            description: {
                                user_id: event.user_id,
                                user_name: event.user_name
                            },
                        };
                    });
                    var defaultlastEvents = data.testlastDrives.map(function (event) {
                        var className;

                        if (event.state === 0) {
                            className = 'bg-danger-subtle';
                        } else if (event.state === 2) {
                            className = 'bg-success-subtle';
                        } else {
                            className = 'bg-warning-subtle';
                        }
                        return {
                            id: event.appointment_id,
                            title: event.appointment_time, // Yeni başlık
                            start: new Date(event.appointment_date),
                            end: new Date(event.appointment_date), // İsterseniz aynı tarih olarak bırakabilirsiniz
                            allDay: true,
                            className: className,
                            location: {
                                car_id: event.car_id,
                                car_name: event.car_name,
                                appointment_date: event.appointment_date
                            },
                            extendedProps: {
                                department: event.appointment_time,
                                state: event.state,
                                company_id: event.company_id,
                                step1: event.step1,
                                step2: event.step2
                            },
                            description: {
                                user_id: event.user_id,
                                user_name: event.user_name
                            },
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
                            flatPickrInit();
                            flatpicekrValueClear();
                            addEvent.show();
                            formEvent.reset();
                            selectedEvent = info.event;
                            console.log(selectedEvent);

                            document.getElementById("modal-title").innerHTML = "";
                            document.getElementById("event-location-tag").innerHTML = selectedEvent.extendedProps.location.car_name === undefined ? "No Location" : selectedEvent.extendedProps.location.car_name;
                            document.getElementById("event-description-tag").innerHTML = selectedEvent.extendedProps.description.user_name === undefined ? "No Description" : selectedEvent.extendedProps.description.user_name;
                            document.getElementById("appointment_id").value = selectedEvent.id;
                            document.getElementById("appointment_date").value = selectedEvent.extendedProps.location.appointment_date;
                            document.querySelector("#state").value = selectedEvent._def.extendedProps.state;
                            eventCategoryChoice2.setChoiceByValue(selectedEvent._def.extendedProps.description.user_id);
                            eventCategoryChoice5.setChoiceByValue(selectedEvent.title);
                            company.setChoiceByValue(selectedEvent._def.extendedProps.company_id);
                            step1.setChoiceByValue(selectedEvent._def.extendedProps.step1);
                            step2.setChoiceByValue(selectedEvent._def.extendedProps.step2);
                            eventCategoryChoice4.setChoiceByValue(selectedEvent._def.extendedProps.location.car_id);

                            /*var st_date = selectedEvent.start;
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
                            });*/
                            document.getElementById("event-start-date-tag").innerHTML = selectedEvent.extendedProps.location.appointment_date;
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
                        var updatedCar = $("#car_id").val();
                        var updatedCategory;
                        var updatedAppointment = document.getElementById('appointment_time').value;
                        var updatedState = document.getElementById('state').value;
                        if (updatedState == 0) {
                            updatedCategory = 'bg-danger-subtle';
                        } else if (updatedState == 1) {
                            updatedCategory = 'bg-success-subtle';
                        } else {
                            updatedCategory = 'bg-warning-subtle';
                        }
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
                                        state: $("#state").val(),
                                        _token: csrfToken,
                                        appointment_id: appointment_id
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        if (data.success == 1) {
                                            window.location.reload();
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
                                        state: $("#state").val(),
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
                                                description: {
                                                    user_id: updatedUser,
                                                    user_name: $("#user_id").text()
                                                },
                                                extendedProps: {
                                                    department: updatedAppointment,
                                                    state: updatedState
                                                },
                                                location: {
                                                    car_id: $("#car_id").val(),
                                                    car_name: $("#car_id").text()
                                                },
                                            };
                                            calendar.addEvent(newEvent);
                                            defaultlastEvents.push(newEvent);

                                            addEvent.hide();
                                            upcomingEvent(defaultlastEvents);
                                        } else {
                                            alert(data.message);
                                        }
                                    }
                                });
                            }
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
                                        var indexOfSelectedEvent = defaultlastEvents.findIndex(function (x) {
                                            return x.appointment_id == selectedEvent.id;
                                        });
                                        if (indexOfSelectedEvent !== -1) {
                                            defaultlastEvents.splice(indexOfSelectedEvent, 1);
                                        }
                                        upcomingEvent(defaultlastEvents);
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


    }

    function yukle() {
        var r = [];
        var choice = {
            value: "",
            label: "Lütfen Seçiniz",
        };
        r.push(choice);
        var allTimes = ["09:00", "09:30", "10:00", "10:30", "11:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];
        for (var i = 0; i < allTimes.length; i++) {
            time = allTimes[i];
            choice = {
                value: time,
                label: time,
            };
            r.push(choice);
        }
        eventCategoryChoice5.clearChoices(); // Clear existing choices
        eventCategoryChoice5.setChoices(r, 'value', 'label', true); // Set new choices
        let uniqueValues3 = []; // Array to store unique values
        let uniqueValues2 = []; // Array to store unique values
        let uniqueValues4 = []; // Array to store unique values

        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/getstepsall',
            data: {
                _token: csrfToken, // CSRF token'ını gönder
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    var tt = [];
                    var tt2 = [];
                    var tt3 = [];
                    var v = "";
                    var t = "Lütfen Seçiniz";
                    var v2 = "";
                    var t2 = "Lütfen Seçiniz";
                    var v3 = "";
                    var t3 = "Lütfen Seçiniz";
                    var choice = {
                        value: v,
                        label: t,
                    };
                    tt.push(choice);
                    var choice = {
                        value: v2,
                        label: t2,
                    };
                    tt2.push(choice);
                    var choice = {
                        value: v3,
                        label: t3,
                    };
                    tt3.push(choice);
                    for (var i = 0; i < data.getsteps.length; i++) {
                        v = data.getsteps[i]["step1"];
                        t = data.getsteps[i]["step1"];
                        v2 = data.getsteps[i]["step2"];
                        t2 = data.getsteps[i]["step2"];
                        v3 = data.getsteps[i]["car_id"];
                        t3 = data.getsteps[i]["step3"] + " - " + data.getsteps[i]["step4"] + " - " + data.getsteps[i]["step5"] + " - " + data.getsteps[i]["car_name"];
                        if (!uniqueValues2.includes(v)) {
                            choice = {
                                value: v,
                                label: t,
                            };
                            tt.push(choice);
                            uniqueValues2.push(v);
                        }
                        if (!uniqueValues3.includes(v2)) {
                            choice = {
                                value: v2,
                                label: t2,
                            };
                            tt2.push(choice);
                            uniqueValues3.push(v2);
                        }
                        if (!uniqueValues4.includes(v2)) {
                            choice = {
                                value: v3,
                                label: t3,
                            };
                            tt3.push(choice);
                            uniqueValues4.push(v3);
                        }
                    }
                    step1.clearChoices(); // Clear existing choices
                    step1.setChoices(tt, 'value', 'label', true); // Set new choices
                    step2.clearChoices(); // Clear existing choices
                    step2.setChoices(tt2, 'value', 'label', true); // Set new choices
                    eventCategoryChoice4.clearChoices(); // Clear existing choices
                    eventCategoryChoice4.setChoices(tt3, 'value', 'label', true); // Set new choices
                }
            }
        });
    }
    getapiusers();
    getcompany();
    $("#appointment_date").change(function () {
        getdate();
    });
    $("#company_id").change(function () {
        getstep();
    });
    $("#step1").change(function () {
        getstep1();
    });
    $("#step2").change(function () {
        getshowroom();
    });
});

function getdate() {
    // Seçilen tarihi al
    var selectedDate = $("#appointment_date").val();
    var selectedCar = $("#car_id").val();
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/testdriveschedules',
        data: {
            selectedDate: selectedDate,
            selectedCar,
            selectedCar,
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var choicesArray = [];
                var allTimes = ["09:00", "09:30", "10:00", "10:30", "11:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];
                for (var i = 0; i < allTimes.length; i++) {
                    var time = allTimes[i];
                    var isTimeOccupied = data.schedules.some(schedule => schedule.appointment_time === time);

                    var choice = {
                        value: time,
                        label: time,
                        disabled: isTimeOccupied
                    };

                    choicesArray.push(choice);
                }
                eventCategoryChoice5.clearChoices(); // Clear existing choices
                eventCategoryChoice5.setChoices(choicesArray, 'value', 'label', true); // Set new choices
            }

        }
    });
};

function getcompany() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getApiToken',
        dataType: 'json',
        success: function (data) {

            if (data.success == 1) {
                $.ajax({
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/getcompanies',
                    dataType: 'json',
                    headers: {
                        "Authorization": 'Bearer ' + data.token
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            var ch = [];
                            var v = "";
                            var t = "Lütfen Seçiniz";
                            var c = {
                                value: v,
                                label: t,
                            };
                            ch.push(c);
                            for (var i = 0; i < data.companies.length; i++) {
                                v = data.companies[i]["company_id"];
                                t = data.companies[i]["company_name"];

                                c = {
                                    value: v,
                                    label: t,
                                };
                                ch.push(c);
                            }
                            company.clearChoices(); // Clear existing choices
                            company.setChoices(ch, 'value', 'label', true); // Set new choices
                        }
                    }
                });
            }
        }
    });
}

function getapiusers() {
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getapiusers',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var choicesArray3 = [];
                var v = "";
                var t = "Lütfen Seçiniz";
                var choice = {
                    value: v,
                    label: t,
                };
                choicesArray3.push(choice);
                for (var i = 0; i < data.usersall.length; i++) {
                    v = data.usersall[i]["user_id"];
                    t = data.usersall[i]["user_name"];

                    choice = {
                        value: v,
                        label: t,
                    };
                    choicesArray3.push(choice);
                }
                eventCategoryChoice2.clearChoices(); // Clear existing choices
                eventCategoryChoice2.setChoices(choicesArray3, 'value', 'label', true); // Set new choices
            }

        }
    });

}
let steps = [];
let uniqueValues = []; // Array to store unique values
function getstep() {
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getsteps',
        data: {
            company_id: $("#company_id").val(),
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var tt = [];
                var v ="";
                var t = "Lütfen Seçiniz";
                var choice = {
                    value: v,
                    label: t,
                };
                tt.push(choice);
                steps = data.getsteps;
                for (var i = 0; i < steps.length; i++) {
                    v = steps[i]["step1"];
                    t = steps[i]["step1"];
                    if (!uniqueValues.includes(v)) {
                        choice = {
                            value: v,
                            label: t,
                        };
                        tt.push(choice);
                        uniqueValues.push(v);
                    }
                }
                step1.clearChoices(); // Clear existing choices
                step1.setChoices(tt, 'value', 'label', true); // Set new choices
            }

        }
    });
};

function getstep1() {
    var selectedStep1 = step1.getValue();
    var filteredSteps = steps.filter(item => item.step1 === selectedStep1.value);
    var uniqueStep2Values = [...new Set(filteredSteps.map(item => item.step2))];
    var step2Choices = uniqueStep2Values.map(value => {
        return {
            value: value,
            label: value,
        };
    });
    step2.clearChoices(); 
    var pleaseSelectOption = {
        value: "",
        label: "Lütfen Seçiniz",
    };
    step2Choices.unshift(pleaseSelectOption); 
    step2.setChoices(step2Choices, 'value', 'label', true); 
}

function getshowroom() {
    var step1 = document.getElementById('step1').value;
    var step2 = document.getElementById('step2').value;
    var filteredSteps = steps.filter(item => item.step1 === step1 && item.step2 === step2);

    console.log(steps);
    console.log(step1 + "--" + step2);

    var combinedChoices = filteredSteps.map(item => {
        var combinedLabel = `${item.step3 ? item.step3 + ' - ' : ''}${item.step4 ? item.step4 + ' - ' : ''}${item.step5 ? item.step5 : ''}${item.car_name}`;
        combinedLabel = combinedLabel.replace(/ -$/, '');
        return {
            value: item.car_id,
            label: combinedLabel,
        };
    });


    eventCategoryChoice4.clearChoices(); // Clear existing choices
    var pleaseSelectOption = {
        value: "",
        label: "Lütfen Seçiniz",
    };
    combinedChoices.unshift(pleaseSelectOption); 
    eventCategoryChoice4.setChoices(combinedChoices, 'value', 'label', true);
}
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
    a.sort(function (o1, o2) {
        return new Date(o2.start) - new Date(o1.start);
    });
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
                            <p class='text-muted text-truncate-two-lines mb-0'> " + description.user_name + "</p>\
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
        temizle();
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

function clearChoices(choicesInstance) {
    choicesInstance.clear();
}

function temizle() {
    document.getElementById("appointment_id").value = "";
    document.getElementById("appointment_date").value = "";
    document.querySelector("#state").value = "";
    eventCategoryChoice5.setChoiceByValue("");
    step1.setChoiceByValue("");
    step2.setChoiceByValue("");
    eventCategoryChoice4.setChoiceByValue("");
    eventCategoryChoice2.setChoiceByValue("");
    company.setChoiceByValue("");

}
