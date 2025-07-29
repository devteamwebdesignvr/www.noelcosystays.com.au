@extends("front.layouts.master")
@section("title",$data->meta_title)
@section("keywords",$data->meta_keywords)
@section("description",$data->meta_description)
@section("header-section")
{!! $data->header_section !!}
@stop
@section("footer-section")
{!! $data->footer_section !!}
@stop
@section("container")
    @php
        $name=$data->name;
        $bannerImage=asset('front/images/internal-banner.webp');
        if($data->bannerImage){
            $bannerImage=asset($data->bannerImage);
        }
    @endphp
    <!-- start banner sec -->
  
    <section class="page-title" style="background-image: url({{$bannerImage}});">
        <div class="auto-container">
            <h1 data-aos="zoom-in" data-aos-duration="1500" class="aos-init aos-animate">{{$name}}</h1>
            <div class="checklist">
                <p>
                    <a href="{{url('/')}}" class="text"><span>Home</span></a>
                    <a class="g-transparent-a">{{$name}}</a>
                </p>
            </div>
        </div>
    </section>
    <!-- end banner sec -->





    <section class="Blog-details">

        <div class="container">

          

           <img src="{{ asset($data->image)}}" class="img-fluid" alt="" />
              
            <div> <h2>{{$data->name}}</h2>{!! $data->longDescription !!}</div>

        </div>

    </section>


@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/attractions-detail.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/attractions-detail-responsive.css" />
@stop