$(document).ready(function () {
    testdrive();
});
function testdrive() {
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
