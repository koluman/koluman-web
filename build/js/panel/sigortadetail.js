$(document).ready(function () {
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
                $("#insurance_review_date").val(data.sigortaid.insurance_review_date);
                $("#insurance_result_date").val(data.sigortaid.insurance_result_date);
                $("#insurance_request_date").val(data.sigortaid.insurance_request_date);
                $("#insurance_price").val(data.sigortaid.insurance_price);
                $("#insurance_description").text(data.sigortaid.insurance_description);

            }

        }
    });
}