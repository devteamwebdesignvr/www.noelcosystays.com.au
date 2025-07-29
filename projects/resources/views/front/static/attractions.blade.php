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
        $bannerImage=asset('front/images/b1.jpg');
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
   @php
  $list=App\Models\Attraction::orderBy("id","desc")->paginate(1000);
  @endphp  
	<!-- end banner sec -->
   
<section class="summary-section ">
        <div class="container"> 
           @php $i=0; @endphp
              @foreach($list as $c)
              @if($i%2==0)
            <div class="row position-relative" id="a1">
                <div class="col-lg-7 col-md-12 col-sm-12 position-relative">
                    <div class="inner-column" >
                        @if($c->image)
                        <div class="image">
                            <img src="{{asset($c->image)}}" alt="{{$c->name}}"  class="attachment-full size-full aos-init aos-animate" loading="lazy" >
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 position-relative right-contentss">
                    <div class="inner-column-content  parent-class">
                        <h3><a @if($c->type=="internal") href="{{ url('attractions/detail/'.$c->seo_url) }}"  @else href="{{ $c->seo_url }}" target="_BLANK"    @endif >{{$c->name}}</a></h3>
                        <div class="line"></div>
                        <p class="target-class">{{$c->description}}</p>
                        <a class="main-btn mr"><span class="readmore">Readmore</span></a>
                    </div>
                </div>
                <div class="dot">
                  <img src="{{ asset('front')}}/img/dot-shape.png">
                </div>
            </div>
            @else
            <div class="row position-relative" id="a1">
                <div class="col-lg-7 order-lg-2 col-md-12 col-sm-12 position-relative">
                    <div class="inner-column" >
                        <div class="image">
                            <img src="{{asset($c->image)}}" alt="{{$c->name}}"  class="attachment-full size-full aos-init aos-animate" loading="lazy" >
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-lg-1 col-md-12 col-sm-12 position-relative right-contentss">
                    <div class="inner-column-content parent-class">
                        <h3 ><a @if($c->type=="internal") href="{{ url('attractions/detail/'.$c->seo_url) }}"  @else href="{{ $c->seo_url }}" target="_BLANK"    @endif>{{$c->name}}</a></h3>
                        <div class="line"></div>
                        <p  class="target-class" >{{$c->description}}</p>
                        <a class="main-btn mr"><span class="readmore">Readmore</span></a>
                    </div>
                </div>
                <div class="dot">
                  <img src="{{ asset('front')}}/img/dot-shape.png">
                </div>
            </div>


               @endif
            @php $i++; @endphp
            @endforeach
            <div class="row align-items-center">
               {{ $list->links()}}
            </div>
        </div>
</section>


@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/attractions.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/attractions-responsive.css" />
@stop
@section("js")
@parent
<script>

  $(document).ready(function(){
        $(".target-class").each(function(){
            var a=$(this).height();
             if(a < 280){
                $(this).parents(".parent-class").find(".mr").css("display", "none");
            }
            else{
                $(this).parents(".parent-class").find(".mr").css("display", "block");
                $(this).css("height", "280px");
            }
        })
        
     var a = $(".target-class").height();
   
  });

    $(document).on("click",".readmore",function(){
        that=$(this);
        that.removeClass("readmore").addClass("readless").html("Read Less");
        that.parents(".parent-class").find(".target-class").css({"height": "auto"});
    });
    $(document).on("click",".readless",function(){
        that=$(this);
        that.removeClass("readless").addClass("readmore").html("Read More");
        that.parents(".parent-class").find(".target-class").css({"height": "280px"});
    });
    
   


</script>
@stop