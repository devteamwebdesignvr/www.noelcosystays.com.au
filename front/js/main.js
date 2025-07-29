
var $owl = $('.property');

$owl.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl.owlCarousel({
  center: true,
  loop: true,
  items: 3,
  nav:true,
  dots:false,
  navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
   responsive: {
  
        0: {
  
          items: 1
  
        },
  
        768: {
  
          items: 1
  
        },
  
        1170: {
  
          items: 3
  
        }
  
      }
});

$(document).on('click', '.owl-item>div', function() {
  // see https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html#to-owl-carousel
  var $speed = 300;  // in ms
  $owl.trigger('to.owl.carousel', [$(this).data( 'position' ), $speed] );
});
// TESTIMONILS

        $('#test-slider').owlCarousel( {
  
          loop: true,
          items: 3,
          margin: 0,
          dots: false,
          nav: true,
          autoplay: true,
          autoplayTimeout:4000,
          smartSpeed: 550,
  
      navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
  
      responsive: {
  
        0: {
  
          items: 1
  
        },
  
        768: {
  
          items: 3
  
        },
  
        1170: {
  
          items: 3
  
        }
  
      }
  
    });

// property image slider

// TESTIMONILS

$('#prop-slider').owlCarousel( {
  
  loop: true,

   items: 3,

   margin: 15,

   autoplay: true,

   dots:true,

   nav:true,

   loop:true,

   autoplayTimeout: 4000,

   smartSpeed: 550,

   navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],

   responsive: {

     0: {

       items: 1

     },

     768: {

       items: 2

     },

     1170: {

       items: 3

     }

   }

 });

    $(window).on("scroll",function(){if($(this).scrollTop()>120){$(".navbar-area").addClass("is-sticky")}else{$(".navbar-area").removeClass("is-sticky")}});