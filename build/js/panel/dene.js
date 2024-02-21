itemid = 13;
ClassicEditor
    .create(document.querySelector('#ckeditor-classic'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '200px';
        editor.model.document.on('change:data', function () {
            var editorContent = editor.getData();
            document.querySelector("#car_description").value = editorContent;
        });
    })
    .catch(function (error) {
        console.error(error);
    });
var dropzonePreviewNode = document.querySelector("#dropzone-preview2-list");
var car_img_url;
var dropzone;
if (dropzonePreviewNode) {
    dropzonePreviewNode.id = "";
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);

    dropzone = new Dropzone(".dropzone", {
        url: 'https://httpbin.org/post',
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview2",
        init: function () {
            this.on("addedfile", function (file) {
                car_img_url = file;
            });
        }
    });
}