$(document).ready(function () {
    testdrive();
});
let testdrivedata = [];
let csrfToken = $('meta[name="csrf-token"]').attr('content');

function testdrive() {
    $.ajax({
        url: 'https://example.com/web/getApiToken',
        type: 'GET',
        success: function(response) {
            
            console.log(response);
        },
        error: function(error) {
            console.error(error);
        }
    });
    /*$.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/api/testdrivegetcar',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        headers: {
        'Authorization': 'Bearer ' + token
    },
        dataType: 'json',
        success: function (data) {
            if(data.success==1){
                userdata = data.usersall;
                let son = orderslist(userdata);
                $("#userlist").html('');
                $("#userlist").html(son);
            }
         
        }
    });*/
}
