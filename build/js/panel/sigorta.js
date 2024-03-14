$(document).ready(function () {
    sigorta();
});
let sigortadata = [];
let csrfToken = $('meta[name="csrf-token"]').attr('content');
let sayi;

function sigorta() {
    $.ajax({
        type: 'POST',
        url: 'getallsigorta',
        data: {
            _token: csrfToken, 
        },
        dataType: 'json',
        success: function (data) {

            if (data.success == 1) {
                sigortadata = data.sigortaall;
                sayi=data.sigortaall.length;
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
    let dizi = ["Talep Oluştu", "İncelemede", "Teklif Oluştu", "Aktif", "İptal Edildi"];
    let durumSayilari = {};
    data.forEach(function (veri) {
        let durum = veri.insurance_state;
        if (durumSayilari.hasOwnProperty(durum)) {
            durumSayilari[durum]++;
        } else {
            durumSayilari[durum] = 1;
        }
    });
    for (let durum in durumSayilari) {
        let a = "#" + durum;
        $(a).text(durumSayilari[durum]);
    }
    $("#0").text(sayi);
    for (let i = 0; i < data.length; i++) {
        j++;
        s += '<tr>';
        s += '<th scope="row">';
        s += '    <div class="form-check">';
        s += '        <input class="form-check-input" type="checkbox" name="checkAll" value="option1">';
        s += '    </div>';
        s += '</th>';
        s += '<td class="id"><a href="javascript:detay(' + data[i].insurance_id + ')" class="fw-medium link-primary">#' + j + '</a></td>';
        s += '<td hidden class="user">' + data[i].user_id + '</td>';
        s += '<td class="username">' + data[i].user_name + '</td>';
        s += '<td class="insurancetype">' + data[i].insurance_type + '</td>';
        s += '<td class="insuranceprice">' + data[i].insurance_price + '</td>';
        s += '<td class="insurancedescription">' + data[i].insurance_description + '</td>';
        if (data[i].insurance_state >= 1 && data[i].insurance_state <= 5) {
            let durumMetni = dizi[data[i].insurance_state - 1];
            s += '<td class="insurancestate">' + durumMetni + '</td>';
        }
        s += '<td>';
        s += '    <ul class="list-inline hstack gap-2 mb-0">';
        s += '        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Detay">';
        s += '            <a href="javascript:detay(' + data[i].insurance_id + ')" class="text-primary d-inline-block">';
        s += '                <i class="ri-eye-fill fs-16"></i>';
        s += '            </a>';
        s += '        </li>';
        s += '        <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Poliçe PDF">';
        s += '            <a href="' + data[i].insurance_policy_url + '" target="_blank"  class="text-primary d-inline-block edit-item-btn">';
        s += '                <i class=" ri-file-pdf-fill fs-16"></i>';
        s += '            </a>';
        s += '        </li>';
        s += '    </ul>';
        s += '</td>';
        s += '</tr>';
    }
    return s;

}

function detay(id) {
    window.location.href = "sigortadetail/" + id;

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
        case "İptal":
            veri = filterSigortaByState(5);
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

    // Status filtresi
    if (selectedStatus && selectedStatus !== "all") {
        filteredData = filteredData.filter(function (sigorta) {
            return sigorta.insurance_state == selectedStatus;
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

document.getElementById("createsigorta").addEventListener("click", function () {
    window.location.href = "sigortadetail";
});
