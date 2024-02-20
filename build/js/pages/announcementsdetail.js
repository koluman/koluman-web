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
  console.log("ekleme");

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
