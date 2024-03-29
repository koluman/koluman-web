var apiEndpoint = '/getshowroomcars';
var productListAllData = [];
var xhr = new XMLHttpRequest();
xhr.open('GET', apiEndpoint, true);

xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
        if (xhr.status == 200) {
            var responseData = JSON.parse(xhr.responseText);
            productListAllData = responseData.showroomcars; 
            updateTable(productListAllData);
        } else {
            console.error('Sunucu hatası:', xhr.status);
        }
    }
};

xhr.send();
function updateTable(data) {
    // Tabloyu güncelleme işlemleri burada yapılır
    // Veriyi tablo veri yapısına uygun hale getirin (eğer gerekirse)
    var tableData = data.map(function (item) {
        return {
            id: item.car_id,
            car_image_url: item.car_image_url,
            car_name: item.car_name,
            company_name: item.company_name,
            step1: item.step1,
            step2: item.step2,
            step3: item.step3,
            step4: item.step4,
            step5: item.step5,
        };
    });

    // Tabloyu güncelle
    productListAll.updateConfig({
        data: tableData
    }).forceRender();
}



// table-product-list-all 

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
            name: 'Araba Bilgileri',
            width: '360px',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-shrink-0 me-3">' +
                    '<div class="avatar-sm bg-light rounded p-1"><img src="' + row.car_image_url + '" alt="" class="img-fluid d-block"></div>' +
                    '</div>' +
                    '<div class="flex-grow-1">' +
                    '<h5 class="fs-14 mb-1"><a href="javascript:detay(' + row.id+ ')" class="text-body">' + row.car_name + '</a></h5>' +
                    '<p class="text-muted mb-0">Firma : <span class="fw-medium">' + row.company_name + '</span></p>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Step1',
            width: '101px',
            formatter: (function (cell) {
                return gridjs.html(cell);
            })
        },
        {
            name: 'Step2',
            width: '84px',
        },
        {
            name: 'Step3',
            width: '105px',
            formatter: (function (cell) {
                return gridjs.html('<span class="badge bg-light text-body fs-12 fw-medium">' + cell + '</span></td>');
            })
        },
        {
            name: 'Step4',
            width: '84px',
        },
        {
            name: 'Step5',
            width: '84px',
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
                    '<li><a class="dropdown-item"  href="javascript:void(0);" onclick="javascript:redirectToGaleri(' + x+ ')"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Galeri</a></li>' +
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

function redirectToGaleri(id) {
    var yeniSayfaURL = "gallery/"+id;
    window.location.href = yeniSayfaURL;
}
// Search product list
var searchProductList = document.getElementById("searchProductList");
searchProductList.addEventListener("keyup", function () {
    var inputVal = searchProductList.value.toLowerCase();

    function filterItems(arr, query) {

        return arr.filter(function (el) {
            return el.car_name.toLowerCase().indexOf(query.toLowerCase()) !== -1
        })
    }

    var filterData = filterItems(productListAllData, inputVal);
    productListAll.updateConfig({
        data: filterData
    }).forceRender();


    checkRemoveItem();
});

// uniqueStep1Values dizisini başlangıçta boş olacak şekilde tanımla
let uniqueStep1Values = [];
function tikla(selectedValue, i) {
    const isChecked = document.getElementById("productBrandRadio" + i).checked;
    if (!isChecked) {
        uniqueStep1Values = uniqueStep1Values.filter(value => value !== selectedValue);
    } else {
        if (!uniqueStep1Values.includes(selectedValue)) {
            uniqueStep1Values.push(selectedValue);
        }
    }
    const filteredData = productListAllData.filter(item => uniqueStep1Values.includes(item.step1));
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

        uniqueStep1Values = [...new Set(filterData.map(item => item.step1))];
        let s = "";
        for (let i = 0; i < uniqueStep1Values.length; i++) {
            s += '<div class="form-check">';
            s += '    <input class="form-check-input" type="checkbox" value="' + uniqueStep1Values[i] + '" checked';
            s += '        id="productBrandRadio' + i + '" onclick="tikla(\'' + uniqueStep1Values[i] + '\',' + i + ')">';
            s += '    <label class="form-check-label"';
            s += '        for="productBrandRadio' + i + '">' + uniqueStep1Values[i] + '</label>';
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







// Search Brands Options
var searchBrandsOptions = document.getElementById("searchBrandsList");
searchBrandsOptions.addEventListener("keyup", function () {
    var inputVal = searchBrandsOptions.value.toLowerCase();
    var searchItem = document.querySelectorAll("#flush-collapseBrands .form-check");
    Array.from(searchItem).forEach(function (elem) {
        var searchBrandsTxt = elem.getElementsByClassName("form-check-label")[0].innerText.toLowerCase();
        elem.style.display = searchBrandsTxt.includes(inputVal) ? "block" : "none";
    })
});

// table select to remove
// checkbox-wrapper
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
    window.location.href = "showroomdetail/" + id;

}