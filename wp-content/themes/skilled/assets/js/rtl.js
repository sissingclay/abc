/**
 * Created by vladan on 13.4.16..
 */
jQuery(function ($) {

    setTimeout(function () {

        var $row = $('.vc_row');

        $row.each(function () {

            var $this = $(this);

            var isFullWidth = $this.data('vcFullWidth');

            if (isFullWidth) {
                var left = $this.offset().left;
                left = Math.abs(left) / 2;
                $this.css({left: left});
            }
        });
    }, 500);

    var bodyWidth = $('body').width();

    if (bodyWidth > 768) {

        var $searchUl = $('.search-for-courses ul');
        $searchUl.children().each(function(i,li){$searchUl.prepend(li)});

    }

});