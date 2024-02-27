var ckeditorClassic = document.querySelector('#ckeditor-classic');
let csrfToken = $('meta[name="csrf-token"]').attr('content');

function initializeCKEditor() {
    ClassicEditor
        .create(document.querySelector('#ckeditor-classic'))
        .then(function (editor) {
            ckeditorClassic = editor;
            editor.ui.view.editable.element.style.height = '200px';
        })
        .catch(function (error) {
            console.error(error);
        });
}
var dropzonePreviewNode = document.querySelector("#dropzone-preview4-list");
var announcement_img_url;
if (dropzonePreviewNode) {
    dropzonePreviewNode.id = "";
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
    var dropzone = new Dropzone(".dropzone", {
        url: 'https://httpbin.org/post',
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview4",
        init: function () {
            this.on("addedfile", function (file) {
                announcement_img_url = file;
            });
        }
    });
}

function getFileNameFromUrl(url) {
    let parts = url.split('/');
    return parts[parts.length - 1];
}

document.addEventListener('DOMContentLoaded', function () {
    initializeCKEditor();
    var id = getIdFromUrl();
    if (id != "" && id != null) getdetail(id);
    else add();
});


function getdetail(id) {
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getannouncementid',
        dataType: 'json',
        data: {
            announcement_id: id,
            _token: csrfToken, // CSRF token'ını gönder
        },
        success: function (data) {
            $("#announcement_id").val(data.announcementid[0].announcement_id);
            $("#announcement_title").val(data.announcementid[0].announcement_title);
            if (ckeditorClassic) {
                ckeditorClassic.setData(data.announcementid[0].announcement_description);
            } else {
                console.error('CKEditor not properly initialized.');
            }
            $("#announcement_state").val(data.announcementid[0].announcement_state);

            if (data.announcementid[0].announcement_image_url) {
                let FileName = getFileNameFromUrl(data.announcementid[0].announcement_image_url);
                $("#anid").text(FileName);
                document.querySelector("#andiv").style.display = "none";
                var mockFile = {
                    name: FileName,
                };
                dropzone.emit("addedfile", mockFile);
                var pdfIconPath = "https://mobiloby.app/koluman/web/public/upload/pdf.png";
                dropzone.emit("thumbnail", mockFile, pdfIconPath);
                dropzone.emit("complete", mockFile);
                dropzone.files.push(mockFile);
            } else {
                dropzone.removeAllFiles();
            }
            $("#addannouncement").text("Güncelle");
        }
    });
}

function add() {
    $("#announcement_id").val("");
    $("#announcement_title").val("");
    $("#ckeditor-classic").val("");
    $("#announcement_state").val("");
    dropzone.removeAllFiles();
    $("#addannouncement").text("Ekle");
    if (ckeditorClassic) {
        ckeditorClassic.setData(0);
    }
}

function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/announcementsdetail\/(\d+)/);
    if (match && match[1]) {
        return parseInt(match[1], 10);
    } else {
        return null;
    }
}
$("#addannouncement").click(function () {
    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('announcement_id', $("#announcement_id").val());
    formData.append('announcement_description', ckeditorClassic.getData());
    formData.append('announcement_state', document.querySelector("#announcement_state").value);
    formData.append('announcement_title', $("#announcement_title").val());
    formData.append('announcement_img_url', announcement_img_url);
    if ($("#announcement_id").val() != "") url = "https://mobiloby.app/koluman/web/updateannouncement";
    else url = "https://mobiloby.app/koluman/web/addannouncement"
    $.ajax({
        url: url,
        method: 'POST',
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.success == 1) {
                window.location.href = "https://mobiloby.app/koluman/web/announcements";
            } else {
                alert(data.message);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});
document.getElementById("delete-record").addEventListener("click", function () {
    let id = $("#announcement_id").val();
    if (id) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/deleteannouncement',
            data: {
                announcement_id: id,
                _token: csrfToken,
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    window.location.href = "https://mobiloby.app/koluman/web/announcements";
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
