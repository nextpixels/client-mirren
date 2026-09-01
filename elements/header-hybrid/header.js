jQuery(document).ready(function () {
    jQuery(window).scroll(function () {
        if (jQuery(document).scrollTop() > 50) {
            jQuery("header").addClass("scrolled");
        } else {
            jQuery("header").removeClass("scrolled");
        }
    });
});