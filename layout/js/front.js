$(document).ready(function() {

    if ($(".popup")) {
        $("#edit-photo-popup").click(function() {
            $('#popup-1').toggleClass('active');
    
        });
    
        $("#close-edit-photo-popup").click(function() {
            $('#popup-1').toggleClass('active');
    
        });
        $("#edit-user-info-open").click(function() {
            $('#popup-2').toggleClass('active');
    
        })
    
        $("#edit-user-info-close").click(function() {
            $('#popup-2').toggleClass('active');
    
        })
        
    
    
    }

    if($(".profile-page").length){
        $(".profile-page .top .salary-table .header").click(function(){
            $(this).parent().children(".tables").slideToggle(400);
        });

        $(".worker-details-down").click(function(){
            $(".worker-details").slideToggle(400);
            $(".worker-details").toggleClass("active")
            $(".worker-details-down i").toggleClass("active");
        })
    }


    $(".open-nav").click(function() {
        $(".mobile-nav").slideDown(400);
    })

    $(".close-nav").click(function() {
        $(".mobile-nav").slideUp(400);
    })

    $(".mobile-nav ul li").click(function() {
        $(".mobile-nav").slideUp(400);
    })




    $('.ads-slider .slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        autoplay: true,
        autoplaySpeed: 4000,
        slidesToShow: 1,
        adaptiveHeight: true,
        arrows:false,
    });




$('.news-slider .slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.news-slider .slider-for'
    });
    $('.news-slider .slider-for').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.news-slider .slider',
    dots: true,
    arrows: false,
    centerMode: true,
    focusOnSelect: true,
    autoplay:true,
    autoplaySpeed:4000
    });







    
});