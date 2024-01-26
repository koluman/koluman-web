document.addEventListener("DOMContentLoaded", function () {
    getshowroom();
    getusers();
});
getallusers

function getshowroom() {
    $.ajax({
        url: 'https://mobiloby.app/koluman/web/getBasicToken',
        type: 'GET',
        success: function (response) {
            if (response.success == 1) {
                $.ajax({
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/getshowroomcars',
                    headers: {
                        'Authorization': 'Basic ' + response.token
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                            for (i = 0; i < data.showroomcars.length; ++i) {
                                option += "<option value='" + data.showroomcars[i]["car_id"] + "'>" + data.showroomcars[i]["car_name"] + "</option>";
                            }
                            $('#event-category').html(option);
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

function getshowroom() {

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getallusers',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
               console.log(data);
            }

        }
    });

}
