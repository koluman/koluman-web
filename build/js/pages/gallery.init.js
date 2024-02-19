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
                    type: 'GET',
                    url: 'https://mobiloby.app/koluman/web/api/getshowroomdetail',
                    dataType: 'json',
                    headers: {
                        "Authorization": 'Bearer ' + data.token
                    },
                    data: {
                        car_id: id,
                    },
                    success: function (data) {
                        console.log(data);
                        if(data.success==1){
                            let veri=data.shoowroomdetail.gallery;let s="";
                            for (let i = 0; i < veri.length; i++) {
                               s+='    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" data-category="designing development">';
                               s+='    <div class="gallery-box card">';
                               s+='    <div class="gallery-container">';
                               s+='        <a class="image-popup" href="{{ URL::asset("build/images/small/img-1.jpg") }}" title="">';
                               s+='            <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset("build/images/small/img-1.jpg") }}" alt="" />';
                               s+='            <div class="gallery-overlay">';
                               s+='                <h5 class="overlay-caption">Glasses and laptop from above</h5>';
                               s+='            </div>';
                               s+='        </a>';
                               s+='    </div>';
                               s+='        <div class="box-content">';
                               s+='            <div class="d-flex align-items-center mt-1">';
                               s+='                <div class="flex-grow-1 text-muted">by <a href="" class="text-body text-truncate">Ron Mackie</a></div>';
                               s+='                <div class="flex-shrink-0">';
                               s+='                    <div class="d-flex gap-3">';
                               s+='                        <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0 material-shadow-none">';
                               s+='                            <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 2.2K';
                               s+='                        </button>';
                               s+='                        <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0 material-shadow-none">';
                               s+='                            <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 1.3K';
                               s+='                        </button>';
                               s+='                    </div>';
                               s+='                </div>';
                               s+='            </div>';
                               s+='        </div>';
                               s+='    </div>';
                               s+='</div>      ';
                                
                            }
                            $("#gallery").html('');
                            $("#gallery").html(s);

                        }
                        else{

                        }
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
