
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" ></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>


 <script src="{{ asset('front')}}/assets/fancybox/jquery.fancybox.min.js"></script>
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2//2.0.0-beta.2.4/owl.carousel.min.js"></script>
<!-- main js -->
<script type="text/javascript" src="{{ asset('front') }}/js/main.js?ver={{ $setting_data['version_css_js'] ?? '1.0.0' }}"></script>

<script src="{{ asset('toastr/toastr.js') }}?ver={{ $setting_data['version_css_js'] ?? '1.0.0' }}"></script>

<script>
  $(function(){
    $("#sygnius-loader").addClass("d-none");
});
AOS.init();
$(document).ready(function(){
  $(".gst").click(function(){
    $("#guestsss").css("display", "block");
  });
   $(".close1").click(function(){
    $("#guestsss").css("display", "none");
  });

  $(".gst1").click(function(){
    $("#guestsss1").css("display", "block");
  });
   $(".close12").click(function(){
    $("#guestsss1").css("display", "none");
  });
});
$(document).ready(function(){


    @if(Session::has("success"))
        toastr.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has("danger"))
        toastr.error("{{ Session::get('danger') }}");
    @endif


});

$(document).ready(function(){
  $("#more").click(function(){
    $("#less").css("display", "block");
    $("#more").css("display", "none");
    $(".abt").css("height", "auto");
  });
  
  $("#less").click(function(){
    $("#less").css("display", "none");
    $("#more").css("display", "block");
    $(".abt").css("height", "253px");
  });
});

$(document).ready(function(){
  $("#mr a").click(function(){
    $("#ls").css("display", "block");
    $("#mr").css("display", "none");
    $(".readMore_review").css("height", "auto");
  });
  
  $("#ls a").click(function(){
    $("#ls").css("display", "none");
    $("#mr").css("display", "block");
    $(".readMore_review").css("height", "78px");
  });
});

$(document).ready(function(){
  $("#menu-toggle1").click(function(){
    $("#tag1").css("transform", "translateX(0em)");
  });
  $("#close-menu1").click(function(){
    $("#tag1").css("transform", "translateX(-38em)");
  });
});
$(document).ready(function(){
  $("#menu-toggle2").click(function(){
    $("#tag2").toggle();
  });
});

function playVideo() {
            $('#mob').trigger('play');
        }
        function pauseVideo() {
            $('#mob').trigger('pause');
        }
        
        $(document).ready(function(){
  $("#pause").click(function(){
    $("#play").css("display", "block");
     $("#pause").css("display", "none");
  });
  $("#play").click(function(){
    $("#pause").css("display", "block");
     $("#play").css("display", "none");
  });
});

$(document).ready(function(){
  $("#hmore a").click(function(){
    $("#hless").css("display", "block");
    $("#hmore").css("display", "none");
    $(".abt-para").css("height", "auto");
  });
  
  $("#hless a").click(function(){
    $("#hless").css("display", "none");
    $("#hmore").css("display", "block");
    $(".abt-para").css("height", "199px");
  });
});

$(document).ready(function(){
   var a = $(".abt-para").height();
   if(a < 199){
$("#hmore").css("display", "none");
}
else{
    $("#hmore").css("display", "block");
  
}
  });

</script>
<script>
    $(document).ready(function(){
      $(".gst").click(function(){
        $("#guestsss").css("display", "block");
      });
       $(".close1").click(function(){
        $("#guestsss").css("display", "none");
      });
       $(".close111").click(function(){
        $("#guestsss").css("display", "none");
      });
    });
</script>