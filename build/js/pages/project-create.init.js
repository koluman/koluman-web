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
                    var insurancePolicyUrl = file;  // Dosya yolu veya input elementini değiştirmelisiniz*/
                   

                    if (insuranceId != "") {
                        alert("güncelle");
                    } else {

                        $.ajax({
                            url: 'https://mobiloby.app/koluman/web/addsigorta', // Laravel Controller'ınızın URL'si
                            method: 'POST',
                            dataType: "json",
                            data: {
                                _token: csrfToken,
                                user_id:user_id,
                                insurance_state:insurance_state,
                                insurance_id: insuranceId,
                                insurance_price: insurancePrice,
                                insurance_end_date: insuranceEndDate,
                                insurance_description: insuranceDescription,
                                insurance_request_date: insuranceRequestDate,
                                insurance_review_date: insuranceReviewDate,
                                insurance_result_date: insuranceResultDate,
                                insurance_policy_url: insurancePolicyUrl
                            },
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
