let csrfToken = $('meta[name="csrf-token"]').attr('content');
let company;

document.addEventListener("DOMContentLoaded", function () {
    company = new Choices("#company_id", {
        searchEnabled: false
    });
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