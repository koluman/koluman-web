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
                let a=data.sigortaid[0];
                $("#insurance_review_date").val(a.insurance_review_date);
                $("#insurance_result_date").val(a.insurance_result_date);
                $("#insurance_request_date").val(a.insurance_request_date);
                $("#insurance_price").val(a.insurance_price);
                $("#insurance_description").text(a.insurance_description);
                $("#insurance_end_date").val(a.insurance_end_date);
                
                if (a.user_id) {
                    user_id.destroy();
                    user_id = new Choices("#user_id", {
                        searchEnabled: false
                    });
                    user_id.setChoiceByValue([a.user_id.toString()]);
                }
                $("#insurance_state option:selected").val(a.insurance_state);

            }

        }
    });
}