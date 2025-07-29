@extends("front.layouts.master")
@section("title",$data->meta_title)
@section("keywords",$data->meta_keywords)
@section("description",$data->meta_description)
@section("logo",$data->image)
@section("header-section")
{!! $data->header_section !!}
@stop
@section("footer-section")
{!! $data->footer_section !!}
@stop
@section("container")
@php
$name=$data->name;
$bannerImage=asset('front/images/breadcrumb.webp');
if($data->bannerImage){
$bannerImage=asset($data->bannerImage);
}
@endphp
@include("front.layouts.banner")
<!-- Guests section start -->

<section class="about-us d-none">
   <div class="container">
      <div class="abt-info">
         <div class="about-image-sec">
            <div class="abt-image">
               <div class="abt-img1 aos-init aos-animate" data-aos="fade-down" data-aos-duration="1000">
                  <img src="{{asset($data->about_image1)}}" title="About" alt="About">
               </div>
               <!-- <div class="abt-img2 aos-init" data-aos="fade-up" data-aos-duration="1000">
                  <img src="{{ asset($data->about_image2)}}" title="About" alt="About">
               </div> -->
            </div>
         </div>
         <div class="about-content-sec">
            <div class="abt-content">
               <!-- <span class="ratings"><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i></span> -->
              <!-- <p class="head">About</p> -->
               <div class="abt-para">
                 {!! $data->mediumDescription !!}
               </div>
               
            </div>
         </div>
        
      </div>
   </div>
</section>




<!-- section about us -->
<section class="about-us-home" >
   <div class="container">
      <div class="abtsec">
        <div class="abt-right">
            <div class="abt-co-img">
                              <div class="abt-co-img-left" >
               <img src="{{asset($data->about_image2)}}" class="img-fluid" alt="">
               </div>
                 <div class="abt-co-img-right" >
                  <img src="{{asset($data->about_image1)}}" class="img-fluid" alt="">
               </div>
                           </div>
         </div>
         <div class=" abt-left">
             <div class="head-sec">
               <h2>About us</h2>
               
               </div>
            <div class="abt-cont">
               <!--<h2 data-aos="zoom-in-right" data-aos-duration="1500">About us</h2>-->

		<p data-aos="zoom-in-right" data-aos-duration="1500">{!! $data->mediumDescription !!}</p>
            </div>
            
         </div>
         
      </div>
     
   </div>
</section>





@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/about.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/about-responsive.css" />
@stop 
@section("js")
@parent
<script src="{{ asset('front')}}/js/about.js" ></script>
@stop