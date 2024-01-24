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

                            // Render the events on the calendar
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
