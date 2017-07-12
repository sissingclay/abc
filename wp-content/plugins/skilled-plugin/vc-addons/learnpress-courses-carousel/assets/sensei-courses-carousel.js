jQuery(function ($) {
    if (typeof dntp_vc_addons != 'undefined' && dntp_vc_addons.data.sliders_owl) {
        $.each(dntp_vc_addons.data.sliders_owl, function (i, slider) {
            $('#' + slider.id).owlCarousel(slider.options);
        });
    }
});