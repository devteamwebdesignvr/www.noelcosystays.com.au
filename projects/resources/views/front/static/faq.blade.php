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

  
@php  $faqs = App\Models\Faq::orderBy('id','desc')->get();@endphp
@if(count($faqs)>0)
<section class="faq" id="faqs">
   <div class="container">
      <div class="head-sec">
         <h2>Frequently Asked Questions</h2>
      </div>
      <div class="faq-sec">
         <div class="accordion" id="accordionExample">
             @php $i =1; @endphp
             @foreach($faqs as $c)
                 @if($i == 1)
                    <div class="accordion-item">
                       <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse"     data-bs-target="#collapseOne{{$c->id}}" aria-expanded="true" aria-controls="collapseOne{{$c->id}}">{!! $c->question!!}</button></h2>
                       <div id="collapseOne{{$c->id}}" class="accordion-collapse collapse show"
                          data-bs-parent="#accordionExample">
                          <div class="accordion-body">{!! $c->answer!!}</div>
                       </div>
                    </div>
                 @else
                    <div class="accordion-item">
                       <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"data-bs-target="#collapseTwo{{$c->id}}" aria-expanded="false" aria-controls="collapseTwo{{$c->id}}">{!! $c->question!!}</button></h2>
                       <div id="collapseTwo{{$c->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                          <div class="accordion-body">{!! $c->answer!!}</div>
                       </div>
                    </div>
                 @endif
                 @php $i++; @endphp
            @endforeach
         </div>
  
      </div>
   </div>
</section>
@endif

@stop
         @section("css")
         @parent

<link rel="stylesheet" href="{{ asset('front')}}/css/home.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/home-responsive.css" />
@stop