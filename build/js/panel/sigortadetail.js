$(document).ready(function () {
    getapiusers();
    var id = getIdFromUrl();
    getdetail(id);
});

var csrfToken = $('meta[name="csrf-token"]').attr('content');
function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/sigortadetail\/(\d+)/);

    if (match && match[1]) {
        return parseInt(match[1], 10);
    } else {
        return null;
    }
}
function getapiusers() {
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
function getdetail(id){
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getbyIdSigorta',
        dataType: 'json',
        data: {
            id:id,
            _token: csrfToken, // CSRF token'ını gönder
        },
        success: function (data) {
            if (data.success == 1) {
                let a=data.sigortaid[0];
                $("#insurance_review_date").val(a.insurance_review_date);
                $("#insurance_result_date").val(a.insurance_result_date);
                $("#insurance_request_date").val(a.insurance_request_date);
                $("#insurance_price").val(a.insurance_price);
                $("#insurance_description").text(a.insurance_description);
                $("#insurance_end_date").val(a.insurance_end_date);

            }

        }
    });
}