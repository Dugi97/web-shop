require('bootstrap/dist/css/bootstrap.css');
require('../css/bootstrap-slider.css');
require('../css/slider.css');
require('../css/summernote.css');
require('../css/app.css');
require('../css/web-css.css');
require('../css/select.css');
// require('../js/react/index');

var $ = require('jquery');

require('bootstrap/dist/js/bootstrap.js');
require('../js/slider.js');
require('../js/summernote.js');
require('../js/product.js');
require('../js/add_size.js');
require('../js/select.js');


function registerSummernote(element, placeholder, max, callbackMax) {
    $(element).summernote({
        callbacks: {
            onKeydown: function(e) {
                var t = e.currentTarget.innerText;
                if (t.trim().length >= max) {
                    if (e.keyCode != 8)
                        e.preventDefault();
                }
            },
            onKeyup: function(e) {
                var t = e.currentTarget.innerText;
                if (typeof callbackMax == 'function') {
                    callbackMax(max - t.trim().length);
                }
            },
            onPaste: function(e) {
                var t = e.currentTarget.innerText;
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                var all = t + bufferText;
                document.execCommand('insertText', false, all.trim().substring(0, 600));
                if (typeof callbackMax == 'function') {
                    callbackMax(max - t.length);
                }
            }
        }
    });
}

$(function () {
    $("#product_brand").select2();

    $('[data-toggle="tooltip"]').tooltip();

    $("#product_subCategory").attr("disabled", true);
    $("select option").each(function () {
        if($(this).val() == "") {
            $(this).prop("selected", true);
            $(this).prop("disabled", true);
        }
    });

    registerSummernote('#product_description, #newsletter_area','Enter product description', 600, function(max) {
        $('#product_description, #newsletter_area').text(max);
    });
});

$(".btn-menu").on("click", function () {
   $("body").toggleClass("shrink");
});