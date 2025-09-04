$(document).ready(function() {
    $(".open-nav").click(function() {
        $(".side-bar-nav").toggleClass("active");
        $(".fa-chevron-left").toggleClass("fa-chevron-right");
    })
})




//Start Slider In Profile Page
if ($(".top .slider")) {

    $('.top .slider').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: true
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true

                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
}









//End Slider



//Start Showing Profile nav
if ($("#toggle-user-info")) {
    $("#toggle-user-info").click(function() {
        $(".upper-bar .links ").fadeToggle();
    })
}

//End


// Start Code For Fliping option in login page

if ($("#flib")) {


    $("#fliper-sign").click(function() {
        $(".cover .front").css("display", "none");
        $(".cover .back").css("display", "block");
    })

    $("#fliper-log").click(function() {
        $(".cover .front").css("display", "block");
        $(".cover .back").css("display", "none");
    })


}

//End Option

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














const slideshowImages = document.querySelectorAll(".intro-slideshow img");

const nextImageDelay = 5000;
let currentImageCounter = 0; // setting a variable to keep track of the current image (slide)

// slideshowImages[currentImageCounter].style.display = "block";
slideshowImages[currentImageCounter].style.opacity = 1;

setInterval(nextImage, nextImageDelay);

function nextImage() {
    // slideshowImages[currentImageCounter].style.display = "none";
    slideshowImages[currentImageCounter].style.opacity = 0;

    currentImageCounter = (currentImageCounter + 1) % slideshowImages.length;

    // slideshowImages[currentImageCounter].style.display = "block";
    slideshowImages[currentImageCounter].style.opacity = 1;
}


// Owlcarousel
$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        center: true,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 3
            }
        }
    });
});

$(document).ready(function() {
    let listVideo = document.querySelectorAll('.video-list .vid');
    let mainVideo = document.querySelector('.main-video video');
    let title = document.querySelector('.main-video .title');

    listVideo.forEach(video => {
        video.onclick = () => {
            listVideo.forEach(vid => vid.classList.remove('active'));
            video.classList.add('active');
            if (video.classList.contains('active')) {
                let src = video.children[0].getAttribute('src');
                mainVideo.src = src;
                let text = video.children[1].innerHTML;
                title.innerHTML = text;
            };
        };
    });

});


$(".intro-header i").click(function() {
    $(".intro-header").fadeOut(400);
});


// Start Social Media buttons actions

const trigger = document.querySelector("menu > .trigger");
trigger.addEventListener('click', (e) => {
    e.currentTarget.parentElement.classList.toggle("open");
});


document.querySelector(".contact-form").addEventListener("submit", submitForm);

function submitForm(e) {
    e.preventDefault();

    //Get input values
    let email = document.querySelector(".email").value;
    let message = document.querySelector(".message").value;


    document.querySelector(".contact-form").reset();

    sendEmail(email, message);
}

//Send Email INfo
function sendEmail(email, message) {
    Email.send({
        Host: "smtp.gmail.com",
        Username: 'abdoelsawyx88@gmail.com',
        Password: "dympjvjjwhukynla",
        To: 'info@first-falcon.com',
        From: 'abdoelsawyx88@gmail.com',
        Subject: 'Demo Test sent you a message',
        Body: `Email: ${email} <br/> Message : ${message}`
    }).then((message) => alert("mail Sent Succefully"));
};

//   all ------------------
function initParadoxWay() {
    "use strict";

    if ($(".testimonials-carousel").length > 0) {
        var j2 = new Swiper(".testimonials-carousel .swiper-container", {
            preloadImages: false,
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            grabCursor: true,
            mousewheel: false,
            centeredSlides: true,
            pagination: {
                el: '.tc-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.listing-carousel-button-next',
                prevEl: '.listing-carousel-button-prev',
            },
            breakpoints: {
                1024: {
                    slidesPerView: 3,
                },

            }
        });
    }

    // bubbles -----------------


    // setInterval(function() {
    //     var size = randomValue(sArray);
    //     $('.bubbles').append('<div class="individual-bubble" style="left: ' + randomValue(bArray) + 'px; width: ' + size + 'px; height:' + size + 'px;"></div>');
    //     $('.individual-bubble').animate({
    //         'bottom': '100%',
    //         'opacity': '-=0.7'
    //     }, 4000, function() {
    //         $(this).remove()
    //     });
    // }, 350);

}

//   Init All ------------------
$(document).ready(function() {
    initParadoxWay();
});