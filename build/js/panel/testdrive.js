$(document).ready(function () {
    getshowroom();
});

function getshowroom() {
    $.ajax({
        url: 'https://mobiloby.app/koluman/web/getBasicToken',
        type: 'GET',
        success: function (response) {
            if (response.success == 1) {

                $.ajax({
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/getshoowroom',
                    headers: {
                        'Authorization': 'Basic ' + response.token
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                            for (i = 0; i < data.shoowroom.length; ++i) {
                                option += "<option value='" + data.shoowroom[i]["car_id"] + "'>" + data.shoowroom[i]["car_name"] + "</option>";
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

