/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Gallery init
*/

// Portfolio Filter
document.addEventListener("DOMContentLoaded", function (event) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    var id = getIdFromUrl();
    if (id != "" && id != null) getdetail(id);
    else add();
    // init Isotope
    var GalleryWrapper = document.querySelector('.gallery-wrapper');
    if (GalleryWrapper) {
        var iso = new Isotope('.gallery-wrapper', {
            itemSelector: '.element-item',
            layoutMode: 'fitRows'
        });
    }

    // bind filter button click
    var filtersElem = document.querySelector('.categories-filter');
    if (filtersElem) {
        filtersElem.addEventListener('click', function (event) {
            // only work with buttons
            if (!matchesSelector(event.target, 'li a')) {
                return;
            }
            var filterValue = event.target.getAttribute('data-filter');
            if (filterValue) {
                // use matching filter function
                iso.arrange({
                    filter: filterValue
                });
            }
        });
    }

    // change is-checked class on buttons
    var buttonGroups = document.querySelectorAll('.categories-filter');
    if (buttonGroups) {
        Array.from(buttonGroups).forEach(function (btnGroup) {
            var buttonGroup = btnGroup;
            radioButtonGroup(buttonGroup);
        });
    }

    function getIdFromUrl() {
        var url = window.location.href;
        var match = url.match(/\/gallery\/(\d+)/);

        if (match && match[1]) {
            return parseInt(match[1], 10);
        } else {
            return null;
        }
    }

    function radioButtonGroup(buttonGroup) {
        buttonGroup.addEventListener('click', function (event) {
            // only work with buttons
            if (!matchesSelector(event.target, 'li a')) {
                return;
            }
            buttonGroup.querySelector('.active').classList.remove('active');
            event.target.classList.add('active');
        });
    }

    function getdetail(id) {
        $.ajax({
            type: 'GET',
            url: 'https://mobiloby.app/koluman/web/getApiToken',
            dataType: 'json',
            success: function (data) {
                $.ajax({
                    type: 'POST',
                    url: 'https://mobiloby.app/koluman/web/getshowroomdetail',
                    dataType: 'json',
                    headers: {
                        "Authorization": 'Bearer ' + data.token
                    },
                    data: {
                        car_id: id,
                        _token: csrfToken, // CSRF token'ını gönder
                    },
                    success: function (data) {
                        console.log(data);
                    }

                });
            }
        });
    }

    function add() {
        console.log("ekle");
    }

});


// GLightbox Popup
var lightbox = GLightbox({
    selector: '.image-popup',
    title: false,
});
