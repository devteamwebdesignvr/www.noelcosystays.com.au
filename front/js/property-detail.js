$('[data-fancybox="gallery"]').fancybox({
  buttons: [
    "slideShow",
    "thumbs",
    "zoom",
    "fullScreen",
    "share",
    "close"
  ],
  loop: false,
  protect: true
});
$(document).ready(function(){
     $("#more").click(function(){
    $(".overcontent").css("height", "auto");
    $("#more").css("display", "none");
    $("#less").css("display", "flex");
  });
  
   $("#less").click(function(){
    $(".overcontent").css("height", "140px");
    $("#more").css("display", "flex");
    $("#less").css("display", "none");
  });
  
   var a = $(".overcontent").height();
   if(a < 135){
$("#more").css("display", "none");
}
else{
    $("#more").css("display", "flex");
    $(".overcontent").css("height", "140px");
}
  

  
  $("#revw").click(function(){
    $(".guest-content").css("display", "block");
    $(this).css("display", "none");
    $("#revl").css("display", "flex");
  });
  
   $("#revl").click(function(){
    $(".guest-content").css("display", "-webkit-box");
    $("#revw").css("display", "flex");
    $(this).css("display", "none");
  });
  
  $("#revw1").click(function(){
    $(".guest-content1").css("display", "block");
    $(this).css("display", "none");
    $("#revl1").css("display", "flex");
  });
  
   $("#revl1").click(function(){
    $(".guest-content1").css("display", "-webkit-box");
    $("#revw1").css("display", "flex");
    $(this).css("display", "none");
  });
  
    $("#revw2").click(function(){
    $(".guest-content2").css("display", "block");
    $(this).css("display", "none");
    $("#revl2").css("display", "flex");
  });
  
   $("#revl2").click(function(){
    $(".guest-content2").css("display", "-webkit-box");
    $("#revw2").css("display", "flex");
    $(this).css("display", "none");
  });
  

});  
 $(document).ready(function(){
     $(".amn-btn").click(function(){
    $("#amn>.modal-dialog").css("right", "0px");
  });
  $("#amn>.btn-close").click(function(){
    $("#amn>.modal-dialog").css("right", "-700px");
  });
 });
 $(document).ready(function(){
     $(".rvws").click(function(){
    $("#rvw>.modal-dialog").css("right", "0px");
  });
  $("#rvw>.btn-close").click(function(){
    $("#rvw>.modal-dialog").css("right", "-700px");
  });
 });
 $(document).ready(function(){
     $(".rull").click(function(){
    $("#house>.modal-dialog").css("right", "0px");
  });
  $("#house>.btn-close").click(function(){
    $("#house>.modal-dialog").css("right", "-700px");
  });
 });
 $(document).ready(function(){
     $(".safee").click(function(){
    $("#safety>.modal-dialog").css("right", "0px");
  });
  $("#safety>.btn-close").click(function(){
    $("#safety>.modal-dialog").css("right", "-700px");
  });
 });
 $(document).ready(function(){
     $(".cancl").click(function(){
    $("#cancel>.modal-dialog").css("right", "0px");
  });
  $("#cancel>.btn-close").click(function(){
    $("#cancel>.modal-dialog").css("right", "-700px");
  });
 });
 $(document).ready(function(){
     $("#gaurav-new-data-area>.inner-area").click(function(){
    $(".days-box").css("display", "none");
  });
 });
 $(document).ready(function(){
   var h = $("#gaurav-new-data-area>.inner-area").height();
   if(h > 246){
$("#gaurav-new-data-area>.inner-area").css("overflow-y", "scroll");
$("#gaurav-new-data-area>.inner-area").css("height", "246px");
}
else{
    $("#gaurav-new-data-area>.inner-area").css("overflow-y", "hidden");
    $("#gaurav-new-data-area>.inner-area").css("height", "auto");
}
  });


 $(document).ready(function(){
     $("#book").click(function(){
    $(".days-box").css("display", "none");
  });
 });
 $(document).on("click",".days",function(){
    $(".days-box").toggle();
  });
  $(document).on("click","#book>.close-date",function(){
    $(".days-box").toggle();
  });
  $(document).on("click","#book>.days-box",function(){
    $("this").css("display","block");
  });
  $(document).on("click",".col-8",function(){
    $(".days-box").css("display","none");
  });
   $(document).on("click",".additional",function(){
    $(".days-box").css("display","none");
  });
   
  
 $(document).ready(function(){
     $("#book").click(function(){
    $(".additional-box").css("display", "none");
  });
 });
 $(document).on("click",".additional",function(){
    $(".additional-box").toggle();
  });
  $(document).on("click","#book>.close-additional",function(){
    $(".additional-box").toggle();
  });
  $(document).on("click","#book>.additional-box",function(){
    $("this").css("display","block");
  });
  $(document).on("click",".col-8",function(){
    $(".additional-box").css("display","none");
  });
  $(document).on("click",".days",function(){
    $(".additional-box").css("display","none");
  });
 $(document).ready(function(){
$('#more-slider').owlCarousel( {
  
          loop: true,
          items: 3,
          margin: 25,
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
  
          items: 2
  
        },
  
        1170: {
  
          items: 3
  
        }
  
      }
  
    });
  });


  // more property
