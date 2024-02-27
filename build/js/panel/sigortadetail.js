var ckeditorClassic = document.querySelector('#ckeditor-classic');
if (ckeditorClassic) {
    ClassicEditor
        .create(document.querySelector('#ckeditor-classic'))
        .then(function (editor) {
            editor.ui.view.editable.element.style.height = '200px';
        })
        .catch(function (error) {
            console.error(error);
        });
}
var insurance_policy_url;

// Dropzone
var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
if (dropzonePreviewNode) {
    dropzonePreviewNode.id = "";""
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
    
    var dropzone = new Dropzone(".dropzone", {
        url: 'https://httpbin.org/post',
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview",
        init: function () {
            this.on("addedfile", function (file) {
                insurance_policy_url = file;
            });
        }
    });
}

$(document).ready(function () {
    var id = getIdFromUrl();
    if (id != "") getdetail(id);
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
                $("#insurance_type").val(a.insurance_type);
                $("#newbutton").text("Güncelle");
                if (a.insurance_end_date != "0000-00-00 00:00:00" && a.insurance_end_date != "" && a.insurance_end_date != null) {
                    $("#insurance_end_date").val(a.insurance_end_date);
                }
                if (a.insurance_request_date != "0000-00-00 00:00:00" && a.insurance_request_date != "" && a.insurance_request_date != null) {
                    $("#insurance_request_date").val(a.insurance_request_date);
                    document.querySelector("#insurance_request_date").disabled = true;
                }
                if (a.insurance_review_date != "0000-00-00 00:00:00" && a.insurance_review_date != "" && a.insurance_review_date != null) {
                    $("#insurance_review_date").val(a.insurance_review_date);
                    document.querySelector("#insurance_review_date").disabled = true;

                }
                if (a.insurance_result_date != "0000-00-00 00:00:00" && a.insurance_result_date != "" && a.insurance_result_date != null) {
                    $("#insurance_result_date").val(a.insurance_result_date);
                    document.querySelector("#insurance_result_date").disabled = true;
                }
                if (a.insurance_review_date != "0000-00-00 00:00:00" && a.insurance_review_date != null) {
                    $("#updinc").val(a.insurance_review_date);
                    $("#updinc").text("İncelendi");
                    document.querySelector("#updinc").disabled = true;
                } else {
                    document.querySelector("#updsnc").disabled = true;
                }
                if (a.insurance_result_date != "0000-00-00 00:00:00" && a.insurance_review_date != "0000-00-00 00:00:00" && a.insurance_review_date != null) {
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
                    var pdfIconPath = "https://mobiloby.app/koluman/web/public/upload/pdf.png";
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

function add() {
    $("#insurance_review_date").val("");
    $("#insurance_result_date").val("");
    $("#insurance_request_date").val("");
    $("#insurance_price").val("");
    $("#insurance_description").text("");
    $("#insurance_end_date").val("");
    $("#insurance_state").val("");
    $("#insurance_id").val("");
    $("#insurance_type").val("");
    $("#user_id").val("");
    dropzone.removeAllFiles();
    $("#updinc").val("");
    $("#updinc").text("İncelemeye Al");
    $("#updsnc").val("");
    $("#updsnc").text("Sonuçlandır");
    document.querySelector("#updsnc").disabled = false;
    document.querySelector("#updinc").disabled = false;
}

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
                    if (data.insurance.insurance_review_date != "0000-00-00 00:00:00" && data.insurance.insurance_review_date != null) {
                        $("#updinc").val(data.insurance.insurance_review_date);
                        $("#updinc").text("İncelendi");
                        document.querySelector("#updinc").disabled = true;
                        document.querySelector("#updsnc").disabled = false;
                        $("#insurance_state").val(data.insurance.insurance_state);

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
                    if (data.insurance.insurance_result_date != "0000-00-00 00:00:00" && data.insurance.insurance_result_date != null) {
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
document.getElementById("newbutton").addEventListener("click", function () {
    var insuranceId = $("#insurance_id").val();
    var user_id = $("#user_id").val();
    var insurancePrice = $("#insurance_price").val();
    var insurance_state = $("#insurance_state").val();
    var insuranceEndDate = $("#insurance_end_date").val();
    var insuranceDescription = $("#insurance_description").val();
    var insuranceRequestDate = $("#insurance_request_date").val();
    var insuranceReviewDate = $("#insurance_review_date").val();
    var insuranceResultDate = $("#insurance_result_date").val();
    var insurance_type = $("#insurance_type").val();
    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('user_id', user_id);
    formData.append('insurance_state', insurance_state);
    formData.append('insurance_price', insurancePrice);
    formData.append('insurance_end_date', insuranceEndDate);
    formData.append('insurance_description', insuranceDescription);
    formData.append('insurance_request_date', insuranceRequestDate);
    formData.append('insurance_review_date', insuranceReviewDate);
    formData.append('insurance_result_date', insuranceResultDate);
    formData.append('insurance_policy_url', insurance_policy_url);
    formData.append('insurance_type', insurance_type);
    formData.append('insurance_id', insuranceId);
    if (insuranceId != "") $url = "https://mobiloby.app/koluman/web/updatesigorta";
    else $url = "https://mobiloby.app/koluman/web/addsigorta"
    $.ajax({
        url: $url,
        method: 'POST',
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.success == 1) {
                Swal.fire({
                    title: "Başarılı",
                    text: data.message,
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                    },
                    confirmButtonText: "Tamam!",
                    buttonsStyling: false,
                    showCloseButton: false
                }).then(function (result) {
                    if (result.value) {
                        window.location.href = "https://mobiloby.app/koluman/web/sigortalist";
                    }
                });
            }
            if (data.success == 2) {
                if (data.message.insurance_type) {
                    Swal.fire({
                        title: "Başarısız",
                        text: data.message.insurance_type[0],
                        icon: "warning",
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                            cancelButton: 'btn btn-danger w-xs mt-2',
                        },
                        confirmButtonText: "Tamam!",
                        buttonsStyling: false,
                        showCloseButton: false
                    });
                }

                if (data.message.insurance_state) {
                    Swal.fire({
                        title: "Başarısız",
                        text: data.message.insurance_state[0],
                        icon: "warning",
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                            cancelButton: 'btn btn-danger w-xs mt-2',
                        },
                        confirmButtonText: "Tamam!",
                        buttonsStyling: false,
                        showCloseButton: false
                    });
                }

                if (data.message.user_id) {
                    Swal.fire({
                        title: "Başarısız",
                        text: data.message.user_id[0],
                        icon: "warning",
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                            cancelButton: 'btn btn-danger w-xs mt-2',
                        },
                        confirmButtonText: "Tamam!",
                        buttonsStyling: false,
                        showCloseButton: false
                    });
                }
            } 
            else {
                Swal.fire({
                    title: "Başarısız",
                    text: data.message,
                    icon: "warning",
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                        cancelButton: 'btn btn-danger w-xs mt-2',
                    },
                    confirmButtonText: "Tamam!",
                    buttonsStyling: false,
                    showCloseButton: false
                });
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});
