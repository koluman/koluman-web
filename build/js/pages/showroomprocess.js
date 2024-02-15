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


let csrfToken = $('meta[name="csrf-token"]').attr('content');
let company = new Choices("#company_id", {
    searchEnabled: false
});
getcompany();
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
$("#company_id").change(function () {
    getstep();
});


let steps = [];
let uniqueValues = []; // Array to store unique values
function getstep() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getshowroomcars',
        data: {
            company_id: $("#company_id").val(),
        },
        dataType: 'json',
        success: function (data) {
            steps = data.showroomcars;
            if (data.success == 1) {
                let a="";var tt = [];
                for (var i = 0; i < steps.length; i++) {
                    if (!uniqueValues.includes(steps[i]["step1"])) {
                        tt.push(steps[i]["step1"]);
                        uniqueValues.push(steps[i]["step1"]);
                    }
                }
                for (var i = 0; i < tt.length; i++) {
                    a+='<li><a class="dropdown-item" href="javascript:getstep1("'+tt[i]+'")">'+tt[i]+'</a></li>';
                }

                $("#step1").html(''); // Clear existing choices
                $("#step1").html(a); // Clear existing choices
            }

        }
    });
};

function getstep1(stp) {
    console.log(stp);
    var selectedStep1 = step1.getValue();
    var filteredSteps = steps.filter(item => item.step1 === selectedStep1.value);
    var uniqueStep2Values = [...new Set(filteredSteps.map(item => item.step2))];
    let b="";
    for (var i = 0; i < uniqueStep2Values.length; i++) {
        a+='<li><a class="dropdown-item" href="#">'+uniqueStep2Values[i]["step2"]+'</a></li>';
    }
    $("#step2").html(''); // Clear existing choices
    $("#step2").html(b); // Clear existing choices
}
