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
                           console.log(data);
                           var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                           for (i = 0; i < data.shoowroom.length; ++i) {
                               option += "<option value='" + data.shoowroom[i]["car_id"] + "'>" + data.shoowroom[i]["car_id"] + "</option>";
                           }
                           $('#event-category').html('');
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

function getInitialView() {
    if (window.innerWidth >= 768 && window.innerWidth < 1200) {
        return 'timeGridWeek';
    } else if (window.innerWidth <= 768) {
        return 'listMonth';
    } else {
        return 'dayGridMonth';
    }
}
