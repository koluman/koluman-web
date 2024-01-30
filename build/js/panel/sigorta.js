$(document).ready(function () {
    sigorta();
});
let sigortadata = [];
let csrfToken = $('meta[name="csrf-token"]').attr('content');

function sigorta() {
    console.log("ff");

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getallsigorta',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {

            if(data.success==1){
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