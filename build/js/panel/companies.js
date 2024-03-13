var checkAll = document.getElementById("checkAll");
if (checkAll) {
    checkAll.onclick = function () {
        var checkboxes = document.querySelectorAll('.form-check-all input[type="checkbox"]');
        var checkedCount = document.querySelectorAll('.form-check-all input[type="checkbox"]:checked').length;
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
            if (checkboxes[i].checked) {
                checkboxes[i].closest("tr").classList.add("table-active");
            } else {
                checkboxes[i].closest("tr").classList.remove("table-active");
            }
        }

        (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'none': document.getElementById("remove-actions").style.display = 'block';
    };
}

var perPage = 8;
var editlist = false;

//Table
var options = {
    valueNames: [
        "id",
        "name",
        "owner",
        "industry_type",
        "star_value",
        "location",
        "employee",
        "website",
        "contact_email",
        "since",
        {
            attr: "src",
            name: "image_src"
        }
    ],
    page: perPage,
    pagination: true,
    plugins: [
        ListPagination({
            left: 2,
            right: 2
        })
    ]
};
// Init list
var companyList = new List("companyList", options).on("updated", function (list) {
    list.matchingItems.length == 0 ?
        (document.getElementsByClassName("noresult")[0].style.display = "block") :
        (document.getElementsByClassName("noresult")[0].style.display = "none");
    var isFirst = list.i == 1;
    var isLast = list.i > list.matchingItems.length - list.page;
    // make the Prev and Nex buttons disabled on first and last pages accordingly
    (document.querySelector(".pagination-prev.disabled")) ? document.querySelector(".pagination-prev.disabled").classList.remove("disabled"): '';
    (document.querySelector(".pagination-next.disabled")) ? document.querySelector(".pagination-next.disabled").classList.remove("disabled"): '';
    if (isFirst) {
        document.querySelector(".pagination-prev").classList.add("disabled");
    }
    if (isLast) {
        document.querySelector(".pagination-next").classList.add("disabled");
    }
    if (list.matchingItems.length <= perPage) {
        document.querySelector(".pagination-wrap").style.display = "none";
    } else {
        document.querySelector(".pagination-wrap").style.display = "flex";
    }

    if (list.matchingItems.length > 0) {
        document.getElementsByClassName("noresult")[0].style.display = "none";
    } else {
        document.getElementsByClassName("noresult")[0].style.display = "block";
    }
});
document.addEventListener("DOMContentLoaded", function () {
    dealerships();
    getcompany();
    getcity();
    document.getElementById('sort').addEventListener('change', function () {
        var selectedValue = this.value;
        filterCompanies(selectedValue);
    });
});

function filterCompanies(selectedValue) {
    // Filtreleme işlemini gerçekleştir
    var filteredItems = companyList.filter(function (item) {
        if (selectedValue === "0") {
            return true; // Filtre yoksa tüm öğeleri göster
        } else {
            // Seçilen değere göre filtreleme
            return item.values().website === selectedValue; // Değiştirmeniz gereken kısım burası olabilir
        }
    });
    console.log(filteredItems);
    // Filtrelenmiş öğeleri tabloya ekle
    companyList.clear();
    companyList.add(filteredItems);

    // Tabloyu yeniden düzenle (sıralama, sayfalama vb.)
    companyList.sort('id', {
        order: "desc"
    });
    refreshCallbacks();
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
                        let a = '<option value="0">Lütfen Seçiniz</option>';
                        if (data.success == 1) {
                            for (var i = 0; i < data.companies.length; i++) {
                                a += '<option value="' + data.companies[i]["company_id"] + '">' + data.companies[i]["company_name"] + '</option>';
                            }
                            $("#website-field").html('');
                            $("#website-field").html(a);
                            $("#sort").html('');
                            $("#sort").html(a);
                        }
                    }
                });
            }
        }
    });
}

function getcity() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getcity',
        dataType: 'json',
        success: function (data) {
            let a = '<option value="0">Lütfen Seçiniz</option>';
            if (data.success == 1) {
                for (var i = 0; i < data.city.length; i++) {
                    a += '<option value="' + data.city[i]["isim"] + '">' + data.city[i]["isim"] + '</option>';
                }
                $("#owner-field").html('');
                $("#owner-field").html(a);
            }
        }
    });


}

function dealerships() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getdealerships',
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                $.each(data.dealerships, function (index, raw) {
                    companyList.add({
                        id: '<a href="javascript:void(0);" class="fw-medium link-primary">#VZ' + raw.dealership_id + "</a>",
                        name: raw.dealership_name,
                        owner: raw.dealership_city,
                        desc: raw.dealership_id,
                        industry_type: raw.dealership_latitude,
                        star_value: raw.dealership_longitude,
                        location: raw.dealership_phone,
                        employee: raw.dealership_description,
                        website: raw.company.company_id,
                        contact_email: raw.dealership_address,
                        image_src: raw.dealership_image_url
                    });

                    // Şirket listesini 'id' özelliğine göre azalan sırayla sıralayın
                    companyList.sort('id', {
                        order: "desc"
                    });

                    // Geri çağrı fonksiyonlarını güncelleyin
                    refreshCallbacks();
                    if (viewBtns.length > 0) {
                        viewBtns[0].click(); // İlk view butonunu tıkla
                    }
                });

                // Örneğin, belirli bir şirket girişini yükledikten sonra kaldırmak istiyorsanız
                companyList.remove("id", `<a href="javascript:void(0);" class="fw-medium link-primary">#VZ001</a>`);
            }
        },
        error: function (xhr, status, error) {
            console.error("Ajax hatası:", status, error);
        }
    });
}

var globalFile;

isCount = new DOMParser().parseFromString(
    companyList.items.slice(-1)[0]._values.id,
    "text/html"
);

document.querySelector("#company-logo-input").addEventListener("change", function () {
    var preview = document.querySelector("#companylogo-img");
    globalFile = document.querySelector("#company-logo-input").files[0];
    var reader = new FileReader();
    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);
    if (globalFile) {
        reader.readAsDataURL(globalFile);
    }
});


var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("id-field"),
    companyNameField = document.getElementById("companyname-field"),
    companyLogoImg = document.getElementById("companylogo-img"),
    ownerField = document.getElementById("owner-field"),
    industry_typeField = document.getElementById("industry_type-field"),
    star_valueField = document.getElementById("star_value-field"),
    locationField = document.getElementById("location-field"),
    employeeField = document.getElementById("employee-field"),
    websiteField = document.getElementById("website-field"),
    contact_emailField = document.getElementById("contact_email-field"),

    addBtn = document.getElementById("add-btn"),
    editBtn = document.getElementById("edit-btn"),
    removeBtns = document.getElementsByClassName("remove-item-btn"),
    editBtns = document.getElementsByClassName("edit-item-btn");
viewBtns = document.getElementsByClassName("view-item-btn");
refreshCallbacks();

document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
    if (e.relatedTarget.classList.contains("edit-item-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = "Şube Güncelle";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = "Güncelle";
    } else if (e.relatedTarget.classList.contains("add-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = "Şube Ekle";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = "Ekle";
    } else {
        document.getElementById("exampleModalLabel").innerHTML = "Şube Listele";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
    }
});
ischeckboxcheck();

document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
    clearFields();
});

document.querySelector("#companyList").addEventListener("click", function () {
    ischeckboxcheck();
});

var table = document.getElementById("customerTable");
// save all tr
var tr = table.getElementsByTagName("tr");
var trlist = table.querySelectorAll(".list tr");

var count = 11;
var forms = document.querySelectorAll('.tablelist-form')
Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            if (
                companyNameField.value !== "" &&
                ownerField.value !== "" &&
                industry_typeField.value !== "" &&
                star_valueField.value !== "" &&
                locationField.value !== "" &&
                employeeField.value !== "" &&
                websiteField.value !== "" &&
                contact_emailField.value !== "" &&
                !editlist) {
                var formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('dealership_name', companyNameField.value);
                formData.append('company_id', websiteField.value);
                formData.append('dealership_city', ownerField.value);
                formData.append('dealership_phone', locationField.value);
                formData.append('dealership_latitude', star_valueField.value);
                formData.append('dealership_longitude', industry_typeField.value);
                formData.append('dealership_description', employeeField.value);
                formData.append('dealership_address', contact_emailField.value);
                formData.append('dealership_image_url', globalFile);
                $.ajax({
                    url: "https://mobiloby.app/koluman/web/adddealership",
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
                                    $("#showModal").modal('hide');
                                    dealerships();
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
                    error: function (error) {
                        console.error(error);
                    }
                });

            } else if (

                companyNameField.value !== "" &&
                ownerField.value !== "" &&
                industry_typeField.value !== "" &&
                star_valueField.value !== "" &&
                locationField.value !== "" &&
                employeeField.value !== "" &&
                websiteField.value !== "" &&
                contact_emailField.value !== "" &&
                editlist) {
                var editValues = companyList.get({
                    id: idField.value,
                });
                Array.from(editValues).forEach(function (x) {
                    isid = new DOMParser().parseFromString(x._values.id, "text/html");
                    var selectedid = isid.body.firstElementChild.innerHTML;

                    if (selectedid == itemId) {
                        x.values({
                            id: `<a href="javascript:void(0);" class="fw-medium link-primary">${idField.value}</a>`,
                            image_src: companyLogoImg.src,
                            name: companyNameField.value,
                            owner: ownerField.value,
                            industry_type: industry_typeField.value,
                            star_value: star_valueField.value,
                            location: locationField.value,
                            employee: employeeField.value,
                            website: websiteField.value,
                            contact_email: contact_emailField.value
                        });
                    }
                });

                var formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('dealership_name', companyNameField.value);
                formData.append('company_id', websiteField.value);
                formData.append('dealership_city', ownerField.value);
                formData.append('dealership_phone', locationField.value);
                formData.append('dealership_latitude', star_valueField.value);
                formData.append('dealership_longitude', industry_typeField.value);
                formData.append('dealership_description', employeeField.value);
                formData.append('dealership_address', contact_emailField.value);
                formData.append('dealership_image_url', globalFile);
                formData.append('dealership_id', idField.value.replace("#VZ", ""));
                $.ajax({
                    url: "https://mobiloby.app/koluman/web/updatedealership",
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
                                    document.getElementById("close-modal").click();
                                    clearFields();
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
                    error: function (error) {
                        console.error(error);
                    }
                });

            }
        }
    }, false)
})


function ischeckboxcheck() {
    Array.from(document.getElementsByName("chk_child")).forEach(function (x) {
        x.addEventListener("change", function (e) {
            if (x.checked == true) {
                e.target.closest("tr").classList.add("table-active");
            } else {
                e.target.closest("tr").classList.remove("table-active");
            }

            var checkedCount = document.querySelectorAll('[name="chk_child"]:checked').length;
            if (e.target.closest("tr").classList.contains("table-active")) {
                (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'block': document.getElementById("remove-actions").style.display = 'none';
            } else {
                (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'block': document.getElementById("remove-actions").style.display = 'none';
            }
        });
    });
}


function refreshCallbacks() {
    if (removeBtns) {
        Array.from(removeBtns).forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.target.closest("tr").children[1].innerText;
                itemId = e.target.closest("tr").children[1].innerText;
                var itemValues = companyList.get({
                    id: itemId,
                });

                Array.from(itemValues).forEach(function (x) {
                    deleteid = new DOMParser().parseFromString(x._values.id, "text/html");

                    var isElem = deleteid.body.firstElementChild;
                    var isdeleteid = deleteid.body.firstElementChild.innerHTML;
                    if (isdeleteid == itemId) {
                        document.getElementById("delete-record").addEventListener("click", function () {
                            $.ajax({
                                url: "https://mobiloby.app/koluman/web/deletedealership",
                                method: 'POST',
                                dataType: "json",
                                data: {
                                    id: isdeleteid.replace("#VZ", ""),
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
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
                                                window.location.reload();
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
                                error: function (error) {
                                    console.error(error);
                                }
                            });

                        });
                    }
                });
            });
        });
    }

    if (editBtns) {
        Array.from(editBtns).forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.target.closest("tr").children[1].innerText;
                itemId = e.target.closest("tr").children[1].innerText;
                var itemValues = companyList.get({
                    id: itemId,
                });

                Array.from(itemValues).forEach(function (x) {
                    isid = new DOMParser().parseFromString(x._values.id, "text/html");
                    var selectedid = isid.body.firstElementChild.innerHTML;
                    if (selectedid == itemId) {
                        editlist = true;
                        idField.value = selectedid;
                        companyLogoImg.src = x._values.image_src;
                        companyNameField.value = x._values.name;
                        ownerField.value = x._values.owner;
                        industry_typeField.value = x._values.industry_type;
                        star_valueField.value = x._values.star_value;
                        locationField.value = x._values.location;
                        employeeField.value = x._values.employee;
                        websiteField.value = x._values.website;
                        contact_emailField.value = x._values.contact_email
                    }
                });
            });
        });
    }

    Array.from(viewBtns).forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.target.closest("tr").children[1].innerText;
            itemId = e.target.closest("tr").children[1].innerText;
            var itemValues = companyList.get({
                id: itemId,
            });

            Array.from(itemValues).forEach(function (x) {
                isid = new DOMParser().parseFromString(x._values.id, "text/html");
                var selectedid = isid.body.firstElementChild.innerHTML;
                if (selectedid == itemId) {
                    var codeBlock = `
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block">
                                <div class="avatar-md">
                                    <div class="avatar-title bg-light rounded-circle">
                                        <img src="${x._values.image_src}" alt="" class="avatar-sm rounded-circle object-fit-cover">
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-3 mb-1">${x._values.name}</h5>
                            <p class="text-muted">${x._values.owner}</p>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-success-subtle text-success fs-15 rounded">
                                        <i class="ri-global-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                        <i class="ri-mail-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                        <i class="ri-question-answer-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Şube Detayı</h6>
                            <p class="text-muted mb-4">${x._values.employee}</p>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" scope="row">Telefon</td>
                                            <td>${x._values.location}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Lat</td>
                                            <td>${x._values.industry_type}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Long</td>
                                            <td>${x._values.star_value}</td>
                                        </tr>
                                       
                                        <tr>
                                            <td class="fw-medium" scope="row">Adres</td>
                                            <td>${x._values.contact_email}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    document.getElementById('company-view-detail').innerHTML = codeBlock;
                }
            });
        });
    });
}

function clearFields() {
    companyLogoImg.src = "build/images/users/multi-user.jpg";
    companyNameField.value = "";
    ownerField.value = "";
    industry_typeField.value = "";
    star_valueField.value = "";
    locationField.value = "";
    employeeField.value = "";
    websiteField.value = "";
    contact_emailField.value = "";
}

// Delete Multiple Records
function deleteMultiple() {
    ids_array = [];
    var items = document.getElementsByName('chk_child');
    for (i = 0; i < items.length; i++) {
        if (items[i].checked == true) {
            var trNode = items[i].parentNode.parentNode.parentNode;
            var id = trNode.querySelector("td a").innerHTML;
            ids_array.push(id);
        }
    }
    if (typeof ids_array !== 'undefined' && ids_array.length > 0) {
        Swal.fire({
            title: "Emin misin?",
            text: "Seçilen şubeleri sildiğiniz takdirde işlemler geri alınmaz!",
            icon: "warning",
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                cancelButton: 'btn btn-danger w-xs mt-2',
            },
            confirmButtonText: "Evet, Sil!",
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: "https://mobiloby.app/koluman/web/deletealldealership",
                    method: 'POST',
                    dataType: "json",
                    data: {
                        ids_array: ids_array,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
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
                                    dealerships();
                                    for (i = 0; i < ids_array.length; i++) {
                                        companyList.remove("id", `<a href="javascript:void(0);" class="fw-medium link-primary">${ids_array[i]}</a>`);
                                    }
                                    document.getElementById("remove-actions").style.display = 'none';
                                    document.getElementById("checkAll").checked = false;
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
                    error: function (error) {
                        console.error(error);
                    }
                });



            }
        });
    } else {
        Swal.fire({
            title: 'Please select at least one checkbox',
            customClass: {
                confirmButton: 'btn btn-info',
            },
            buttonsStyling: false,
            showCloseButton: true
        });
    }
}

document.querySelector(".pagination-next").addEventListener("click", function () {
    (document.querySelector(".pagination.listjs-pagination")) ? (document.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
    document.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click(): '': '';
});
document.querySelector(".pagination-prev").addEventListener("click", function () {
    (document.querySelector(".pagination.listjs-pagination")) ? (document.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
    document.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click(): '': '';
});
