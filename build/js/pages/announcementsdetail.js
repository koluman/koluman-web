var ckeditorClassic = document.querySelector('#ckeditor-classic');
if (ckeditorClassic) {
    ClassicEditor
        .create(document.querySelector('#ckeditor-classic'))
        .then(function (editor) {
            editor.ui.view.editable.element.style.height = '200px';
            editor.model.document.on('change:data', function () {
                var editorContent = editor.getData();
                document.querySelector("#announcement_description").value = editorContent;
            });
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
var id = getIdFromUrl();
if (id != "" && id != null) getdetail(id);
else add();

function getdetail(id) {

  
}

function add() {
    $("#announcement_id").val("");
    $("#announcement_description").val("");
    $("#announcement_title").val("");
    $("#ckeditor-classic").val("");
    $("#announcement_state").val("");
    dropzone.removeAllFiles();
    $("#addannouncement").text("Ekle");
}

function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/showroomdetail\/(\d+)/);

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
    formData.append('announcement_description', document.querySelector("#announcement_description").value);
    formData.append('announcement_state', document.querySelector("#announcement_state").value);
    formData.append('announcement_title', $("#announcement_title").val());
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
