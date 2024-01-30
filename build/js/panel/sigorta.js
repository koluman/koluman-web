$(document).ready(function () {
    sigorta();
});
let sigortadata = [];
let csrfToken = $('meta[name="csrf-token"]').attr('content');

function sigorta() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getallsigorta',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {

            if (data.success == 1) {
                sigortadata = data.sigortaall;
                let son = sigortalist(sigortadata);
                $("#sigortalist").html('');
                $("#sigortalist").html(son);
            }

        }
    });
}

function sigortalist(data) {
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
        s += '<td class="id"><a href="apps-ecommerce-order-details" class="fw-medium link-primary">#' + j + '</a></td>';
        s += '<td hidden class="user">' + data[i].user_id + '</td>';
        s += '<td class="username">' + data[i].user_name + '</td>';
        s += '<td class="insurancetype">' + data[i].insurance_type + '</td>';
        s += '<td class="insuranceprice">' + data[i].insurance_price + '</td>';
        s += '<td class="insurancedescription">' + data[i].insurance_description + '</td>';
        s += '<td class="insurancestate">' + data[i].insurance_state + '</td>';
        s += '<td>';
        s += '    <ul class="list-inline hstack gap-2 mb-0">';
        s += '        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">';
        s += '            <a href="apps-ecommerce-order-details" class="text-primary d-inline-block">';
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

function filterSigortaByState(state) {
    return sigortadata.filter(sigorta => sigorta.insurance_state === state);
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
            sonn = sigortalist(sigortadata);
            break;
        case "Talep":
            veri = filterSigortaByState(1);
            sonn = sigortalist(veri);
            break;
        case "İnceleme":
            veri = filterSigortaByState(2);
            sonn = sigortalist(veri);
            break;
        case "Teklif":
            veri = filterSigortaByState(3);
            sonn = sigortalist(veri);
            break;
        case "Aktif":
            veri = filterSigortaByState(4);
            sonn = sigortalist(veri);
            break;
        default:
            break;
    }
    $("#sigortalist").html('');
    $("#sigortalist").html(sonn);
});

$(document).on("input", '.search', function () {
    var searchText = $(this).val().toLowerCase();
    var filteredData = sigortadata.filter(function (sigorta) {
        return (
            sigorta.user_name.toLowerCase().includes(searchText) ||
            sigorta.insurance_type.toLowerCase().includes(searchText) ||
            sigorta.insurance_description.toLowerCase().includes(searchText)
        );
    });
    var son = sigortalist(filteredData);
    $("#sigortalist").html('');
    $("#sigortalist").html(son);
});

$(document).on("input", '.search', function () {
    // Arama yapıldığında filtreleme yap
    filterAndSearch();
});

function filterAndSearch() {
    var searchText = $('.search').val().toLowerCase();

    // Seçilen sekmeye göre kullanıcıları filtrele
    var filteredData = sigortadata;
    if (selectedTab !== "All") {
        filteredData = filterSigortaByState(selectedTab.toLowerCase());
    }

    // Arama yap
    filteredData = filteredData.filter(function (sigorta) {
        return (
            sigorta.user_name.toLowerCase().includes(searchText) ||
            sigorta.insurance_type.toLowerCase().includes(searchText) ||
            sigorta.insurance_description.toLowerCase().includes(searchText)
        );
    });

    // Listeyi güncelle
    var son = sigortalist(filteredData);
    $("#sigortalist").html('');
    $("#sigortalist").html(son);
}

function SearchData() {
    var selectedStatus = $("#idStatus").val();
    var searchText = $('.search').val().toLowerCase();
    // Filtreleme ve arama işlemleri
    var filteredData = sigortadata;
    console.log(selectedStatus);
    console.log(filteredData);

    // Yetki filtresi
    if (selectedStatus && selectedStatus !== "all") {
        filteredData = filteredData.filter(function (sigorta) {
            return sigorta.insurance_state === selectedStatus;
        });
    }

    // Arama filtresi
    if (searchText) {
        filteredData = filteredData.filter(function (sigorta) {
            return (
                sigorta.user_name.toLowerCase().includes(searchText) ||
                sigorta.insurance_type.toLowerCase().includes(searchText) ||
                sigorta.insurance_description.toLowerCase().includes(searchText)
            );
        });
    }
    updatePageWithFilteredData(filteredData);
}

function updatePageWithFilteredData(filteredData) {
    var son = sigortalist(filteredData);
    $("#sigortalist").html('');
    $("#sigortalist").html(son);
}


function updatePageWithFilteredData(filteredData) {
    var son = sigortalist(filteredData);
    $("#sigortalist").html('');
    $("#sigortalist").html(son);
}
