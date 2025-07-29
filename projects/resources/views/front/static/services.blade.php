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
@php $list=App\Models\Service::orderBy("id","desc")->get(); @endphp
@if(count($list)>0)
<section class="galleries-section">
   <div class="container">
      <div class="head-sec">
         <h2>Discover the Elegance of Naples</h2>
      </div>
      <div class="row">
         @foreach($list as $c)
         <div class="col-4 gallery-details">
            <div class="activites-image">
               <a href="#">
                  @if($c->image)
                  <img src="{{asset($c->image)}}" alt="{{ $c->name }}">
                  @endif
                  <div class="overlay-content">
                     {!! $c->longDescription !!}
                  </div>
               </a>
            </div>
            <h4><a href="#">{{ $c->name }}</a></h4>
         </div>
         @endforeach
      </div>
   </div>
</section>
@endif
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