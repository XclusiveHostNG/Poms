(function ($) {
    'use strict';

    $(document).ready(function () {
        const yearSpan = $('#currentYear');
        if (yearSpan.length) {
            yearSpan.text(new Date().getFullYear());
        }

        $('[data-toggle="tooltip"]').tooltip();

        $('.scroll-to').on('click', function (event) {
            event.preventDefault();
            const target = $(this).attr('href');
            if (target && $(target).length) {
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 80
                }, 600);
            }
        });
    });
})(jQuery);
