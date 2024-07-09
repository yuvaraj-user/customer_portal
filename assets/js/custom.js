/*-----------------------------------------------------------------------------------

Template Name: Conbiz

Note: This is Custom Js file

-----------------------------------------------------------------------------------

[Table of contents]

  01. slider-hero
  02. slider-reviews
  03. products-slider
  04. trending-slider
  05. clients-slider
  06. mobile-nav
  07. search-box
  08. counter
  09. Text Animation
  10. days
  11. accordion-item
  12. Cart Popup Start
  13. zoom-slider
  14. slider-for-two

-----------------------------------------------------------------------------------*/

/***--------  01. slider-hero   ------- ***/
jQuery(document).ready(function($){
if ( $.isFunction($.fn.owlCarousel) ) {
$('.slider-hero').owlCarousel({
    loop:true,
    arrows:false,
    autoplay:true,
    autoplayTimeout:4000,
    items:1,
    autoplayHoverPause:false,
      animateIn: 'fadeIn', // add this
  animateOut: 'fadeOut' // and this
  })
/***-------- 02. slider-reviews   ------- ***/
$('.slider-reviews').owlCarousel({
    loop:true,
    arrows:false,
    autoplay:true,
    autoplayTimeout:4000,
    nav:true,
    responsive:{
      0:{
          items:1
      },
      1200:{
          items:2
      }
    }
  })
/***-------- 03. products-slider   ------- ***/
$('.products-slider').owlCarousel({
  loop:true,
  dot:true,
  nav:false,
  autoplay:true,
  autoplayTimeout:3000,
  responsive:{
      0:{
          items:1
      },
      766:{
          items:2
      },
      992:{
          items:3
      },
      1200:{
          items:4
      }
    }
  })
/***-------- 04. trending-slider   ------- ***/
$('.trending-slider').owlCarousel({
  loop:true,
  dot:true,
  center: true,
  autoplay:true,
  autoplayTimeout:3000,
  responsive:{
      0:{
          items:1
      },
      992:{
          items:1
      },
      1200:{
          items:1
      }
    }
  })
}
/***--------  05. clients-slider   ------- ***/
  $('.clients-slider').owlCarousel({
        loop:true,
        dot:false,
        nav:false,
        autoplay:true,
        autoplayTimeout:3000,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:2
            },
            993:{
                items:4
            },
            1200:{
                items:6
            },
          }
        })
/***--------  06. mobile-nav   ------- ***/
jQuery('.mobile-nav .menu-item-has-children').on('click', function(e) {
  if ( jQuery( this ).hasClass('active') ) {
        jQuery(this).removeClass('active');
      } else {
        jQuery( '.mobile-nav .menu-item-has-children' ).removeClass('active');
        jQuery(this).addClass('active');
      }
    }); 
    jQuery('#nav-icon4').click(function($){
        jQuery('#mobile-nav').toggleClass('open');
    });
    jQuery('#res-cross').click(function($){
       jQuery('#mobile-nav').removeClass('open');
    });
      jQuery('.bar-menu').click(function($){
        jQuery('#mobile-nav').toggleClass('open');
        jQuery('#mobile-nav').toggleClass('hmburger-menu');
        jQuery('#mobile-nav').show();
    });
    jQuery('#res-cross').click(function($){
       jQuery('#mobile-nav').removeClass('open');
    });
}) ;
/***-------- 07. search-box   ------- ***/
if(jQuery('.search-box-outer').length) {
    jQuery('.search-box-outer').on('click', function() {
        jQuery('body').addClass('search-active');
    });
    jQuery('.close-search').on('click', function() {
        jQuery('body').removeClass('search-active');
    });
}

/***-------- 08. counter   ------- ***/  

function inVisible(element) {
//Checking if the element is
//visible in the viewport
var WindowTop = $(window).scrollTop();
var WindowBottom = WindowTop + $(window).height();
var ElementTop = element.offset().top;
var ElementBottom = ElementTop + element.height();
//animating the element if it is
//visible in the viewport
if ((ElementBottom <= WindowBottom) && ElementTop >= WindowTop)
animate(element);
}

function animate(element) {
//Animating the element if not animated before
if (!element.hasClass('ms-animated')) {
var maxval = element.data('max');
var html = element.html();
element.addClass("ms-animated");
$({
  countNum: element.html()
}).animate({
  countNum: maxval
}, {
  //duration 5 seconds
  duration: 5000,
  easing: 'linear',
  step: function() {
    element.html(Math.floor(this.countNum) + html);
  },
  complete: function() {
    element.html(this.countNum + html);
  }
});
}

}

//When the document is ready
$(function() {
$(window).scroll(function() {
$("h2[data-max]").each(function() {
  inVisible($(this));
});
})
});

function inVisible(element) {
var WindowTop = $(window).scrollTop();
var WindowBottom = WindowTop + $(window).height();
var ElementTop = element.offset().top;
var ElementBottom = ElementTop + element.height();
if ((ElementBottom <= WindowBottom) && ElementTop >= WindowTop)
animate(element);
}

function animate(element) {
if (!element.hasClass('ms-animated')) {
var maxval = element.data('max');
var html = element.html();
element.addClass("ms-animated");
$({
  countNum: element.html()
}).animate({
  countNum: maxval
}, {
  duration: 5000,
  easing: 'linear',
  step: function() {
    element.html(Math.floor(this.countNum) + html);
  },
  complete: function() {
    element.html(this.countNum + html);
  }
});
}

}
$(function() {
$(window).scroll(function() {
$("h2[data-max]").each(function() {
  inVisible($(this));
});
})
});
let calcScrollValue = () => {
let scrollProgress = document.getElementById("progress");
let progressValue = document.getElementById("progress-value");
let pos = document.documentElement.scrollTop;
let calcHeight =
document.documentElement.scrollHeight -
document.documentElement.clientHeight;
let scrollValue = Math.round((pos * 100) / calcHeight);
if (pos > 100) {
scrollProgress.style.display = "grid";
} else {
scrollProgress.style.display = "none";
}
scrollProgress.addEventListener("click", () => {
document.documentElement.scrollTop = 0;
});
scrollProgress.style.background = `conic-gradient(#007d3a ${scrollValue}%, #fff ${scrollValue}%)`;
};

window.onscroll = calcScrollValue;
window.onload = calcScrollValue;

// end




/*------------------------------------
09. Text Animation
--------------------------------------*/
function texteffct() {
if (jQuery(".ht-split-text").length) {
Splitting();
var themeht_animation_text = function(container, item) {
  jQuery(window).scroll(function() {
    var windowBottom = jQuery(this).scrollTop() + jQuery(this).innerHeight();
    jQuery(container).each(function(index, value) {
      var objectBottom = jQuery(this).offset().top + jQuery(this).outerHeight() * 0.1;

      if (objectBottom < windowBottom) {
        var seat = jQuery(this).find(item);
        for (var i = 0; i < seat.length; i++) {
          (function(index) {
            setTimeout(function() {
              seat.eq(index).addClass('ht-text-animated');
            }, 200 * index);
          })(i);
        }
      }
    });
  }).scroll();
};

jQuery(function() {
  themeht_animation_text(".theme-title", ".splitting");
});
}
};


jQuery(document).ready(function() {
texteffct()
});


/***--------  10. days   ------- ***/

if(jQuery("#days").length){

(function () {
    const second = 1000,
    minute = second * 60,
    hour = minute * 60,
    day = hour * 24;

  //I'm adding this section so I don't have to keep updating this pen every year :-)
  //remove this if you don't need it
  let today = new Date(),
      dd = String(today.getDate()).padStart(2, "0"),
      mm = String(today.getMonth() + 1).padStart(2, "0"),
      yyyy = today.getFullYear(),
      nextYear = yyyy + 1,
      dayMonth = "8/21/",
      birthday = dayMonth + yyyy;
  
  today = mm + "/" + dd + "/" + yyyy;
  if (today > birthday) {
    birthday = dayMonth + nextYear;
  }
  //end
  
  const countDown = new Date(birthday).getTime(),
      x = setInterval(function() {    

        const now = new Date().getTime(),
              distance = countDown - now;

        document.getElementById("days").innerText = Math.floor(distance / (day)),
          document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
          document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
          document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

        //do something later when date is reached
        if (distance < 0) {
          document.getElementById("headline").innerText = "event";
          document.getElementById("countdown").style.display = "none";
          document.getElementById("content").style.display = "block";
          clearInterval(x);
        }
        //seconds
      }, 0)
  }());
}

/************* 11. accordion-item ****************/

$('.accordion-item .heading').on('click', function(e) {
    e.preventDefault();

    if($(this).closest('.accordion-item').hasClass('active')) {
        $('.accordion-item').removeClass('active');
    } else {
        $('.accordion-item').removeClass('active');

        $(this).closest('.accordion-item').addClass('active');
    }
    var $content = $(this).next();
    $content.slideToggle(100);
    $('.accordion-item .content').not($content).slideUp('fast');
});

// end


/* 12. Cart Popup Start */

jQuery('.pr-cart').on('click', function() {

  jQuery('.cart-popup').toggleClass('show-cart');

});

// Cart Popup End
/***************** 13. zoom-slider ****************/

var $owl = $('.zoom-slider');

    if ( $.isFunction($.fn.owlCarousel) ) {
    $owl.owlCarousel({
    center: true,
    loop: true,
    margin:0,
    autoplay:true,
    autoplayTimeout:3000,
    dots:true,
    responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1200:{
          items:3
      }
    }
  });
}


/***************** 14. slider-for-two ****************/

if ( $.isFunction($.fn.slick) ) {

  $('.slider-for-two').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav-two'
  });
  $('.slider-nav-two').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for-two',
    dots: true,
    centerMode: true,
    arrows: false,
    centerPadding: '0px',
    focusOnSelect: true,
    responsive: [
              {
                breakpoint: 993,
                settings: {
                  slidesToShow: 1,
                }
              },
              {
                breakpoint: 576,
                settings: {
                  slidesToShow: 1,
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                }
              }
            ]
  });
}