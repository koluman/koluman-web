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
                $.ajax({
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/testdriveget',
                    headers: {
                        'Authorization': 'Bearer ' + response.token
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        /*if (data.success == 1) {
                            userdata = data.usersall;
                            let son = orderslist(userdata);
                            $("#userlist").html('');
                            $("#userlist").html(son);
                        }*/

                    }
                });
            }
            else{
                alert(response.message);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });

}
