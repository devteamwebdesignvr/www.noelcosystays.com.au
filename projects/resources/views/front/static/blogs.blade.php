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

 
    <section class="Blog-sec">

        <div class="container">

            <div class="row">


          
  @forelse($blogs as $b)
                <div class="col-lg-4 col-md-4 col-12">
                                @php $date=$b->publish_date; if($date){}else{$date=$b->created_at;} @endphp
                    <div class="blog">

                            @if($b->featureImage)
                            <img src="{{ asset($b->featureImage) }}" alt="{{ $b->title }}" class="img-fluid"  />
                                  @endif
                            <div class="content-blog">
                            <h3>{{$b->title}}</h3>
                            <p>{{ Str::limit($b->shortDescription,100)}}</p>
                            <a href="{{ url('blog/'.$b->seo_url) }}/" class="main-btn mt-4">Read More</a>
                            </div>


                    </div>
                </div>
            
    @empty

         <div class="alert alert-danger">No any Blogs Found.</div>

         @endforelse

      </div>

      <div class="row">{{$blogs->links() }}</div>




        </div>

    </section>

    

    


@stop