$(document).ready(function () {
    getshowroom();
});

function getshowroom() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/api/getshoowroom',
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
}
