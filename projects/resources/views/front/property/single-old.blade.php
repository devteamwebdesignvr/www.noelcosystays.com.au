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
    $currency=$setting_data['payment_currency'];
   $name=$data->name;
   $bannerImage=asset('front/images/internal-banner.webp');;
   if($data->banner_image){
      $bannerImage=asset($data->banner_image);
   }
@endphp
        <!-- header End Here -->
    <div class="banner">
        <div class="c-hero__background">
            <img class="img-fluid" src="{{ $bannerImage }}" title="{{ $name }}" alt="{{ $name }}">    
        </div>
        <div class="guides">
            <h1 class="c-hero__title">{{$name}}</h1>
        </div>
    </div>
   <div class="breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb single-breadcrumb">
                <a href="{{ url('/') }}" rel="nofollow"><i class="fa-solid fa-house"></i>Home</a>
                <a href="{{ url('/properties') }}" rel="nofollow"><span><i class="fa-solid fa-chevron-right"></i></span> Properties</a>
                <span><i class="fa-solid fa-chevron-right"></i></span> {{$name}}
            </div>
        </div>
    </div>
<a href="#book" class="sticky main-btn book1 book-now"><span class="button-text">BOOK NOW</span></a>
<section class="property-detail">
        <div class="container">
            <div class="upper-area">
                <h3>{{$data->name}}</h3>
                <div class="adr-area">
                    @if($data->address)
                      <h6><i class="fa-solid fa-location-dot"></i> {{$data->address}}</h6>
                    @endif
                    <div class="share-area">
                        <button class="main-btn share"><i class="fa-regular fa-share-from-square"></i> Share</button>
                        <div class="icon-area">
                            <a  onclick="window.open(this.href, 'pop-up', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" href="https://www.facebook.com/sharer/sharer.php?u={{ url('properties/detail'.$data->seo_url) }}" target="_BLANK"><i class="fab fa-facebook-f"></i></a>
                            <a  onclick="window.open(this.href, 'pop-up', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" href="https://twitter.com/share?text={{ $data->meta_title }}&amp;url={{ url('properties/detail'.$data->seo_url) }}" target="_BLANK"><i class="fa-brands fa-twitter"></i></a>
                            <a  onclick="window.open(this.href, 'pop-up', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('properties/detail'.$data->seo_url) }}"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row gallery">
                    <div class="col-6 left">
                        <a href="{{ asset($data->feature_image) }}" data-fancybox="gallery"><img src="{{ asset($data->feature_image) }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="col-6 right" >
                        <div class="row">
                            @php  $i=1; @endphp
                            @foreach(App\Models\PropertyGallery::where("property_id",$data->id)->orderBy("sorting","asc")->limit(4)->skip(0)->get() as $c)
                                <div class="col-6">
                                    <a href="{{asset($c->image)}}" data-fancybox="gallery"> 
                                       <img src="{{asset($c->image)}}" class="img-fluid"  alt="{{$c->caption}}"  title="{{$c->caption}}">
                                       @if($i==4)
                                        <button type="button" class="main-btn">Show All</button>
                                       @endif
                                   </a>
                               </div>
                               @php $i++; @endphp
                            @endforeach
                         </div>
                    </div>
                    <div class="hidden-gallery">
                        @foreach(App\Models\PropertyGallery::where("property_id",$data->id)->orderBy("sorting","asc")->limit(100)->skip(4)->get() as $c)
                        <div class="img-active">
                            <a href="{{asset($c->image)}}" data-fancybox="gallery"> <img src="{{asset($c->image)}}" class="img-fluid"  alt="{{$c->caption}}"  title="{{$c->caption}}"></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-8">
                 <div class="row hosted">
                     <div class="col-9">
                        <h4>{{$data->heading}}</h4>
                        <div class="ammenity-home">
                            @if($data->bedroom)
                                <span><i class="fa-solid fa-bed"></i> {{$data->bedroom}} Beds</span>
                            @endif
                            @if($data->bathroom)
                                <span><i class="fa-solid fa-bath"></i> {{$data->bathroom}} Baths</span>
                            @endif
                            @if($data->sleeps)
                                <span><i class="fa fa-users"></i> {{$data->sleeps}} Guests</span>
                            @endif
                        </div>
                     </div>
                 </div>   
                  <hr> 
                  <div class="overview">
                        <h4>Overview</h4>
                        <div class="overcontent">
                           {!! $data->long_description !!} 
                        </div>
                        <a class="more" id="more">Show More <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; "><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></a>
                        <a class="less" id="less">Show Less <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; "><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></a>
                    </div>
                    <hr>
                    @if(App\Models\PropertyAmenityGroup::where("property_id",$data->id)->where("status","true")->orderBy("sorting","asc")->limit(8)->count()>0)
                        <div class="amenities">
                          <h4>Amenities</h4>
                          <ul class="amenities-detail">
                            @foreach(App\Models\PropertyAmenityGroup::where("property_id",$data->id)->where("status","true")->orderBy("sorting","asc")->limit(8)->get() as $c)
                                <li>{{ $c->name}}</li>
                            @endforeach
                        </ul>
                        
                        <button class="main-btn amn-btn" data-bs-toggle="modal" data-bs-target="#amn">Show all amenities</button>
                        <div class="modal fade" id="amn">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                <h4>What this place offers</h4>
                                <div class="amn-area">
                                    @foreach(App\Models\PropertyAmenityGroup::where(["property_id"=>$data->id,"status"=>"true"])->orderBy("sorting","asc")->get() as $c)
                                    <div class="single-amenity">
                                        <h5>{{$c->name}}</h5>
                                        <ul>
                                            @foreach(App\Models\PropertyAmenity::where(["property_amenity_id"=>$c->id,"status"=>"true"])->orderBy("sorting","asc")->get() as $c1)
                                                <li>{{ $c1->name}}<hr></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
                        <hr>
                    @endif
                    <div class="availability">
                         <h4>Availability</h4>   
                         <iframe src="{{ url('fullcalendar-demo/'.$data->id) }}"  width="100%" height="400" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    </div>
                    <div class="col-lg-4 sidebar" id="book">
                        <div class='side-area'>
                            <div class="upper-area">
                        <div class="price">
                            @if($data->price)
                                    <p>{{ $currency }}  {{$data->price}}</p>
                                    <span>/ night</span>
                              @endif
                            </div>
                        </div>
                        <div class="error-box d-none" id="gaurav-error-show-parent">
                            <p id="gaurav-error-show-p"></p>
                        </div>
                        <div class="get-quote">
                        <div class="contact-box">
                                <form class="form booking_form" id="booking_form" action="{{url('get-quote')}}" method="get">
                                    <input type="hidden" name="property_id" value="{{ $data->id }}">
                                    <div class="main-cal">
                                        <div class="ovabrw_datetime_wrapper">
                                             {!! Form::text("start_date",Request::get("start_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"start_date","placeholder"=>"Check in"]) !!}
                                             <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <div class="ovabrw_datetime_wrapper">
                                             {!! Form::text("end_date",Request::get("end_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"end_date","placeholder"=>"Check Out"]) !!}
                                             <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                       <input type="text" id="demo17" value="" aria-label="Check-in and check-out dates" aria-describedby="demo17-input-description" readonly/>
                                    </div>
                                    <div class="row pet" style="{{ ModelHelper::showPetFee($data->pet_fee) }}">
                                        <div class="col-md-12">
                                            {!! Form::selectRange("pet",0,$data->max_pet,null,["placeholder"=>"Choose Pet","class"=>"form-control","title"=>"Choose no. of pet","id"=>"pet_fee_data_guarav"]) !!}
                                            <i class="fa-solid fa-paw"></i>
                                        </div>
                                    </div>
                                    <div class="row pool" style="{{ ModelHelper::showpoolFee($data->heating_pool_fee) }}">
                                        <div class="col-md-12">
                                            {!! Form::select("heating_pool_fee",["No"=>"No","Yes"=>"Yes"],null,["placeholder"=>"Choose Heating Pool","class"=>"form-control","title"=>"Select pool","id"=>"heating_pool_fee_data_guarav"]) !!}
                                            <i class="fa-solid fa-water-ladder"></i>
                                        </div>
                                    </div>
                                    <div class="ovabrw_service_select rental_item">
                                            <input type="text" name="Guests"   value="{{ Request::get('Guests') ?? '' }}" readonly="" class="form-control gst" id="show-target-data" placeholder="Guests" title="Choose no. of guests">
                                             <i class="fa-solid fa-users "></i>
                                             <input type="hidden" value="{{ Request::get('adults') ?? '0' }}"  name="adults" id="adults-data" />
                                             <input type="hidden" value="{{ Request::get('child') ?? '0' }}"  name="child" id="child-data" />
                                             <div class="adult-popup" id="guestsss">
                                                 <i class="fa fa-times close1"></i>
                                                 <div class="adult-box">
                                                     <p id="adults-data-show"><span>@if(Request::get('adults'))
                                                                                         @if(Request::get('adults')>1)
                                                                                             {{ Request::get('adults') }} Adults
                                                                                         @else
                                                                                             {{ Request::get('adults') }} Adult
                                                                                         @endif
                                                                                      @else
                                                                                      Adult
                                                                                      @endif</span> 18+</p>
                                                     <div class="adult-btn">
                                                         <button class="button1"  type="button" onclick="functiondec('#adults-data','#show-target-data','#child-data')" value="Decrement Value">-</button>
                                                         <button class="button11 button1" type="button"  onclick="functioninc('#adults-data','#show-target-data','#child-data')" value="Increment Value">+</button>
                                                     </div>
                                                 </div>
                                                 <div class="adult-box">
                                                     <p id="child-data-show"><span>@if(Request::get('child'))
                                                                                         @if(Request::get('child')>1)
                                                                                             {{ Request::get('child') }} Children
                                                                                         @else
                                                                                             {{ Request::get('child') }} Child
                                                                                         @endif
                                                                                      @else
                                                                                      Child
                                                                                      @endif</span> (0-17)</p>
                                                     <div class="adult-btn">
                                                         <button class="button1" type="button"  onclick="functiondec('#child-data','#show-target-data','#adults-data')" value="Decrement Value">-</button>
                                                         <button class="button11 button1" type="button"  onclick="functioninc('#child-data','#show-target-data','#adults-data')" value="Increment Value">+</button>
                                                     </div>
                                                 </div>
                                                 <button class="main-btn  close111" type="button" onclick="">Apply</button>
                                             </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="ovabrw-book-now" id="submit-button-gaurav-data" style="display: none;">
                                                <button type="submit" class="main-btn">
                                                <span> Reserve</span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="gaurav-new-data-area">
                                    </div>
                                </form>
                                 <div class="text-center about-owner-section">
                                <p>Or<br>Contact Owner</p>
                                <p><a href="mailto:{{$data->email ?? $setting_data['email'] }}"><i class="fa-solid fa-envelope"></i> {{$data->email ?? $setting_data['email'] }}</a></p>
                                <p><a href="mailto:{{$data->mobile ?? $setting_data['mobile'] }}"><i class="fa-solid fa-phone"></i> {{$data->mobile ?? $setting_data['mobile'] }}</a></p>
                            </div>
                        </div>
                    </div>
                         </div>
                    </div>
            </div>
            <hr>
            <div class="reviews">
                <h4>Reviews</h4>
                <div class="row rev">
                     @foreach(App\Models\Testimonial::where("property_id",$data->id)->where("status","true")->orderBy("id","desc")->get() as $c)
                    <div class="col-lg-6 col-6">
                        <div class="guest-profile">
                            @if($c->image)
                                <img src="{{ asset($c->image)}}" alt="{{$data->name}}  -- {{$c->name}}" class="">
                            @else
                                <img src="{{ asset('front')}}/images/misty.webp" alt="{{$data->name}}  -- {{$c->name}}" class="">
                            @endif
                            <div class="prof">
                                <p>{{$c->name}}</p>
                                @if($c->stay_date)
                                    <span>{{date('F-d Y',strtotime($c->stay_date))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="guest-content">
                        <p>{{$c->message}}</p>
                        </div>
                    
                    </div>
                    @endforeach
                </div>
                        <button class="main-btn rvws" id="rvws" data-bs-toggle="modal" data-bs-target="#rvw">Show all reviews</button>
                        <div class="modal fade" id="rvw">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="$('#myModal').modal('hide');"></button>
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                <h4>What people think about us</h4>
                                <div class="rvw-area">
                                  @foreach(App\Models\Testimonial::where("property_id",$data->id)->where("status","true")->orderBy("id","desc")->get() as $c)
                        <div class="review-box">
                        <div class="guest-profile">
                            @if($c->image)
                                <img src="{{ asset($c->image)}}" alt="{{$data->name}}  -- {{$c->name}}" class="">
                            @else
                                <img src="{{ asset('front')}}/images/misty.webp" alt="{{$data->name}}  -- {{$c->name}}" class="">
                            @endif
                            <div class="prof">
                                <p>{{$c->name}}</p>
                                @if($c->stay_date)
                                    <span>{{date('F-d Y',strtotime($c->stay_date))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="guest-content">
                        <p>{{$c->message}}</p>
                        </div>
                        </div>
                        <hr>
                    @endforeach
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
            </div>
            <hr>
            @if($data->map)
            <div class="map">
                <h4>Where you¨ll be</h4>
                <iframe src="{!! $data->map !!}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <hr>
            </div>
            @endif
            @if($data->booking_policy!="" || $data->short_description!="" || $data->cancellation_policy!="")
            <div class="policy">
                <h4>Things to know</h4>
                <div class="row">
                    @if($data->booking_policy)
                    <div class="col-lg-4 rule">
                        <div class="area">
                            <p class="main">House Rules</p>
                            {!! $data->booking_policy !!}
                        </div>
                        <a class="rul rull" id="rul" data-bs-toggle="modal" data-bs-target="#house">Show More <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; "><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></a>
                        <div class="modal fade" id="house">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                <h4>House Rules</h4>
                                <div class="house-area">
                                {!! $data->booking_policy !!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif
                    @if($data->short_description)
                    <div class="col-lg-4 safety">
                        <div class="area">
                            <p class="main">Safety & Property</p>
                            {!! $data->short_description !!}
                        </div>
                        <a class="rul safee" id="safe" data-bs-toggle="modal" data-bs-target="#safety">Show More <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; "><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></a>
                        <div class="modal fade" id="safety">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                <h4>Safety & Property</h4>
                                <div class="house-area">
                                {!! $data->short_description !!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif
                    @if($data->cancellation_policy)
                    <div class="col-lg-4 cancel">
                        <div class="area">
                            <p class="main">Cancellation policy</p>
                            {!! $data->cancellation_policy !!}
                            </div>
                            <a class="rul cancl" id="canc" data-bs-toggle="modal" data-bs-target="#cancel">Show More <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; "><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></a>
                            <div class="modal fade" id="cancel">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                <h4>Cancellation policy</h4>
                                <div class="house-area">
                                {!! $data->cancellation_policy !!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
                        @endif
                </div>
            </div>
            @endif
            </div>
        </div>
</section>

@stop
@section("css")
    @parent
    <link rel="stylesheet" href="{{ asset('front')}}/assets/fancybox/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="{{ asset('front')}}/css/property-detail.css" />
    <link rel="stylesheet" href="{{ asset('front')}}/css/property-detail-responsive.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('datepicker') }}/dist/css/hotel-datepicker.css"/>
    <link rel="stylesheet" href="{{ asset('front')}}/css/datepicker.css" />
@stop 
@section("js")
    @parent
    <script src="{{ asset('front')}}/assets/fancybox/jquery.fancybox.min.js" ></script>
    <script src="{{ asset('front')}}/js/property-detail.js" ></script>
    <script>
    function functiondec($getter_setter,$show,$cal){
        $("#submit-button-gaurav-data").hide();
        val=parseInt($($getter_setter).val());
        if(val>0){
            val=val-1;
        }
        $($getter_setter).val(val);
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
        $show_actual_data=$show_data+" Guests";
        if($getter_setter=="#adults-data"){
            $($getter_setter+'-show').html(val +" Adults");
            if(val<=1){
               $($getter_setter+'-show').html(val +" Adult"); 
            }
        }else{
             $($getter_setter+'-show').html(val +" Children");
            if(val<=1){
               $($getter_setter+'-show').html(val +" Child"); 
            }
        }
        $($show).val($show_actual_data);
        ajaxCallingData();
    }
    function functioninc($getter_setter,$show,$cal){
        $("#submit-button-gaurav-data").hide();
        val=parseInt($($getter_setter).val());
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
        @if($data->sleeps)
            if($show_data<{{$data->sleeps}}){
                val=val+1;
            }
        @endif
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
        $($getter_setter).val(val);
        $show_actual_data=$show_data+" Guests";
        $($show).val($show_actual_data);
        if($getter_setter=="#adults-data"){
            $($getter_setter+'-show').html(val +" Adults");
            if(val<=1){
               $($getter_setter+'-show').html(val +" Adult"); 
            }
        }else{
             $($getter_setter+'-show').html(val +" Children");
            if(val<=1){
               $($getter_setter+'-show').html(val +" Child"); 
            }
        }
        ajaxCallingData();
    }
</script>
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Days</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="gaurav-new-modal-days-area">
        Modal body..
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Additional Fee</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="gaurav-new-modal-service-area">
        Modal body..
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    function clearDataForm(){
        $("#start_date").val('');
        $("#end_date").val('');
        $("#submit-button-gaurav-data").hide();
        $("#gaurav-new-modal-days-area").html('');
        $("#gaurav-new-modal-service-area").html('');
        $("#gaurav-new-data-area").html('');
    }
    $(document).on("change","#pet_fee_data_guarav",function(){
        ajaxCallingData();
    });
    $(document).on("change","#heating_pool_fee_data_guarav",function(){
        ajaxCallingData();
    });
    function ajaxCallingData(){
        pet_fee_data_guarav=$("#pet_fee_data_guarav").val();
        heating_pool_fee_data_guarav=$("#heating_pool_fee_data_guarav").val();
        adults=$("#adults-data").val();
        childs=$("#child-data").val();
        total_guests=parseInt(adults)+parseInt(childs);
        if(total_guests>0){
             if($("#txtFrom").val()!=""){
                 if($("#txtTo").val()!=""){
                     $.post("{{route('checkajax-get-quote')}}",{start_date:$("#start_date").val(),end_date:$("#end_date").val(),heating_pool_fee_data_guarav:heating_pool_fee_data_guarav,pet_fee_data_guarav:pet_fee_data_guarav,adults:adults,childs:childs,book_sub:true,property_id:{{ $data->id }}},function(data){
                        if(data.status==400){
                            $("#gaurav-new-modal-days-area").html(null);
                            $("#gaurav-new-modal-service-area").html(null);
                            $("#gaurav-new-data-area").html(null);
                            $("#submit-button-gaurav-data").hide();
                            toastr.error(data.message);
                        }else{
                            $("#submit-button-gaurav-data").show();
                            $("#gaurav-new-modal-days-area").html(data.modal_day_view);
                            $("#gaurav-new-modal-service-area").html(data.modal_service_view);
                            $("#gaurav-new-data-area").html(data.data_view);
                        }
                    });
                 }
             }
        }else{
            $("#gaurav-new-modal-days-area").html(null);
            $("#gaurav-new-modal-service-area").html(null);
            $("#gaurav-new-data-area").html(null);
            $("#submit-button-gaurav-data").hide();
        }
    }
    </script>
    <script src="{{ asset('datepicker') }}/node_modules/fecha/dist/fecha.min.js"></script>
    <script src="{{ asset('datepicker') }}/dist/js/hotel-datepicker.js"></script>
    <script>
        $('#myModal').modal('hide');
    </script>
    <script>
    @php
        $new_data_blocked=LiveCart::iCalDataCheckInCheckOutCheckinCheckout($data->id);
        $checkin=json_encode($new_data_blocked['checkin']);
        $checkout=json_encode($new_data_blocked['checkout']);
        $blocked=json_encode($new_data_blocked['blocked']);
    @endphp
    var checkin = <?php echo $checkin;  ?>;
    var checkout = <?php echo ($checkout);  ?>;
    var blocked= <?php echo ($blocked);  ?>;
    (function () {
        @if(Request::get("start_date"))
            @if(Request::get("end_date"))
                $("#demo17").val("{{ request()->start_date }} - {{ request()->end_date }}");
            @endif
        @endif
        abc=document.getElementById("demo17");
        var demo17 = new HotelDatepicker(
            abc,
            {
                @if($checkin)
                    noCheckInDates: checkin,
                @endif
                @if($checkout)
                    noCheckOutDates: checkout,
                @endif
                @if($blocked)
                    disabledDates: blocked,
                @endif
                onDayClick: function() {
                    d = new Date();
                    d.setTime(demo17.start);
                    document.getElementById("start_date").value = getDateData(d);
                    d = new Date();
                    console.log(demo17.end)
                    if(Number.isNaN(demo17.end)){
                        document.getElementById("end_date").value = '';
                    }else{
                        d.setTime(demo17.end);
                        document.getElementById("end_date").value = getDateData(d);
                        ajaxCallingData();
                    }
                },
                clearButton:function(){return true;}
            }
        );
        @if(Request::get("start_date"))
            @if(Request::get("end_date"))
                setTimeout(function(){$("#demo17").val("{{ request()->start_date }} - {{ request()->end_date }}");document.getElementById("start_date").value ="{{ request()->start_date }}";document.getElementById("end_date").value ="{{ request()->end_date }}";ajaxCallingData();},1000);
            @endif
        @endif
    })();

    $(document).on("click","#clear",function(){$("#clear-demo17").click();});
    x=document.getElementById("month-2-demo17");
    x.querySelector(".datepicker__month-button--next").addEventListener("click", function(){y=document.getElementById("month-1-demo17");y.querySelector(".datepicker__month-button--next").click();})  ;
    x=document.getElementById("month-1-demo17");
    x.querySelector(".datepicker__month-button--prev").addEventListener("click", function(){y=document.getElementById("month-2-demo17");y.querySelector(".datepicker__month-button--prev").click();})  ;
    function getDateData(objectDate){let day = objectDate.getDate();let month = objectDate.getMonth()+1;let year = objectDate.getFullYear();if (day < 10) {day = '0' + day;}if (month < 10) {month = `0${month}`;}format1 = `${year}-${month}-${day}`;return  format1 ;}  
</script>
@stop 