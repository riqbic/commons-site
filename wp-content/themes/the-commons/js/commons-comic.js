(function($) {
	$(document).ready(function() {
        //Init comic slick slider, documented here - https://kenwheeler.github.io/slick/
        $('.commons-comic').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1
        });
	});
})(jQuery); // Fully reference jQuery after this point.