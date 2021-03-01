require(["jquery"],function($) {
    
    $(document).ready(function() {

        $('.tb_testimonials').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            autoplay: false,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true,
                    dots: false,
                    margin: 20
                },
                1300: {
                    items: 4,
                    nav: true,
                    dots: false,
                    margin: 20
                }
            }
        });
    });    
});