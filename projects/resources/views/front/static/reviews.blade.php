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



      <!-- About Section -->
      <section class="about_wrapper">
         <div class="container">
            <div class="row m-0">

                    {!! $data->mediumDescription !!}
                    {!! $data->longDescription !!}

              {!! $data->shortDescription !!}
            </div>
         </div>
      </section>
@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/other.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/reviews.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/reviews-responsive.css" />
@stop 
@section("js")
@parent
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script src="{{ asset('front')}}/js/reviews.js" ></script>
@stop