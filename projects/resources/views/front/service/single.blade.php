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
<section class="service-section">
   <div class="container">
      {!! $data->longDescription !!}
   </div>
</section>
@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/service-detail.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/service-detail-responsive.css" />
@stop 
@section("js")
@parent
<script src="{{ asset('front')}}/js/service-detail.js" ></script>
@stop