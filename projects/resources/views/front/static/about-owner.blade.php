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
    <!-- start banner sec -->

<section class="about-owner">
    <div class="container px-0 lg-px-2">
        <div class="owner-infoo">
            <div class="img" data-aos="fade-up" data-aos-duration="1000">
                <div class="abt-owner">
                  <div class="abt-img mb-2"><img src="{{asset($data->image)}}" class="img-fluid" alt=""></div>
                </div>
            </div>
            <div class="cont">
            	<div class="own-content">
                    <h2>Hosts</h2>

                  {!! $data->longDescription!!}
               </div>
                <div class="abt-detail d-flex flex-wrap">
                    <div class="call-us">
                        <div class="icon-area">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="call-area">
                            Phone:
                            <a  href="tel:{!! $setting_data['mobile'] ?? '#' !!}">{!! $setting_data['mobile'] ?? '#' !!}</a>
                        </div>
                    </div>
                    <div class="email-us">
                        <div class="icon-area">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="call-area">
                            Email:
                            <a  href="mailto:{!! $setting_data['email'] ?? '#' !!}">{!! $setting_data['email'] ?? '#' !!}</a>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>
    {!! $data->seo_section !!}


@stop

@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/about-owner.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/about-owner-responsive.css" />
@stop 
@section("js")
@parent
<script src="{{ asset('front')}}/js/about-owner.js" ></script>
@stop