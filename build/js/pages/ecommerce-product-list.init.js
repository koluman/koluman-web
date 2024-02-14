/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce product list Js File
*/

// API endpoint'i (örnek URL, kendi API URL'nizi kullanmalısınız)
var apiEndpoint = 'https://mobiloby.app/koluman/web/getshowroomcars';

// AJAX isteği
var xhr = new XMLHttpRequest();
xhr.open('GET', apiEndpoint, true);

xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
        if (xhr.status == 200) {
            var responseData = JSON.parse(xhr.responseText);
            // Sunucudan gelen veriyi kullanarak tabloyu güncelleyebilirsiniz
            updateTable(responseData.showroomcars);
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
            product: {
                img: item.car_image_url,
                title: item.car_name,
				category: item.company_name
            },
            step1: item.step1,
            orders: item.step2,
            rating: item.step3,
            published: {
                publishDate: item.car_description,
                publishTime: item.step4
            }
        };
    });

    // Tabloyu güncelle
    productListAll.updateConfig({ data: tableData }).forceRender();
}



// table-product-list-all 
var productListAllData = [
];

var inputValueJson = sessionStorage.getItem('inputValue');
if (inputValueJson) {
	inputValueJson = JSON.parse(inputValueJson);
	Array.from(inputValueJson).forEach(element => {
		productListAllData.unshift(element);
	});
}

var editinputValueJson = sessionStorage.getItem('editInputValue');
if(editinputValueJson){
	editinputValueJson = JSON.parse(editinputValueJson);
	productListAllData = productListAllData.map(function (item) {
		if (item.id == editinputValueJson.id) {
			return editinputValueJson;
		}
		return item;
	});
}
document.getElementById("addproduct-btn").addEventListener("click", function(){
	sessionStorage.setItem('editInputValue',"")
})

var productListAll = new gridjs.Grid({
	columns:
		[
			{
				name: '#',
				width: '40px',
				sort: {
					enabled: false
				},
				data: (function (row) {
					return gridjs.html('<div class="form-check checkbox-product-list">\
					<input class="form-check-input" type="checkbox" value="'+ row.id + '" id="checkbox-' + row.id + '">\
					<label class="form-check-label" for="checkbox-'+ row.id + '"></label>\
				  </div>');
				})
			},
			{
				name: 'Araba Bilgileri',
				width: '360px',
				data: (function (row) {
					return gridjs.html('<div class="d-flex align-items-center">' +
						'<div class="flex-shrink-0 me-3">' +
						'<div class="avatar-sm bg-light rounded p-1"><img src="' + row.product.img + '" alt="" class="img-fluid d-block"></div>' +
						'</div>' +
						'<div class="flex-grow-1">' +
						'<h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details" class="text-body">' + row.product.title + '</a></h5>' +
						'<p class="text-muted mb-0">Firma : <span class="fw-medium">' + row.product.category + '</span></p>' +
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
				name: 'Orders',
				width: '84px',
			},
			{
				name: 'Rating',
				width: '105px',
				formatter: (function (cell) {
					return gridjs.html('<span class="badge bg-light text-body fs-12 fw-medium">' + cell + '</span></td>');
				})
			},
			{
				name: 'Published',
				width: '220px',
				data: (function (row) {
					return gridjs.html(row.published.publishDate + '<small class="text-muted ms-1">' + row.published.publishTime + '</small>');
				})
			},
			{
				name: "Action",
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
						'<li><a class="dropdown-item" href="apps-ecommerce-product-details"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>' +
						'<li><a class="dropdown-item edit-list" data-edit-id=' + x + ' href="apps-ecommerce-add-product"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>' +
						'<li class="dropdown-divider"></li>' +
						'<li><a class="dropdown-item remove-list" href="#" data-id=' + x + ' data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>' +
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

// table-product-list-published
var productListPublishedData = [

]

var productListPublished = new gridjs.Grid({
	columns:
		[
			{
				name: '#',
				width: '40px',
				sort: {
					enabled: false
				},
				formatter: (function (cell) {
					return gridjs.html('<div class="form-check checkbox-product-list">\
					<input class="form-check-input" type="checkbox" value="'+ cell + '" id="checkboxpublished-' + cell + '">\
					<label class="form-check-label" for="checkbox-'+ cell + '"></label>\
				  </div>');
				})
			},
			{
				name: 'Product',
				width: '360px',
				data: (function (row) {
					return gridjs.html('<div class="d-flex align-items-center">' +
						'<div class="flex-shrink-0 me-3">' +
						'<div class="avatar-sm bg-light rounded p-1"><img src="' + row.product.img + '" alt="" class="img-fluid d-block"></div>' +
						'</div>' +
						'<div class="flex-grow-1">' +
						'<h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details" class="text-body">' + row.product.title + '</a></h5>' +
						'<p class="text-muted mb-0">Category : <span class="fw-medium">' + row.product.category + '</span></p>' +
						'</div>' +
						'</div>');
				})
			},
			{
				name: 'Stock',
				width: '94px',
			},
			{
				name: 'Step1',
				width: '101px',
				formatter: (function (cell) {
					return gridjs.html('$' + cell);
				})
			},
			{
				name: 'Orders',
				width: '84px',
			},
			{
				name: 'Rating',
				width: '105px',
				formatter: (function (cell) {
					return gridjs.html('<span class="badge bg-light text-body fs-12 fw-medium"><i class="mdi mdi-star text-warning me-1"></i>' + cell + '</span></td>');
				})
			},
			{
				name: 'Published',
				width: '220px',
				data: (function (row) {
					return gridjs.html(row.published.publishDate + '<small class="text-muted ms-1">' + row.published.publishTime + '</small>');
				})
			},
			{
				name: "Action",
				width: '80px',
				sort: {
					enabled: false
				},
				formatter: (function (cell, row) {
					return gridjs.html('<div class="dropdown">' +
						'<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
						'<i class="ri-more-fill"></i>' +
						'</button>' +
						'<ul class="dropdown-menu dropdown-menu-end">' +
						'<li><a class="dropdown-item" href="apps-ecommerce-product-details"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>' +
						'<li><a class="dropdown-item" href="apps-ecommerce-add-product"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>' +
						'<li class="dropdown-divider"></li>' +
						'<li><a class="dropdown-item remove-list" href="#" data-id=' + row._cells[0].data + ' data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>' +
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
	data: productListPublishedData
}).render(document.getElementById("table-product-list-published"));


// Search product list
var searchProductList = document.getElementById("searchProductList");
searchProductList.addEventListener("keyup", function () {
	var inputVal = searchProductList.value.toLowerCase();
	function filterItems(arr, query) {
		return arr.filter(function (el) {
			return el.product.title.toLowerCase().indexOf(query.toLowerCase()) !== -1
		})
	}

	var filterData = filterItems(productListAllData, inputVal);
	var filterPublishData = filterItems(productListPublishedData, inputVal);
	productListAll.updateConfig({
		data: filterData
	}).forceRender();

	productListPublished.updateConfig({
		data: filterPublishData
	}).forceRender();
	checkRemoveItem();
});

// mail list click event
Array.from(document.querySelectorAll('.filter-list a')).forEach(function (filteritem) {
	filteritem.addEventListener("click", function () {
		var filterListItem = document.querySelector(".filter-list a.active");
		if (filterListItem) filterListItem.classList.remove("active");
		filteritem.classList.add('active');

		var filterItemValue = filteritem.querySelector(".listname").innerHTML

		var filterData = productListAllData.filter(filterlist => filterlist.product.category === filterItemValue);
		var filterPublishedData = productListPublishedData.filter(filterlist => filterlist.product.category === filterItemValue);

		productListAll.updateConfig({
			data: filterData
		}).forceRender();

		productListPublished.updateConfig({
			data: filterPublishedData
		}).forceRender();

		checkRemoveItem();
	});
})

// price range slider
var slider = document.getElementById('product-price-range');

noUiSlider.create(slider, {
	start: [0, 2000], // Handle start position
	step: 10, // Slider moves in increments of '10'
	margin: 20, // Handles must be more than '20' apart
	connect: true, // Display a colored bar between the handles
	behaviour: 'tap-drag', // Move handle on tap, bar is draggable
	range: { // Slider can select '0' to '100'
		'min': 0,
		'max': 2000
	},
	format: wNumb({ decimals: 0, prefix: '$ ' })
});

var minCostInput = document.getElementById('minCost'),
	maxCostInput = document.getElementById('maxCost');

var filterDataAll = '';
var filterDataPublished = '';

// When the slider value changes, update the input and span
slider.noUiSlider.on('update', function (values, handle) {
	var productListupdatedAll = productListAllData;
	var productListupdatedPublished = productListPublishedData;
	if (handle) {
		maxCostInput.value = values[handle];

	} else {
		minCostInput.value = values[handle];
	}

	var maxvalue = maxCostInput.value.substr(2);
	var minvalue = minCostInput.value.substr(2);
	filterDataAll = productListupdatedAll.filter(
		product => parseFloat(product.price) >= minvalue && parseFloat(product.price) <= maxvalue
	);
	filterDataPublished = productListupdatedPublished.filter(
		product => parseFloat(product.price) >= minvalue && parseFloat(product.price) <= maxvalue
	);
	productListAll.updateConfig({
		data: filterDataAll
	}).forceRender();
	productListPublished.updateConfig({
		data: filterDataPublished
	}).forceRender();
	checkRemoveItem();
});


minCostInput.addEventListener('change', function () {
	slider.noUiSlider.set([null, this.value]);
});

maxCostInput.addEventListener('change', function () {
	slider.noUiSlider.set([null, this.value]);
});

// text inputs example
var filterChoicesInput = new Choices(
	document.getElementById('filter-choices-input'),
	{
		addItems: true,
		delimiter: ',',
		editItems: true,
		maxItemCount: 10,
		removeItems: true,
		removeItemButton: true,
	}
)

// sidebar filter check
Array.from(document.querySelectorAll(".filter-accordion .accordion-item")).forEach(function (item) {
	var isFilterSelected = item.querySelectorAll(".filter-check .form-check .form-check-input:checked").length;
	item.querySelector(".filter-badge").innerHTML = isFilterSelected;
	Array.from(item.querySelectorAll(".form-check .form-check-input")).forEach(function (subitem) {
		var checkElm = subitem.value;
		if (subitem.checked) {
			filterChoicesInput.setValue([checkElm]);
		}
		subitem.addEventListener("click", function (event) {
			if (subitem.checked) {
				isFilterSelected++;
				item.querySelector(".filter-badge").innerHTML = isFilterSelected;
				(isFilterSelected > 0) ? item.querySelector(".filter-badge").style.display = 'block' : item.querySelector(".filter-badge").style.display = 'none';
				filterChoicesInput.setValue([checkElm]);

			} else {
				filterChoicesInput.removeActiveItemsByValue(checkElm);
			}
		});
		filterChoicesInput.passedElement.element.addEventListener('removeItem', function (event) {
			if (event.detail.value == checkElm) {
				subitem.checked = false;
				isFilterSelected--;
				item.querySelector(".filter-badge").innerHTML = isFilterSelected;
				(isFilterSelected > 0) ? item.querySelector(".filter-badge").style.display = 'block' : item.querySelector(".filter-badge").style.display = 'none';
			}
		}, false);
		// clearall
		document.getElementById("clearall").addEventListener("click", function () {
			subitem.checked = false;
			filterChoicesInput.removeActiveItemsByValue(checkElm);
			isFilterSelected = 0;
			item.querySelector(".filter-badge").innerHTML = isFilterSelected;
			(isFilterSelected > 0) ? item.querySelector(".filter-badge").style.display = 'block' : item.querySelector(".filter-badge").style.display = 'none';
			productListAll.updateConfig({
				data: productListAllData
			}).forceRender();

			productListPublished.updateConfig({
				data: productListPublishedData
			}).forceRender();
		});
	});
});

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
					(isSelected > 0) ? document.getElementById("selection-element").style.display = 'block' : document.getElementById("selection-element").style.display = 'none';
				} else {

					document.getElementById("select-content").innerHTML = isSelected;
					(isSelected > 0) ? document.getElementById("selection-element").style.display = 'block' : document.getElementById("selection-element").style.display = 'none';
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
					function arrayRemove(arr, value) {
						return arr.filter(function (ele) {
							return ele.id != value;
						});
					}
					var filtered = arrayRemove(productListAllData, getid);
					var filteredPublished = arrayRemove(productListPublishedData, getid);
					productListAllData = filtered;
					productListPublishedData = filteredPublished;
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
				var filteredPublished = arrayRemove(productListPublishedData, getid);
				productListAllData = filtered;
				productListPublishedData = filteredPublished;
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