/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Gallery init
*/

// Portfolio Filter
itemid = 13;


// Dropzone
var dropzonePreviewNode = document.querySelector("#dropzone-preview3-list");
dropzonePreviewNode.itemid = "";
var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
var dropzone = new Dropzone(".dropzone", {
    url: 'https://httpbin.org/post',
    method: "post",
    previewTemplate: previewTemplate,
    previewsContainer: "#dropzone-preview3",
});
document.addEventListener("DOMContentLoaded", function (event) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

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

    
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var galleryId = this.getAttribute('data-id');
            $.ajax({
              type: 'POST',
              url: 'https://mobiloby.app/koluman/web/deletegallery',
              data: {
                id: galleryId,
                _token: csrfToken, // CSRF token'ını gönder
              },
              dataType: 'json',
              success: function (data) {
                if (data.success == 1) {
                  window.location.reload(); 
                } else {
                    alert(data.message); 
                }
              }
          });
        });
    });
  

});


// GLightbox Popup
var lightbox = GLightbox({
    selector: '.image-popup',
    title: false,
});
