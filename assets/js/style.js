(function ($) {
    'use strict';

    $(function () {
        const yearSpan = $('#currentYear');
        if (yearSpan.length) {
            yearSpan.text(new Date().getFullYear());
        }

        $('[data-bs-toggle="tooltip"]').tooltip();
    });
})(jQuery);
