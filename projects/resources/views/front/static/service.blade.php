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
<section class="hero-section">
   <div class="container">
       <div class="card-grid">
                        <a class="card" href="{{ url('service-detail') }}">
                 <div class="card__background" style="background-image: url(https://www.oceanviewbliss.com/uploads/attraction-categories/6633f11125c20.jpg)"></div>
                 <div class="card__content">
                    <h3 class="card__heading">Vacation Rental Management</h3>
                 </div>
              </a>
                        <a class="card" href="{{ url('service-detail') }}">
                 <div class="card__background" style="background-image: url(https://www.oceanviewbliss.com/uploads/attraction-categories/6633f14234a0e.webp)"></div>
                 <div class="card__content">
                    <h3 class="card__heading">Caretaking Services</h3>
                 </div>
              </a>
                 </div>
   </div>
</section>
@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/service.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/service-responsive.css" />
@stop 
@section("js")
@parent
<script src="{{ asset('front')}}/js/service.js" ></script>
@stop