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

                            // Initialize the FullCalendar instance
                            calendar = new FullCalendar.Calendar(calendarEl, {
                                // Your FullCalendar configuration options...
                                // (Note: I removed the specific options for brevity)
                            });

                            // Clear existing events before adding new ones
                            calendar.getEventSources().forEach(function (source) {
                                source.remove();
                            });

                            // Add events from the response
                            data.testDrives.forEach(function (testDrive) {
                                calendar.addEvent({
                                    id: testDrive.drive_id,
                                    title: 'Test Drive',
                                    start: testDrive.auto_date,
                                    allDay: false, // Assuming the drive_time includes time information
                                    className: 'test-drive-event',
                                    description: 'Test Drive for Car ID ' + testDrive.car_id
                                });
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

function getInitialView() {
    if (window.innerWidth >= 768 && window.innerWidth < 1200) {
        return 'timeGridWeek';
    } else if (window.innerWidth <= 768) {
        return 'listMonth';
    } else {
        return 'dayGridMonth';
    }
}
