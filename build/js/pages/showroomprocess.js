
itemid = 13;
ClassicEditor
    .create(document.querySelector('#ckeditor-classic'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '200px';
    })
    .catch(function (error) {
        console.error(error);
    });

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
let steps = [];
let uniqueValues = []; 
$(document).ready(function () {
    getcompany();
    var id = getIdFromUrl();
    console.log(id);
    if (id != "") getdetail(id);
    else add();
});
function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/shoowroomdetail\/(\d+)/);

    if (match && match[1]) {
        return parseInt(match[1], 10);
    } else {
        return null;
    }
}
function getdetail(id) {
    console.log("sdsdddddddd");

}
function add() {
    console.log("sfdsf");
    $("#car_id").val("");
    $("#car_name").val("");
    $("#company_id").val("");
    $("#ckeditor-classic").val("");
    $("#step1").text("");
    $("#step2").val("");
    $("#step3").val("");
    $("#step4").val("");
    $("#step5").val("");
    $("#user_id").val("");
    dropzone.removeAllFiles();
    $("#addcar").text("Ekle");
    document.querySelector("#step1text").disabled=true;
    document.querySelector("#step2text").disabled = true;
    document.querySelector("#step3text").disabled = true;
    document.querySelector("#step4text").disabled = true;
    document.querySelector("#step5text").disabled = true;

}
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
                document.querySelector("#step1text").disabled = false;
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
    document.querySelector("#step2text").disabled = false;
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
    document.querySelector("#step3text").disabled = false;

    $("#step3").html(''); 
    $("#step3").html(bb);
}
function getstep4(stp) {
    document.querySelector("#step3text").value=stp;
    var filteredSteps = steps.filter(item => item.step3 === stp);
    var uniqueStep4Values = [...new Set(filteredSteps.map(item => item.step4))];
    let bbb="";
    for (var i = 0; i < uniqueStep4Values.length; i++) {
        bbb+='<li><a class="dropdown-item" href="javascript:getstep5(\'' + uniqueStep4Values[i] + '\')">'+uniqueStep4Values[i]+'</a></li>';
    }
    document.querySelector("#step4text").disabled = false;

    $("#step4").html(''); 
    $("#step4").html(bbb);
}
function getstep5(stp) {
    document.querySelector("#step4text").value=stp;
    var filteredSteps = steps.filter(item => item.step4 === stp);
    var uniqueStep5Values = [...new Set(filteredSteps.map(item => item.step5))];
    let bbbb="";
    for (var i = 0; i < uniqueStep5Values.length; i++) {
        bbbb+='<li><a class="dropdown-item" href="javascript:getstep6(\'' + uniqueStep5Values[i] + '\')">'+uniqueStep5Values[i]+'</a></li>';
    }
    document.querySelector("#step5text").disabled = false;
    $("#step5").html(''); 
    $("#step5").html(bbbb);
}
function getstep6(stp) {
    document.querySelector("#step5text").value=stp;
}
