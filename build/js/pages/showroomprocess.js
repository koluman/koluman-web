/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce product create Js File
*/

// ckeditor
itemid = 13;
ClassicEditor
    .create(document.querySelector('#ckeditor-classic'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '200px';
    })
    .catch(function (error) {
        console.error(error);
    });

// Dropzone
var dropzonePreviewNode = document.querySelector("#dropzone-preview2-list");
dropzonePreviewNode.itemid = "";
var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
var dropzone = new Dropzone(".dropzone", {
    url: 'https://httpbin.org/post',
    method: "post",
    previewTemplate: previewTemplate,
    previewsContainer: "#dropzone-preview2",
});

// Form Event
(function () {
    'use strict'
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let  company = new Choices("#company_id", {
        searchEnabled: false
    });
    document.addEventListener("DOMContentLoaded", function () {
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
                            if (data.success == 1) {
                                var ch = [];
                                var v = "";
                                var t = "Lütfen Seçiniz";
                                var c = {
                                    value: v,
                                    label: t,
                                };
                                ch.push(c);
                                for (var i = 0; i < data.companies.length; i++) {
                                    v = data.companies[i]["company_id"];
                                    t = data.companies[i]["company_name"];

                                    c = {
                                        value: v,
                                        label: t,
                                    };
                                    ch.push(c);
                                }
                                company.clearChoices(); // Clear existing choices
                                company.setChoices(ch, 'value', 'label', true); // Set new choices
                            }
                        }
                    });
                }
            }
        });
    }

})()
