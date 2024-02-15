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
let uniqueValues = []; 
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
                    a += '<li><a class="dropdown-item" href="javascript:getstep1(\'' + tt[i] + '\')">' + tt[i] + '</a></li>';
                }

                $("#step1").html(''); 
                $("#step1").html(a); 
            }

        }
    });
};

function getstep1(stp) {
    document.querySelector("#step1text").value=stp;
    var filteredSteps = steps.filter(item => item.step1 === stp);
    var uniqueStep2Values = [...new Set(filteredSteps.map(item => item.step2))];
    let b="";
    for (var i = 0; i < uniqueStep2Values.length; i++) {
        b+='<li><a class="dropdown-item" href="javascript:getstep3(\'' + uniqueStep2Values[i] + '\')">'+uniqueStep2Values[i]+'</a></li>';
    }
    $("#step2").html(''); 
    $("#step2").html(b);
}
function getstep3(stp) {
    document.querySelector("#step2text").value=stp;
    var filteredSteps = steps.filter(item => item.step2 === stp);
    var uniqueStep3Values = [...new Set(filteredSteps.map(item => item.step3))];
    let bb="";
    for (var i = 0; i < uniqueStep3Values.length; i++) {
        bb+='<li><a class="dropdown-item" href="javascript:getstep4(\'' + uniqueStep3Values[i] + '\')">'+uniqueStep3Values[i]+'</a></li>';
    }
    $("#step3").html(''); 
    $("#step3").html(bb);
}
function getstep4(stp) {
    document.querySelector("#step3text").value=stp;
    var filteredSteps = steps.filter(item => item.step3 === stp);
    var uniqueStep4Values = [...new Set(filteredSteps.map(item => item.step4))];
    let bbb="";
    console.log(uniqueStep4Values);
    for (var i = 0; i < uniqueStep4Values.length; i++) {
        bb+='<li><a class="dropdown-item" href="javascript:getstep5(\'' + uniqueStep4Values[i] + '\')">'+uniqueStep4Values[i]+'</a></li>';
    }
    $("#step4").html(''); 
    $("#step4").html(bbb);
}
