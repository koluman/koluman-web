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
                $("#user_id").val(a.user_id);
                if (a.insurance_policy_url) {
                    $("#polid").text("Police PDF");
                    document.querySelector("#poldiv").style.display = "none";

                    // Dropzone'nun programatik olarak dosya eklenmiş gibi davranması için
                    var mockFile = {
                        name: "PDF", // PDF dosya adı
                        size: 12345 // PDF dosya boyutu (değiştirebilirsiniz)
                    };

                    // Dropzone'a dosyanın eklenmiş gibi işlemesi için mockFile'ı ekleyin
                    dropzone.emit("addedfile", mockFile);
                    dropzone.emit("thumbnail", mockFile, ""); // Varsa bir önizleme görseli ekleyin
                    dropzone.emit("complete", mockFile); // Dosyanın yükleme tamamlandı olarak işaretle

                    // Dropzone önizleme listesini güncelleyin
                    dropzone.files.push(mockFile);

                    // Dropzone'un içindeki tüm dosyaları temizle
                    dropzone.removeAllFiles();

                }

            }

        }
    });
}
