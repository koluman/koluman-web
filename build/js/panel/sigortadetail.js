$(document).ready(function () {
    var id = getIdFromUrl();
    if(id!="") getdetail(id);
    else add();
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
                $("#insurance_price").val(a.insurance_price);
                $("#insurance_description").text(a.insurance_description);
                $("#insurance_state").val(a.insurance_state);
                $("#insurance_id").val(a.insurance_id);
                $("#user_id").val(a.user_id);
                $("#newbutton").text("Güncelle");
                if (a.insurance_end_date != "0000-00-00 00:00:00" && a.insurance_end_date != ""){
                    $("#insurance_end_date").val(a.insurance_end_date);
                }
                if (a.insurance_request_date != "0000-00-00 00:00:00" && a.insurance_request_date != ""){
                    $("#insurance_request_date").val(a.insurance_request_date);
                    document.querySelector("#insurance_request_date").disabled = true;
                }
                if (a.insurance_review_date != "0000-00-00 00:00:00" && a.insurance_review_date != ""){
                    $("#insurance_review_date").val(a.insurance_review_date);
                    document.querySelector("#insurance_review_date").disabled = true;

                }
                if (a.insurance_result_date != "0000-00-00 00:00:00" && a.insurance_result_date != ""){
                    $("#insurance_result_date").val(a.insurance_result_date);
                    document.querySelector("#insurance_result_date").disabled = true;
                }
                if (a.insurance_review_date != "0000-00-00 00:00:00") {
                    $("#updinc").val(a.insurance_review_date);
                    $("#updinc").text("İncelendi");
                    document.querySelector("#updinc").disabled = true;
                }
                else{
                    document.querySelector("#updsnc").disabled = true;
                }
                if (a.insurance_result_date != "0000-00-00 00:00:00" && a.insurance_review_date != "0000-00-00 00:00:00") {
                    $("#updsnc").val(a.insurance_result_date);
                    $("#updsnc").text("Sonuçlandırıldı");
                    document.querySelector("#updsnc").disabled = true;
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
function add(){
    $("#insurance_review_date").val("");
    $("#insurance_result_date").val("");
    $("#insurance_request_date").val("");
    $("#insurance_price").val("");
    $("#insurance_description").text("");
    $("#insurance_end_date").val("");
    $("#insurance_state").val("");
    $("#insurance_id").val("");
    $("#user_id").val("");
    dropzone.removeAllFiles();
    $("#updinc").val("");
    $("#updinc").text("İncelemeye Al");
    $("#updsnc").val("");
    $("#updsnc").text("Sonuçlandır");
    document.querySelector("#updsnc").disabled = false;
    document.querySelector("#updinc").disabled = false;
}
document.getElementById("newbutton").addEventListener("click", function () {
    var insuranceId = $("#insurance_id").val();
    var insurancePrice = $("#insurance_price").val();
    var insuranceEndDate = $("#insurance_end_date").val();
    var insuranceDescription = $("#insurance_description").val();
    var insuranceRequestDate = $("#insurance_request_date").val();
    var insuranceReviewDate = $("#insurance_review_date").val();
    var insuranceResultDate = $("#insurance_result_date").val();
    var insurancePolicyUrl = $("#insurance_policy_url").val();  // Dosya yolu veya input elementini değiştirmelisiniz

    if(insuranceId!=""){
        alert("güncelle");
    }else{
        $.ajax({
            url: 'https://mobiloby.app/koluman/web/addsigorta', // Laravel Controller'ınızın URL'si
            method: 'POST',
            dataType:"json",
            data: {
                _token: csrfToken,
                insurance_id: insuranceId,
                insurance_price: insurancePrice,
                insurance_end_date: insuranceEndDate,
                insurance_description: insuranceDescription,
                insurance_request_date: insuranceRequestDate,
                insurance_review_date: insuranceReviewDate,
                insurance_result_date: insuranceResultDate,
                insurance_policy_url: insurancePolicyUrl
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                // Hata durumunda burada bir işlem yapabilirsiniz
                console.error(error);
            }
        });
    }
});
document.getElementById("updinc").addEventListener("click", function () {
    let id = $("#insurance_id").val();
    if (id) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/updatesigortareview',
            data: {
                insurance_id: id,
                _token: csrfToken,
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    if (data.insurance.insurance_review_date != "0000-00-00 00:00:00") {
                        $("#updinc").val(data.insurance.insurance_review_date);
                        $("#updinc").text("İncelendi");
                        document.querySelector("#updinc").disabled = true;
                        document.querySelector("#updsnc").disabled = false;

                    }
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
document.getElementById("updsnc").addEventListener("click", function () {
    let id = $("#insurance_id").val();
    if (id) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/updatesigortaresult',
            data: {
                insurance_id: id,
                _token: csrfToken,
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    if (data.insurance.insurance_result_date != "0000-00-00 00:00:00") {
                        $("#updsnc").val(data.insurance.insurance_result_date);
                        $("#updsnc").text("Sonuçlandırıldı");
                        document.querySelector("#updsnc").disabled = true;
                    }
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
