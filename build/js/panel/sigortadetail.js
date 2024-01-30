$(document).ready(function () {
    var id = getIdFromUrl();

    if (id !== null) {
        console.log("URL'deki ID: ", id);
        // Diğer işlemleri yapabilirsiniz.
    } else {
        console.log("URL'de ID bulunamadı.");
    }
});

function getIdFromUrl() {
    var url = window.location.href;
    var match = url.match(/\/sigortadetail\/(\d+)/);

    if (match && match[1]) {
        return parseInt(match[1], 10);
    } else {
        return null;
    }
}
