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

function getdetail(id) {
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getbyIdSigorta',
        dataType: 'json',
        data: {
            id: id,
            _token: csrfToken, // CSRF token'ını gönder
        },
        success: function (data) {
            if (data.success == 1) {
                let a = data.sigortaid[0];
                $("#insurance_review_date").val(a.insurance_review_date);
                $("#insurance_result_date").val(a.insurance_result_date);
                $("#insurance_request_date").val(a.insurance_request_date);
                $("#insurance_price").val(a.insurance_price);
                $("#insurance_description").text(a.insurance_description);
                $("#insurance_end_date").val(a.insurance_end_date);
                $("#insurance_state").val(a.insurance_state);
                $("#insurance_id").val(a.insurance_id);
                $("#user_id").val(a.user_id);
                if (a.insurance_review_date != "") {
                    $("#updinc").val(a.insurance_review_date);
                    $("#updinc").text("İncelendi");

                }
                if (a.insurance_policy_url) {
                    let pdfFileName = getFileNameFromUrl(a.insurance_policy_url);
                    $("#polid").text(pdfFileName);
                    document.querySelector("#poldiv").style.display = "none";
                    var mockFile = {
                        name: pdfFileName,
                    };
                    dropzone.emit("addedfile", mockFile);
                    var pdfIconPath = "https://mobiloby.app/koluman/web/upload/pdf.png";
                    dropzone.emit("thumbnail", mockFile, pdfIconPath);
                    dropzone.emit("complete", mockFile);
                    dropzone.files.push(mockFile);
                } else {
                    dropzone.removeAllFiles();
                }
            }
        }
    });
}

function getFileNameFromUrl(url) {
    let parts = url.split('/');
    return parts[parts.length - 1];
}
document.getElementById("delete-record").addEventListener("click", function () {
    let id = $("#insurance_id").val();
    if (id) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/deletesigorta',
            data: {
                insurance_id: id,
                _token: csrfToken,
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.success == 1) {
                    window.location.href = "https://mobiloby.app/koluman/web/sigortalist";
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                alert("AJAX request failed:", status, error);
            }
        });
    }
});
