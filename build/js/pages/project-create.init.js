/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Project create init js
*/

// ckeditor
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
    dropzonePreviewNode.id = "";
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
                document.getElementById("newbutton").addEventListener("click", function () {
                    var insuranceId = $("#insurance_id").val();
                    var user_id = $("#user_id").val();
                    var insurancePrice = $("#insurance_price").val();
                    var insurance_state = $("#insurance_state").val();
                    var insurancePrice = $("#insurance_price").val();
                    var insuranceEndDate = $("#insurance_end_date").val();
                    var insuranceDescription = $("#insurance_description").val();
                    var insuranceRequestDate = $("#insurance_request_date").val();
                    var insuranceReviewDate = $("#insurance_review_date").val();
                    var insuranceResultDate = $("#insurance_result_date").val();
                   
console.log(insurance_policy_url);
                    if (insuranceId != "") {
                        alert("güncelle");
                    } else {
                        var formData = new FormData();
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                        formData.append('user_id', user_id);
                        formData.append('insurance_state', insurance_state);
                        formData.append('insurance_id', insuranceId);
                        formData.append('insurance_price', insurancePrice);
                        formData.append('insurance_end_date', insuranceEndDate);
                        formData.append('insurance_description', insuranceDescription);
                        formData.append('insurance_request_date', insuranceRequestDate);
                        formData.append('insurance_review_date', insuranceReviewDate);
                        formData.append('insurance_result_date', insuranceResultDate);
                        formData.append('insurance_policy_url', insurance_policy_url);
        
                        $.ajax({
                            url: 'https://mobiloby.app/koluman/web/addsigorta', // Laravel Controller'ınızın URL'si
                            method: 'POST',
                            dataType: "json",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                console.log(response);
                            },
                            error: function (error) {
                                // Hata durumunda burada bir işlem yapabilirsiniz
                                console.error(error);
                            }
                        });
                    }
                });
            });
        }
    });

}
