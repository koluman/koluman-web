itemid = 13;
var ckeditorClassic = null;
let csrfToken = $('meta[name="csrf-token"]').attr('content');
let steps = [];
let uniqueValues = [];
var dropzonePreviewNode = document.querySelector("#dropzone-preview3-list");
var story_small_image;
if (dropzonePreviewNode) {
    dropzonePreviewNode.id = "";
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);

    var dropzone = new Dropzone("#shdiv", {
        url: 'https://httpbin.org/post',
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview3",
        init: function () {
            this.on("addedfile", function (file) {
                story_small_image = file;
            });
            this.on("removedfile", function (file) {
                  $.ajax({
                    type: 'POST',
                    url: 'https://mobiloby.app/koluman/web/deletestoryimage',
                    data: {
                        story_id:  $("#story_id").val(),
                        image: "story_small_image",
                        _token: csrfToken,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            document.querySelector("#shdiv").style.display = "block";
                            $("#shid").text("");
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("AJAX request failed:", status, error);
                    }
                });
            });
        }
    });
}

var dropzonePreviewNode2 = document.querySelector("#dropzone-preview33-list");
var story_big_image;
if (dropzonePreviewNode2) {
    dropzonePreviewNode2.id = "";
    var previewTemplate = dropzonePreviewNode2.parentNode.innerHTML;
    dropzonePreviewNode2.parentNode.removeChild(dropzonePreviewNode2);

    var dropzone2 = new Dropzone("#sh2div", {
        url: 'https://httpbin.org/post',
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview33",
        init: function () {
            this.on("addedfile", function (file) {
                story_big_image = file;
            });
            
            this.on("removedfile", function (file) {
                $.ajax({
                    type: 'POST',
                    url: 'https://mobiloby.app/koluman/web/deletestoryimage',
                    data: {
                        story_id:  $("#story_id").val(),
                        image: "story_big_image",
                        _token: csrfToken,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            document.querySelector("#sh2div").style.display = "block";
                            $("#sh2id").text("");
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("AJAX request failed:", status, error);
                    }
                });
            });
        }
    });
}

function getFileNameFromUrl(url) {
    let parts = url.split('/');
    return parts[parts.length - 1];
}


document.addEventListener('DOMContentLoaded', function () {
    getcompany();
});

function getcompany() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getApiToken',
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                $.ajax({
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/getcompanies',
                    dataType: 'json',
                    headers: {
                        "Authorization": 'Bearer ' + data.token
                    },
                    success: function (data) {
                        let a = '<option value="0">Lütfen Seçiniz</option>';
                        a+= '<option value="-1">Genel</option>';
                        if (data.success == 1) {
                            for (var i = 0; i < data.companies.length; i++) {
                                a += '<option value="' + data.companies[i]["company_id"] + '">' + data.companies[i]["company_name"] + '</option>';
                            }
                            $("#company_id").html('');
                            $("#company_id").html(a);

                            var id = getIdFromUrl();
                            if (id != "" && id != null) getdetail(id);
                            else add();
                        }
                    }
                });
            }
        }
    });
}

function getdetail(id) {
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getstoryid',
        dataType: 'json',
        data: {
            story_id: id,
            _token: csrfToken, 
        },
        success: function (data) {
            console.log(data.storyid[0].story_id);
            $("#story_id").val(data.storyid[0].story_id);
            $("#story_title").val(data.storyid[0].story_title);
            $("#company_id").val(data.storyid[0].company_id);
            $("#story_priority").val(data.storyid[0].story_priority);
            if (data.storyid[0].story_state == 1) document.querySelector("#story_state").checked = true;
            else document.querySelector("#story_state").checked = false;
            if (data.storyid[0].story_small_image) {
                let FileName = getFileNameFromUrl(data.storyid[0].story_big_image);
                $("#shid").text(FileName);
                document.querySelector("#shdiv").style.display = "none";
                var mockFile = {
                    name: FileName,
                };
                dropzone.emit("addedfile", mockFile);
                var pdfIconPath = "https://mobiloby.app/koluman/web/public/upload/pdf.png";
                dropzone.emit("thumbnail", mockFile, pdfIconPath);
                dropzone.emit("complete", mockFile);
                dropzone.files.push(mockFile);
            } 
            if(data.storyid[0].story_big_image) {
                let FileName = getFileNameFromUrl(data.storyid[0].story_big_image);
                $("#sh2id").text(FileName);
                document.querySelector("#sh2div").style.display = "none";
                var mockFile = {
                    name: FileName,
                };
                dropzone2.emit("addedfile", mockFile);
                var pdfIconPath = "https://mobiloby.app/koluman/web/public/upload/pdf.png";
                dropzone2.emit("thumbnail", mockFile, pdfIconPath);
                dropzone2.emit("complete", mockFile);
                dropzone2.files.push(mockFile);
            }
            $("#addstory").text("Güncelle");
        }

    });
}

function add() {
    $("#story_id").val("");
    $("#story_title").val("");
    $("#story_priority").val(0);
    $("#company_id").val("");
    dropzone2.removeAllFiles();
    dropzone.removeAllFiles();
    $("#addstory").text("Ekle");
}

function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/storydetail\/(\d+)/);

    if (match && match[1]) {
        return parseInt(match[1], 10);
    } else {
        return null;
    }
}



$("#addstory").click(function () {

    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('story_id', $("#story_id").val());
    formData.append('story_title', document.querySelector("#story_title").value);
    formData.append('company_id', document.querySelector("#company_id").value);
    formData.append('story_priority', $("#story_priority").val());
    formData.append('story_big_image', story_big_image);
    formData.append('story_small_image', story_small_image);
    formData.append('story_state', document.querySelector("#story_state").checked == false ? 0 : 1);
    $.ajax({
        url: "https://mobiloby.app/koluman/web/storyprocess",
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
                        window.location.href = "https://mobiloby.app/koluman/web/story";
                    }
                });
            } else if (data.success == 2) {
                Swal.fire({
                    title: "Başarısız",
                    html: data.message.join('<br>'),
                    icon: "warning",
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                        cancelButton: 'btn btn-danger w-xs mt-2',
                    },
                    confirmButtonText: "Tamam!",
                    buttonsStyling: false,
                    showCloseButton: false
                });
            } else {
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

document.getElementById("delete-record").addEventListener("click", function () {
    let id = $("#story_id").val();
    if (id) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/deletestory',
            data: {
                story_id: id,
                _token: csrfToken,
            },
            dataType: 'json',
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
                            window.location.href = "https://mobiloby.app/koluman/web/story";
                        }
                    });
                } else {
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
            error: function (xhr, status, error) {
                alert("AJAX request failed:", status, error);
            }
        });
    }
});
