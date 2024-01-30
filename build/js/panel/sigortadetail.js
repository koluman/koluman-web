$(document).ready(function () {
    var id = getIdFromUrl();
    getdetail(id);
});
var csrfToken = $('meta[name="csrf-token"]').attr('content');
function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/sigortadetail\/(\d+)/);

    if (match && match[1]) {
        return parseInt(match[1], 10);
    } else {
        return null;
    }
}
function getdetail(id){
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getbyIdSigorta',
        dataType: 'json',
        data: {
            id:id,
            _token: csrfToken, // CSRF token'ını gönder
        },
        success: function (data) {
            console.log(data);
            /*if (data.success == 1) {
                sigortadata = data.sigortaall;
                let son = sigortalist(sigortadata);
                $("#sigortalist").html('');
                $("#sigortalist").html(son);
            }*/

        }
    });
}