var announcementListAllData = [];
document.addEventListener('DOMContentLoaded', function () {
    announcements();
    getcompany();
});

function getcompany() {
    $.ajax({
        type: 'GET',
        url: 'getApiToken',
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                $.ajax({
                    type: 'GET',
                    url: 'api/getcompanies',
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
                        }
                    }
                });
            }
        }
    });
}
function announcements() {
    $.ajax({
            type: 'GET',
            url: 'getApiToken',
            dataType: 'json',
            success: function (data) {
                if (data.success == 1) {
                    $.ajax({
                        type: 'GET',
                        url: 'api/getannouncement',
						headers: {
							"Authorization": "Bearer " + data.token, // Boşluk ekleyin
						},
                        dataType: 'json',
                        success: function (data) {
							if (data.success == 1) {
                                announcementListAllData = data.announcement; // announcementListAllData dizisini güncelle
                                updateTable(announcementListAllData);
							}
							
                        }
                    });
                }
            }
        }) 
}

function updateTable(data) {
    var tableData = data.map(function (item) {
        return {
            id: item.announcement_id,
            announcement_image_url: item.announcement_image_url,
            announcement_title: item.announcement_title,
            announcement_description: item.announcement_description,
            company_name: item.company_name,

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
        announcementListAllData.unshift(element);
    });
}

var editinputValueJson = sessionStorage.getItem('editInputValue');
if (editinputValueJson) {
    editinputValueJson = JSON.parse(editinputValueJson);
    announcementListAllData = announcementListAllData.map(function (item) {
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
            name: 'Resim',
            width: '84',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-shrink-0 me-3">' +
                    '<div class="avatar-sm bg-light rounded p-1"><img src="' + row.announcement_image_url + '" alt="" class="img-fluid d-block"></div>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Başlık',
            width: '84',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<h5 class="fs-14 mb-1"><a href="javascript:detay(' + row.id+ ')" class="text-body">' + row.announcement_title + '</a></h5>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Firma',
            width: '84',
            data: (function (row) {
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<h5 class="fs-14 mb-1"><a href="javascript:detay(' + row.id+ ')" class="text-body">' + row.company_name + '</a></h5>' +
                    '</div>' +
                    '</div>');
            })
        },
        {
            name: 'Açıklama',
            width: '300px',
            data: (function (row) {
                // Define the maximum number of characters to display
                var maxChars = 100;
        
                // Truncate the description if it exceeds the maximum characters
                var truncatedDescription = row.announcement_description.length > maxChars ?
                    row.announcement_description.substring(0, maxChars) + '...' :
                    row.announcement_description;
        
                return gridjs.html('<div class="d-flex align-items-center">' +
                    '<div class="flex-grow-1">' +
                    '<p class="text-muted mb-0"><span class="fw-medium">' + truncatedDescription + '</span></p>' +
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
    data: announcementListAllData
}).render(document.getElementById("table-product-list-all"));


// Search product list
var searchProductList = document.getElementById("searchProductList");
searchProductList.addEventListener("keyup", function () {
    var inputVal = searchProductList.value.toLowerCase();

    function filterItems(arr, query) {

        return arr.filter(function (el) {
            return el.announcement_title.toLowerCase().indexOf(query.toLowerCase()) !== -1
        })
    }

    var filterData = filterItems(announcementListAllData, inputVal);
    productListAll.updateConfig({
        data: filterData
    }).forceRender();


    checkRemoveItem();
});



var filterDataAll = '';
var filterDataPublished = '';

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
                var filtered = arrayRemove(announcementListAllData, getid);
                announcementListAllData = filtered;
                var element = item.closest(".gridjs-tr");
                element.remove();
            });
        });
    });


    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');

            announcementListAllData = announcementListAllData.map(function (item) {
                if (item.id == getEditid) {

                    sessionStorage.setItem('editInputValue', JSON.stringify(item));
                }
                return item;
            });
        });
    });
}
function detay(id) {
    window.location.href = "announcementsdetail/" + id;

}
function SearchData() {
    var selectedStatus = $("#idStatus").val();
    var selectedCompany = $("#idCompany").val();

    var searchText = $('#searchProductList').val().toLowerCase();

    // Filtreleme ve arama işlemleri
    var filteredData = announcementListAllData;

    
    if (selectedStatus && selectedStatus !== "all") {

        filteredData = filteredData.filter(function (b) {
            return b.announcement_state == selectedStatus;
        });
    }
      
    if (selectedCompany === "-1") {
        filteredData = filteredData.filter(function (b) {
            return b.company_id == "-1";
        });
    } 
    else if (selectedCompany == "0") {

       
    }else {
        filteredData = filteredData.filter(function (b) {
            return b.company_id == selectedCompany || b.company_id == "-1";
        });
    }
    

    // Arama filtresi
    if (searchText) {
        filteredData = filteredData.filter(function (b) {
            return (
                b.announcement_title.includes(searchText) ||
                b.announcement_description.toLowerCase().includes(searchText)
            );
        });
    }

    productListAll.updateConfig({
        data: filteredData
    }).forceRender();

}
