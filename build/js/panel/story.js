var apiEndpoint = 'https://mobiloby.app/koluman/web/getstories';
var productListAllData = [];
var xhr = new XMLHttpRequest();
xhr.open('GET', apiEndpoint, true);
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
        if (xhr.status == 200) {
            var responseData = JSON.parse(xhr.responseText);
            productListAllData = responseData.stories; // productListAllData dizisini güncelle
            updateTable(productListAllData);
        } else {
            console.error('Sunucu hatası:', xhr.status);
        }
    }
};
xhr.send();
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
                        let a = '<option value="0">Hepsi</option>';
                        a+= '<option value="-1">Genel</option>';
                        if (data.success == 1) {
                            for (var i = 0; i < data.companies.length; i++) {
                                a += '<option value="' + data.companies[i]["company_id"] + '">' + data.companies[i]["company_name"] + '</option>';
                            }
                            $("#idCompany").html('');
                            $("#idCompany").html(a);
                            $("#idCompany").change(function () {
                                var selectedCompanyId = $(this).val();
                                if (selectedCompanyId == "0") {
                                    updateTable(productListAllData);
                                } else {
                                    var filteredData = productListAllData.filter(function (item) {
                                        return item.company_id == selectedCompanyId;
                                    });
                                    updateTable(filteredData);
                                }
                            });
                        }
                    }
                });
            }
        }
    });
}
function updateTable(data) {
    var tableData = data.map(function (item) {
        return {
            id: item.story_id,
            story_small_image: item.story_small_image,
            story_big_image: item.story_big_image,
            story_title: item.story_title,
            company_name: item.company_name,
            story_state: item.story_state,
            story_priority: item.story_priority,
        };
    });
    productListAll.updateConfig({
        data: tableData
    }).forceRender();
}


var inputValueJson = sessionStorage.getItem('inputValue');
if (inputValueJson) {
    inputValueJson = JSON.parse(inputValueJson);
    Array.from(inputValueJson).forEach(element => {
        productListAllData.unshift(element);
    });
}

var editinputValueJson = sessionStorage.getItem('editInputValue');
if (editinputValueJson) {
    editinputValueJson = JSON.parse(editinputValueJson);
    productListAllData = productListAllData.map(function (item) {
        if (item.id == editinputValueJson.id) {
            return editinputValueJson;
        }
        return item;
    });
}
document.getElementById("addproduct-btn").addEventListener("click", function () {
    sessionStorage.setItem('editInputValue', "")
})

var productListAll = new gridjs.Grid({
    columns: [{
            name: '#',
            width: '40px',
            sort: {
                enabled: false
            },
            data: (function (row) {
                return gridjs.html('<div class="form-check checkbox-product-list">\
					<input class="form-check-input" type="checkbox" value="' + row.id + '" id="checkbox-' + row.id + '">\
					<label class="form-check-label" for="checkbox-' + row.id + '"></label>\
				  </div>');
            })
        },
        {
            name: 'Küçük Resim',
            width: '100px',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-shrink-0 me-3">' +
                    '<div class="avatar-sm bg-light rounded p-1"><img src="' + row.story_small_image + '" alt="" class="img-fluid d-block"></div>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Büyük Resim',
            width: '100px',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-shrink-0 me-3">' +
                    '<div class="avatar-sm bg-light rounded p-3"><img src="' + row.story_big_image + '" alt="" class="img-fluid d-block"></div>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Başlık',
            width: '100px',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<h5 class="fs-14 mb-1"><a href="javascript:detay(' + row.id+ ')" class="text-body">' + row.story_title + '</a></h5>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Firma',
            width: '100px',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<p class="text-muted mb-0"><span class="fw-medium">' + row.company_name + '</span></p>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Öncelik Sırası',
            width: '100px',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<p class="text-muted mb-0"><span class="fw-medium">' + row.story_priority + '</span></p>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Durum',
            width: '100px',
            data: (function (row) {
                var statusText = row.story_state == 1 ? 'Aktif' : 'Pasif';
                var status = row.story_state == 1 ? 'badge bg-success-subtle text-success text-uppercase' : 'badge bg-danger-subtle text-danger text-uppercase';

                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<p class="text-muted mb-0"><span class="'+status+'">'+statusText+'</span></p>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: "İşlemler",
            width: '80px',
            sort: {
                enabled: false
            },
            formatter: (function (cell, row) {
                var x = new DOMParser().parseFromString(row._cells[0].data.props.content, "text/html").body.querySelector(".checkbox-product-list .form-check-input").value
                return gridjs.html('<div class="dropdown">' +
                    '<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
                    '<i class="ri-more-fill"></i>' +
                    '</button>' +
                    '<ul class="dropdown-menu dropdown-menu-end">' +
                    '<li><a class="dropdown-item edit-list" data-edit-id=' + x + ' href="javascript:detay(' + x+ ')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Güncelle</a></li>' +
                    '</ul>' +
                    '</div>');
            })
        }
    ],
    className: {
        th: 'text-muted',
    },
    pagination: {
        limit: 10
    },
    sort: true,
    data: productListAllData
}).render(document.getElementById("table-product-list-all"));


// Search product list
var searchProductList = document.getElementById("searchProductList");
searchProductList.addEventListener("keyup", function () {
    var inputVal = searchProductList.value.toLowerCase();

    function filterItems(arr, query) {

        return arr.filter(function (el) {
            return el.story_title.toLowerCase().indexOf(query.toLowerCase()) !== -1
        })
    }

    var filterData = filterItems(productListAllData, inputVal);
    productListAll.updateConfig({
        data: filterData
    }).forceRender();


    checkRemoveItem();
});

// uniquestory_stateValues dizisini başlangıçta boş olacak şekilde tanımla
let uniquestory_stateValues = [];
function tikla(selectedValue, i) {
    const isChecked = document.getElementById("productBrandRadio" + i).checked;
    if (!isChecked) {
        uniquestory_stateValues = uniquestory_stateValues.filter(value => value !== selectedValue);
    } else {
        if (!uniquestory_stateValues.includes(selectedValue)) {
            uniquestory_stateValues.push(selectedValue);
        }
    }
    const filteredData = productListAllData.filter(item => uniquestory_stateValues.includes(item.story_state));
    updateTable(filteredData);
}
Array.from(document.querySelectorAll('.filter-list a')).forEach(function (filteritem) {
    filteritem.addEventListener("click", function () {
        var filterListItem = document.querySelector(".filter-list a.active");
        if (filterListItem) filterListItem.classList.remove("active");
        filteritem.classList.add('active');

        var filterItemValue = filteritem.querySelector(".listname").innerHTML
        var filterData = productListAllData.filter(filterlist => filterlist.company_name === filterItemValue);

        productListAll.updateConfig({
            data: filterData
        }).forceRender();

        uniquestory_stateValues = [...new Set(filterData.map(item => item.story_state))];
        let s = "";
        for (let i = 0; i < uniquestory_stateValues.length; i++) {
            s += '<div class="form-check">';
            s += '    <input class="form-check-input" type="checkbox" value="' + uniquestory_stateValues[i] + '" checked';
            s += '        id="productBrandRadio' + i + '" onclick="tikla(\'' + uniquestory_stateValues[i] + '\',' + i + ')">';
            s += '    <label class="form-check-label"';
            s += '        for="productBrandRadio' + i + '">' + uniquestory_stateValues[i] + '</label>';
            s += '</div>';
        }

        $("#tik").html(s);
        checkRemoveItem();
    });
});


var minCostInput = document.getElementById('minCost'),
    maxCostInput = document.getElementById('maxCost');

var filterDataAll = '';
var filterDataPublished = '';


var isSelected = 0;

function checkRemoveItem() {
    var tabEl = document.querySelectorAll('a[data-bs-toggle="tab"]');
    Array.from(tabEl).forEach(function (el) {
        el.addEventListener('show.bs.tab', function (event) {
            isSelected = 0;
            document.getElementById("selection-element").style.display = 'none';
        });
    });
    setTimeout(function () {
        Array.from(document.querySelectorAll(".checkbox-product-list input")).forEach(function (item) {
            item.addEventListener('click', function (event) {
                if (event.target.checked == true) {
                    event.target.closest('tr').classList.add("gridjs-tr-selected");
                } else {
                    event.target.closest('tr').classList.remove("gridjs-tr-selected");
                }

                var checkboxes = document.querySelectorAll('.checkbox-product-list input:checked');
                isSelected = checkboxes.length;

                if (event.target.closest('tr').classList.contains("gridjs-tr-selected")) {
                    document.getElementById("select-content").innerHTML = isSelected;
                    (isSelected > 0) ? document.getElementById("selection-element").style.display = 'block': document.getElementById("selection-element").style.display = 'none';
                } else {

                    document.getElementById("select-content").innerHTML = isSelected;
                    (isSelected > 0) ? document.getElementById("selection-element").style.display = 'block': document.getElementById("selection-element").style.display = 'none';
                }
            });
        });
        removeItems();
        removeSingleItem();
    }, 100);
}


// check to remove item
var checkboxes = document.querySelectorAll('.checkbox-wrapper-mail input');

function removeItems() {
    var removeItem = document.getElementById('removeItemModal');
    removeItem.addEventListener('show.bs.modal', function (event) {
        isSelected = 0;
        document.getElementById("delete-product").addEventListener("click", function () {
            Array.from(document.querySelectorAll(".gridjs-table tr")).forEach(function (element) {
                var filtered = '';
                if (element.classList.contains("gridjs-tr-selected")) {
                    var getid = element.querySelector('.form-check-input').value;
					console.log(getid);
                    function arrayRemove(arr, value) {
                        return arr.filter(function (ele) {
                            return ele.id != value;
                        });
                    }
                    var filtered = arrayRemove(productListAllData, getid);
                    productListAllData = filtered;
                    element.remove();
                }
            });
            document.getElementById("btn-close").click();
            if (document.getElementById("selection-element"))
                document.getElementById("selection-element").style.display = 'none';

            checkboxes.checked = false;
        });
    })
}

function removeSingleItem() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (item) {
        item.addEventListener('click', function (event) {
            getid = item.getAttribute('data-id');
            document.getElementById("delete-product").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                var filtered = arrayRemove(productListAllData, getid);
                productListAllData = filtered;
                var element = item.closest(".gridjs-tr");
                element.remove();
            });
        });
    });


    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');

            productListAllData = productListAllData.map(function (item) {
                if (item.id == getEditid) {

                    sessionStorage.setItem('editInputValue', JSON.stringify(item));
                }
                return item;
            });
        });
    });
}
function detay(id) {
    window.location.href = "https://mobiloby.app/koluman/web/storydetail/" + id;

}