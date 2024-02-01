$(document).ready(function () {
    users();
});
let userdata = [];
let csrfToken = $('meta[name="csrf-token"]').attr('content');

function users() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getallusers',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if(data.success==1){
                userdata = data.usersall;
                let son = orderslist(userdata);
                $("#userlist").html('');
                $("#userlist").html(son);
            }
         
        }
    });
}

function orderslist(data) {
    var s = "";
    let j = 0;
    for (let i = 0; i < data.length; i++) {
        j++;
        s += '<tr>';
        s += '<th scope="row">';
        s += '    <div class="form-check">';
        s += '        <input class="form-check-input" type="checkbox" name="checkAll" value="option1">';
        s += '    </div>';
        s += '</th>';
        s += '<td class="id"><a href="#" class="fw-medium link-primary">#' + j + '</a></td>';
        s += '<td hidden class="user">' + data[i].backuser_id + '</td>';
        s += '<td class="username">' + data[i].backuser_name + '</td>';
        s += '<td class="usermail">' + data[i].backuser_mail + '</td>';
        s += '<td class="userphone">' + data[i].backuser_phone + '</td>';
        s += '<td class="userrole">' + data[i].backuser_role + '</td>';
        s += '<td class="userrole">' + data[i].backuser_register_date + '</td>';
        s += '<td>';
        s += '    <ul class="list-inline hstack gap-2 mb-0">';
        s += '        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">';
        s += '            <a href="#" class="text-primary d-inline-block">';
        s += '                <i class="ri-eye-fill fs-16"></i>';
        s += '            </a>';
        s += '        </li>';
        s += '        <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">';
        s += '            <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">';
        s += '                <i class="ri-pencil-fill fs-16"></i>';
        s += '            </a>';
        s += '        </li>';
        s += '        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">';
        s += '            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">';
        s += '                <i class="ri-delete-bin-5-fill fs-16"></i>';
        s += '            </a>';
        s += '        </li>';
        s += '    </ul>';
        s += '</td>';
        s += '</tr>';
    }
    return s;

}

document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
    if (e.relatedTarget.classList.contains("edit-item-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = "Kullanıcı Güncelle";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = "Güncelle";
    } else {
        document.getElementById("exampleModalLabel").innerHTML = "Kullanıcı Ekle";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = "Ekle";
    }
});
document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
    clearFields();
});

function clearFields() {
    $("#username").val("");
    $("#usermail").val("");
    $("#userphone").val("");
    $("#userrole").val("0");
    $("#userid").val("");
}

document.getElementById("userlist").addEventListener("click", function (event) {
    let target = event.target;
    while (target && target.tagName !== "TR") {
        target = target.parentNode;
    }
    if (target) {
        let user_name = target.querySelector(".username").innerText;
        let user_mail = target.querySelector(".usermail").innerText;
        let user_phone = target.querySelector(".userphone").innerText;
        let user_role = target.querySelector(".userrole").innerText;
        let user_id = target.querySelector(".user").innerText;
        $("#username").val(user_name);
        $("#usermail").val(user_mail);
        $("#userphone").val(user_phone);
        $("#userrole").val(user_role);
        $("#userid").val(user_id);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector(".tablelist-form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var userId = document.getElementById("userid").value;
        var userName = document.getElementById("username").value;
        var userMail = document.getElementById("usermail").value;
        var userPhone = document.getElementById("userphone").value;
        var userRole = document.getElementById("userrole").value;
        if (userId) {
            updateUser(userId, userName, userMail, userPhone, userRole);
        } else {
            addUser(userName, userMail, userPhone, userRole);
        }
    });

    function addUser(userName, userMail, userPhone, userRole) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/adduser',
            data: {
                userName: userName,
                userMail: userMail,
                userPhone: userPhone,
                userRole: userRole,
                _token: csrfToken,
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    $('#showModal').modal('hide');
                    users();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                alert("AJAX request failed:", status, error);
            }
        });
    }

    function updateUser(userId, userName, userMail, userPhone, userRole) {
        $.ajax({
            type: 'POST',
            url: 'https://mobiloby.app/koluman/web/updateuser',
            data: {
                userName: userName,
                userMail: userMail,
                userPhone: userPhone,
                userRole: userRole,
                userId: userId,
                _token: csrfToken,
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    $('#showModal').modal('hide');
                    users();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                alert("AJAX request failed:", status, error);
            }
        });
    }

    document.getElementById("delete-record").addEventListener("click", function () {
        let userId = document.getElementById("userid").value;
        if (userId) {
            $.ajax({
                type: 'POST',
                url: 'https://mobiloby.app/koluman/web/deleteuser',
                data: {
                    userId: userId,
                    _token: csrfToken,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == 1) {
                        $('#deleteOrder').modal('hide');
                        users();
                    } else {
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert("AJAX request failed:", status, error);
                }
            });
        }
    });
});
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
$(document).on("change", '.form-check-all input[type="checkbox"]', function () {
    var checkboxes = $('.form-check-all input[type="checkbox"]');
    var checkedCount = checkboxes.filter(':checked').length;

    checkboxes.each(function () {
        if ($(this).prop('checked')) {
            $(this).closest("tr").addClass("table-active");
        } else {
            $(this).closest("tr").removeClass("table-active");
        }
    });

    $("#remove-actions").css("display", checkedCount > 0 ? 'block' : 'none');
});

function deleteMultiple() {
    var ids_array = [];
    var items = $('.form-check-all input[type="checkbox"]:checked');

    items.each(function () {
        var trNode = $(this).closest("tr");
        var id = trNode.find(".user").text();
        ids_array.push(id);
    });

    if (ids_array.length > 0) {
        Swal.fire({
            title: "Emin misin?",
            text: "Seçili kullanıcıları silmek istiyormusun!",
            icon: "warning",
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                cancelButton: 'btn btn-danger w-xs mt-2',
            },
            confirmButtonText: "Evet, sil!",
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: 'https://mobiloby.app/koluman/web/deleteusers',
                    data: {
                        userIds: ids_array,
                        _token: csrfToken,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success == 1) {
                            Swal.fire({
                                title: 'Başarılı!',
                                text: 'Seçilen kullanıcılar kalıcı bir şekilde silindi.',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-info w-xs mt-2',
                                },
                                buttonsStyling: false
                            });
                            $("#remove-actions").css("display", "none");
                            $("#checkAll").prop("checked", false);
                            users();

                        } else {
                            alert(data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("AJAX request failed:", status, error);
                    }
                });
            }
        });
    } else {
        Swal.fire({
            title: 'Lütfen seçim yapınız',
            customClass: {
                confirmButton: 'btn btn-info',
            },
            buttonsStyling: false,
            showCloseButton: true
        });
    }
}

function filterUsersByRole(role) {
    return userdata.filter(user => user.backuser_role === role);
}

var selectedTab = "All";

$("ul.nav-tabs-custom li.nav-item").on("click", function () {
    var clickedId = $(this).find("a").attr("id");
    let sonn = "";
    let veri = "";
    if (selectedTab !== clickedId) {
        selectedTab = clickedId;
        filterAndSearch();
    }
    switch (clickedId) {
        case "All":
            sonn = orderslist(userdata);
            break;
        case "Admin":
            veri = filterUsersByRole("admin");
            sonn = orderslist(veri);
            break;
        case "Ajans":
            veri = filterUsersByRole("ajans");
            sonn = orderslist(veri);
            break;
        case "Kullanici":
            veri = filterUsersByRole("kullanici");
            sonn = orderslist(veri);
            break;
        case "Sigorta":
            veri = filterUsersByRole("sigorta");
            sonn = orderslist(veri);
            break;
        case "Servis":
            veri = filterUsersByRole("servis");
            sonn = orderslist(veri);
            break;
        default:
            break;
    }
    $("#userlist").html('');
    $("#userlist").html(sonn);
});
$(document).on("input", '.search', function () {
    var searchText = $(this).val().toLowerCase();
    var filteredData = userdata.filter(function (user) {
        return (
            user.backuser_name.toLowerCase().includes(searchText) ||
            user.backuser_mail.toLowerCase().includes(searchText) ||
            user.backuser_phone.toLowerCase().includes(searchText) ||
            user.backuser_role.toLowerCase().includes(searchText)
        );
    });
    var son = orderslist(filteredData);
    $("#userlist").html('');
    $("#userlist").html(son);
});

$(document).on("input", '.search', function () {
    // Arama yapıldığında filtreleme yap
    filterAndSearch();
});

function filterAndSearch() {
    var searchText = $('.search').val().toLowerCase();

    // Seçilen sekmeye göre kullanıcıları filtrele
    var filteredData = userdata;
    if (selectedTab !== "All") {
        filteredData = filterUsersByRole(selectedTab.toLowerCase());
    }

    // Arama yap
    filteredData = filteredData.filter(function (user) {
        return (
            user.backuser_name.toLowerCase().includes(searchText) ||
            user.backuser_mail.toLowerCase().includes(searchText) ||
            user.backuser_phone.toLowerCase().includes(searchText) ||
            user.backuser_role.toLowerCase().includes(searchText)
        );
    });

    // Listeyi güncelle
    var son = orderslist(filteredData);
    $("#userlist").html('');
    $("#userlist").html(son);
}

function SearchData() {
    var selectedDateRange = $("#demo-datepicker").val();
    var selectedStatus = $("#idStatus").val();
    var searchText = $('.search').val().toLowerCase();

    // Filtreleme ve arama işlemleri
    var filteredData = userdata;

    // Tarih filtresi
    if (selectedDateRange) {
        filteredData = filteredData.filter(function (user) {
            var userDate = new Date(user.backuser_register_date);
            return userDate >= new Date(selectedDateRange[0]) && userDate <= new Date(selectedDateRange[1]);
        });
    }

    // Yetki filtresi
    if (selectedStatus && selectedStatus !== "all") {
        filteredData = filteredData.filter(function (user) {
            return user.backuser_role === selectedStatus;
        });
    }

    // Arama filtresi
    if (searchText) {
        filteredData = filteredData.filter(function (user) {
            return (
                user.backuser_name.toLowerCase().includes(searchText) ||
                user.backuser_mail.toLowerCase().includes(searchText) ||
                user.backuser_phone.toLowerCase().includes(searchText) ||
                user.backuser_role.toLowerCase().includes(searchText)
            );
        });
    }

    // Listeyi güncelle
    updatePageWithFilteredData(filteredData);
}

function updatePageWithFilteredData(filteredData) {
    var son = orderslist(filteredData);
    $("#userlist").html('');
    $("#userlist").html(son);
}


function updatePageWithFilteredData(filteredData) {
    var son = orderslist(filteredData);
    $("#userlist").html('');
    $("#userlist").html(son);
}


