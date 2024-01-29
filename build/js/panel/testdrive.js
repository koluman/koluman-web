document.addEventListener("DOMContentLoaded", function () {
    getshowroom();
    getapiusers();
});


function getshowroom() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getshowroomcars',
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                for (i = 0; i < data.showroomcars.length; ++i) {
                    option += "<option value='" + data.showroomcars[i]["car_id"] + "'>" + data.showroomcars[i]["car_name"] + "</option>";

                }
                $('#car_id').html('');
                $('#car_id').html(option);
            }
        }
    });


}
$("#appointment_date").change(function () {
    // Seçilen tarihi al
    var selectedDate = $(this).val();
    console.log(selectedDate);
   
});
/*
<option value="0">Lütfen Randevu Süresini Seçiniz</option>
<option value="09:00">09:00</option>
<option value="09:30">09:30</option>
<option value="10:00">10:00</option>
<option value="10:30">10:30</option>
<option value="11:00">11:30</option>
<option value="13:00">13:00</option>
<option value="13:30">13:30</option>
<option value="14:00">14:00</option>
<option value="14:30">14:30</option>
<option value="15:00">15:00</option>
<option value="15:30">15:30</option>
<option value="16:00">16:00</option>
<option value="16:30">16:30</option>
<option value="17:00">17:00</option>*/
function getapiusers() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getapiusers',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                for (i = 0; i < data.usersall.length; ++i) {
                    option += "<option value='" + data.usersall[i]["user_id"] + "'>" + data.usersall[i]["user_name"] + "</option>";
                }
                $('#user_id').html('');
                $('#user_id').html(option);
            }

        }
    });

}
