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

if($data->currencyCode == 'INR'){
 $currency= '₹';
}
if($data->currencyCode == 'AUD'){
 $currency= '$';
}
$name=$data->name;
$bannerImage=asset('front/images/internal-banner.webp');;
if($data->banner_image){
$bannerImage=asset($data->banner_image);
}
@endphp


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
<a href="#book" class="sticky main-btn book1 book-now">
    <span class="button-text">BOOK NOW</span>
</a>
<section class="property-detail">
    <div class="container">

        <div class="row bottom">
            <div class="col-8">
                <div class="upper-box">
                    <div class="row clearfix">
                        <div class="col-lg-9 col-md-10 col-12 col-sm-12">
                            <h3>{{$data->name}}</h3>
                            <div class="hotel-info"><i class="fas fa-map-marker-alt"></i>{{$data->city}}, {{$data->state}}</div>
                        </div>
                        <div class="col-lg-3 col-md-2 col-12 col-sm-12">
                            <div class="clearfix">
                                <div class="price">
                                    @php
                                    $price=$data->price;
                                    $ar1=App\Models\HostAway\HostAwayDate::where("single_date",date('Y-m-d'))->where("hostaway_id",$data->host_away_id)->first();
                                    if($ar1){
                                    $price=$ar1->price;
                                    }
                                    @endphp
                                    @if($price)
                                  <span>From</span>
                                    <p>{{ $currency }}{{$price}}</p>
                                    <span>/ night</span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="food-list">
                        @if($data->personCapacity)
                        <li><i class="fa fa-users" aria-hidden="true"></i> Guests {{$data->personCapacity}} </li>
                        @endif
                        @if($data->bedsNumber)
                        <li><i class="fa fa-bed" aria-hidden="true"></i> Beds {{$data->bedsNumber}} </li>
                        @endif
                        @if($data->bathroomsNumber)
                        <li><i class="fa fa-bathtub" aria-hidden="true"></i> Baths {{$data->bathroomsNumber}} </li>
                        @endif
                    </ul>
                </div>
                <section class="blog-details-area ptb-90">
                    <div class="container-fluid" style="" id="calender_nrj">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-lg-12  col-sm-12 main-content">
                                <div class="page wrapper main-wrapper">
                                    <div class="row clearfix">
                                        <div class="col span_6 fwImage">
                                            <div id="gallery-1" class="royalSlider rsDefault">

                                                @php $i=1; @endphp
                                                @if($data->feature_image)
                                                @php $image=$data->feature_image;@endphp

                                                <a class="rsImg" data-rsBigImg="{{asset($data->feature_image)}}" href="{{asset($data->feature_image)}}">
                                                    <img width="126" height="82" class="rsTmb" src="{{asset($data->feature_image)}}" alt="" />
                                                    <span></span>
                                                </a>

                                                @endif

                                                @if($data->listingImages)
                                                @php $io=0; @endphp
                                                @foreach(json_decode($data->listingImages,true) as $c1)

                                                <a class="rsImg" data-rsBigImg="{{asset($c1['url'])}}" href="{{asset($c1['url'])}}">
                                                    <img width="126" height="82" class="rsTmb" src="{{asset($c1['url'])}}" alt="{{$c1['caption']}}" />
                                                    <span>{{$c1['caption']}}</span>
                                                </a>
                                                @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <hr>
                <div class="overview">
                    <h4>Overview</h4>
                    <div class="overcontent">
                        <pre>{!! $data->homeawayPropertyDescription !!} </pre>
                    </div>
                    <a class="main-btn more" id="more">
                        Show More
                    </a>
                    <a class="main-btn less" id="less">
                        Show Less
                    </a>
                </div>
                <hr>

                <div class="amenities">
                    <h4>Amenities</h4>
                    <ul class="amenities-detail">
                        @php $i=0;@endphp
                        @foreach(json_decode($data->listingAmenities,true) as $c1)
                        @if($i==10)
                        @break
                        @endif
                        <li>{{ $c1['amenityName']}}</li>
                        @php $i++;@endphp
                        @endforeach
                    </ul>
                    <button class="main-btn amn-btn" data-bs-toggle="modal" data-bs-target="#amn">Show all amenities</button>
                    <div class="modal" id="amn">
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
                                        <div class="single-amenity">
                                            <ul>
                                                @foreach(json_decode($data->listingAmenities,true) as $c1)
                                                <li>{{ $c1['amenityName']}}
                                                    <hr>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="availability">
                    <h4>Availability</h4>
                    <iframe src="{{ url('fullcalendar-demo/'.$data->id) }}" width="100%" height="400" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                @if(App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"type"=>"guest-to-host","status"=>"published"])->whereNotNull("publicReview")->limit(4)->count()>0)
                <hr>
                <div class="reviews">
                    <div class="reviews-head">
                        <h4>Reviews</h4>
                        <p class="reviews-total">{{App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"type"=>"guest-to-host","status"=>"published"])->whereNotNull("publicReview")->count()}} <span>Reviews</span></p>
                        <p class="ratings">{{number_format((App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"type"=>"guest-to-host","status"=>"published"])->whereNotNull("publicReview")->avg("rating")/2),2)}} <i class="fa-solid fa-star"></i> <span>Ratings</span></p>
                    </div>
                    <div class="row rev">
                        @foreach(App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"type"=>"guest-to-host","status"=>"published"])->whereNotNull("publicReview")->orderBy("arrivalDate","desc")->limit(8)->get() as $c)
                        <div class="col-lg-6 col-6">
                            <div class="guest-profile">
                                <div class="prof">
                                    <p>{{Helper::getReviewName($c->guestName) ?? '' }}</p>
                                    <span>{{date('F Y',strtotime($c->arrivalDate))}}</span>
                                    <span class="star-review">{{ number_format(($c->rating/2),2) }} <i class="fa-solid fa-star"></i></span>
                                </div>
                            </div>
                            <div class="guest-content">
                                <p>{{$c->publicReview ?? '' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="main-btn rvws" id="rvws" data-bs-toggle="modal" data-bs-target="#rvw">Show all reviews</button>
                    <div class="modal" id="rvw">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h4>What people think about us</h4>
                                    <div class="rvw-area">
                                        @foreach(App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"status"=>"published","type"=>"guest-to-host"])->whereNotNull("publicReview")->orderBy("arrivalDate","desc")->get() as $c)
                                        <div class="review-box">
                                            <div class="guest-profile">
                                                <div class="prof">
                                                    <p>{{Helper::getReviewName($c->guestName) ?? '' }}</p>
                                                    <span>{{date('F Y',strtotime($c->arrivalDate))}}</span>
                                                    <span class="star-review">{{ number_format(($c->rating/2),2) }} <i class="fa-solid fa-star"></i></span>
                                                </div>
                                            </div>
                                            <div class="guest-content">
                                                <p>{{$c->publicReview ?? '' }}</p>
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
                @endif
                <hr>
                @if($data->map)
                <div class="map">
                    <h4>Where you'll be</h4>
                    <iframe src="{!! $data->map !!}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <hr>
                </div>
                @endif
                @if($data->booking_policy!="" || $data->short_description!="" || $data->cancellation_policy!="" || $data->houseRules !="")
                <div class="policy">
                    <h4>Things to know</h4>
                    <div class="row">
                        @if($data->booking_policy)
                        <div class="col-lg-4 rule">
                            <div class="area">
                                <p class="main">House Rules</p>
                                {!! $data->booking_policy !!}
                            </div>
                            <a class="rul rull" id="rul" data-bs-toggle="modal" data-bs-target="#house">
                                Show More
                                <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; ">
                                    <path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path>
                                </svg>
                            </a>
                            <div class="modal" id="house">
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
                            <a class="rul safee" id="safe" data-bs-toggle="modal" data-bs-target="#safety">
                                Show More
                                <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; ">
                                    <path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path>
                                </svg>
                            </a>
                            <div class="modal" id="safety">
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
                            <a class="rul cancl" id="canc" data-bs-toggle="modal" data-bs-target="#cancel">
                                Show More
                                <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; ">
                                    <path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path>
                                </svg>
                            </a>
                            <div class="modal" id="cancel">
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
                      @if($data->houseRules)
                        <div class="col-lg-4 cancel">
                            <div class="area">
                                <p class="main">House Rules</p>
                                <pre>{!! $data->houseRules !!}</pre>
                            </div>
                            <a class="rul cancl" id="canc" data-bs-toggle="modal" data-bs-target="#houseRules">
                                Show More
                                <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 12px; width: 12px; display: block; ">
                                    <path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path>
                                </svg>
                            </a>
                            <div class="modal" id="houseRules">
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
                                              <pre>{!! $data->houseRules !!}</pre>
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

                @if($data->virtual_tour)
                {!! $data->virtual_tour !!}
                @endif

            </div>
            <div class="col-lg-4 sidebar" id="book">
                <div class='side-area'>
                    <div class="upper-area">
                      <h3>Book Now</h3>
                        <!--<a href="javascript:;" id="reset-button-gaurav-data">-->
                        <!--Reset</a>-->
                    </div>
                    <div class="error-box d-none" id="gaurav-error-show-parent">
                        <p id="gaurav-error-show-p"></p>
                    </div>
                    <div class="get-quote">
                        <div class="contact-box">
                            <form class="form booking_form" id="booking_form" action="{{url('reserve')}}" method="get">
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


                                    <input type="text" id="demo17" value="" aria-label="Check-in and check-out dates" aria-describedby="demo17-input-description" readonly />
                                </div>

                                <div class="row pet" style="{{ ModelHelper::showPetFee($data->pet_fee) }}">
                                    <div class="col-md-12">
                                        {!! Form::selectRange("pet",0,$data->max_pet,null,["placeholder"=>"Choose Pet","class"=>"form-control","title"=>"Choose no. of pet","id"=>"pet_fee_data_guarav"]) !!}
                                        <i class="fa-solid fa-paw"></i>
                                    </div>
                                </div>


                                <div class="ovabrw_service_select rental_item">
                                    <input type="text" name="Guests" value="{{ Request::get('Guests') ?? '1 Guests' }}" readonly="" class="form-control gst" id="show-target-data" placeholder="Add guests" title="Choose no. of guests">
                                    <i class="fa-solid fa-users "></i>
                                    <input type="hidden" value="{{ Request::get('adults') ?? '1' }}" name="adults" id="adults-data" />
                                    <input type="hidden" value="{{ Request::get('child') ?? '0' }}" name="child" id="child-data" />
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
                                                    1 Adult
                                                    @endif</span> 18+</p>
                                            <div class="adult-btn">
                                                <button class="button1" type="button" onclick="functiondec('#adults-data','#show-target-data','#child-data')" value="Decrement Value">-</button>
                                                <button class="button11 button1" type="button" onclick="functioninc('#adults-data','#show-target-data','#child-data')" value="Increment Value">+</button>
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
                                                <button class="button1" type="button" onclick="functiondec('#child-data','#show-target-data','#adults-data')" value="Decrement Value">-</button>
                                                <button class="button11 button1" type="button" onclick="functioninc('#child-data','#show-target-data','#adults-data')" value="Increment Value">+</button>
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
                                <p><a href="tel:{{$data->mobile ?? $setting_data['mobile'] }}"><i class="fa-solid fa-phone"></i> {{$data->mobile ?? $setting_data['mobile'] }}</a></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
    </div>
</section>

@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/assets/fancybox/jquery.fancybox.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" href="{{ asset('front')}}/royalslider.css" />
<link rel="stylesheet" href="{{ asset('front')}}/rs-defaulte166.css?ver={{ rand() }}" />
<link rel="stylesheet" href="{{ asset('front')}}/css/property-detail.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/property-detail-responsive.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('datepicker') }}/dist/css/hotel-datepicker.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/datepicker.css" />
@stop
@section("js")
@parent
<script src="{{ asset('front')}}/assets/fancybox/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('front')}}/js/jquery.royalslider.minf76d.js"></script>
<script src="{{ asset('front')}}/js/property-detail.js"></script>

<script>
    function functiondec($getter_setter, $show, $cal) {
        $("#submit-button-gaurav-data").hide();
        val = parseInt($($getter_setter).val());
        if ($getter_setter == "#adults-data") {
            if (val > 1) {
                val = val - 1;
            }
        } else {
            if (val > 0) {
                val = val - 1;
            }
        }
        $($getter_setter).val(val);
        person1 = val;
        person2 = parseInt($($cal).val());
        $show_data = person1 + person2;
        $show_actual_data = $show_data + " Guests";
        if ($getter_setter == "#adults-data") {
            $($getter_setter + '-show').html(val + " Adults");
            if (val <= 1) {
                $($getter_setter + '-show').html(val + " Adult");
            }
        } else {
            $($getter_setter + '-show').html(val + " Children");
            if (val <= 1) {
                $($getter_setter + '-show').html(val + " Child");
            }
        }
        $($show).val($show_actual_data);
        ajaxCallingData();
    }

    function functioninc($getter_setter, $show, $cal) {
        $("#submit-button-gaurav-data").hide();
        val = parseInt($($getter_setter).val());
        person1 = val;
        person2 = parseInt($($cal).val());
        $show_data = person1 + person2;
        val = val + 1;
        person1 = val;
        person2 = parseInt($($cal).val());
        $show_data = person1 + person2;
        $($getter_setter).val(val);
        $show_actual_data = $show_data + " Guests";
        $($show).val($show_actual_data);
        if ($getter_setter == "#adults-data") {
            $($getter_setter + '-show').html(val + " Adults");
            if (val <= 1) {
                $($getter_setter + '-show').html(val + " Adult");
            }
        } else {
            $($getter_setter + '-show').html(val + " Children");
            if (val <= 1) {
                $($getter_setter + '-show').html(val + " Child");
            }
        }
        ajaxCallingData();
    }
</script>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Days</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="gaurav-new-modal-days-area">
                Modal body..
            </div>

        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="myModal1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Additional Fee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="gaurav-new-modal-service-area">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<script>
    function clearDataForm() {
        $("#start_date").val('');
        $("#end_date").val('');
        $("#submit-button-gaurav-data").hide();
        $("#gaurav-new-modal-days-area").html('');
        $("#gaurav-new-modal-service-area").html('');
        $("#gaurav-new-data-area").html('');
    }
    $(document).on("change", "#pet_fee_data_guarav", function() {
        ajaxCallingData();
    });
    $(document).on("change", "#heating_pool_fee_data_guarav", function() {
        ajaxCallingData();
    });

    function ajaxCallingData() {
        $("#sygnius-loader").removeClass("d-none");
        pet_fee_data_guarav = $("#pet_fee_data_guarav").val();
        heating_pool_fee_data_guarav = $("#heating_pool_fee_data_guarav").val();
        adults = $("#adults-data").val();
        childs = $("#child-data").val();
        total_guests = parseInt(adults) + parseInt(childs);
        if (total_guests > 0) {
            if ($("#start_date").val() != "") {
                if ($("#end_date").val() != "") {
                    $.post("{{route('checkajax-get-quote')}}", {
                        start_date: $("#start_date").val(),
                        end_date: $("#end_date").val(),
                        heating_pool_fee_data_guarav: heating_pool_fee_data_guarav,
                        pet_fee_data_guarav: pet_fee_data_guarav,
                        adults: adults,
                        childs: childs,
                        book_sub: true,
                        property_id: {{$data->id}}
                    }, function(data) {
                        if (data.status == 400) {
                            $("#gaurav-new-modal-days-area").html(null);
                            $("#gaurav-new-modal-service-area").html(null);
                            $("#gaurav-new-data-area").html(null);
                            $("#submit-button-gaurav-data").hide();
                            toastr.error(data.message);
                            $("#sygnius-loader").addClass("d-none");
                        } else {
                            $("#submit-button-gaurav-data").show();
                            $("#gaurav-new-modal-days-area").html(data.modal_day_view);
                            $("#gaurav-new-modal-service-area").html(data.modal_service_view);
                            $("#gaurav-new-data-area").html(data.data_view);
                            $("#sygnius-loader").addClass("d-none");
                            $("#price-data-div").html(data.price);
                        }
                    });
                }
            }
        } else {
            $("#gaurav-new-modal-days-area").html(null);
            $("#sygnius-loader").addClass("d-none");
            $("#gaurav-new-modal-service-area").html(null);
            $("#gaurav-new-data-area").html(null);
            $("#submit-button-gaurav-data").hide();
        }
    }
</script>
<script src="{{ asset('datepicker') }}/node_modules/fecha/dist/fecha.min.js"></script>
<script src="{{ asset('datepicker') }}/dist/js/hotel-datepicker.js"></script>
<script>
    @php
    $new_data_blocked = LiveCart::iCalDataCheckInCheckOutCheckinCheckout($data->id);
    $checkin = json_encode($new_data_blocked['checkin']);
    $checkout = json_encode($new_data_blocked['checkout']);
    $blocked = json_encode($new_data_blocked['blocked']);
    @endphp
    var checkin = <?php echo $checkin;  ?>;
    var checkout = <?php echo ($checkout);  ?>;
    var blocked = <?php echo ($blocked);  ?>;
    (function() {
        @if(Request::get("start_date"))
        @if(Request::get("end_date"))
        $("#demo17").val("{{ request()->start_date }} - {{ request()->end_date }}");
        @endif
        @endif
        abc = document.getElementById("demo17");
        var demo17 = new HotelDatepicker(
            abc, {
                endDate: '{{ date(' Y - m - d ', strtotime(' + 33 months ')) }}',
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
                    if (Number.isNaN(demo17.end)) {
                        document.getElementById("end_date").value = '';
                    } else {
                        d.setTime(demo17.end);
                        document.getElementById("end_date").value = getDateData(d);
                        ajaxCallingData();
                    }
                },
                clearButton: function() {
                    return true;
                }
            }
        );
        @if(Request::get("start_date"))
        @if(Request::get("end_date"))
        setTimeout(function() {
            $("#demo17").val("{{ request()->start_date }} - {{ request()->end_date }}");
            document.getElementById("start_date").value = "{{ request()->start_date }}";
            document.getElementById("end_date").value = "{{ request()->end_date }}";
            ajaxCallingData();
        }, 1000);
        @endif
        @endif
    })();

    $(document).on("click", "#clear", function() {
        $("#clear-demo17").click();
    });
    x = document.getElementById("month-2-demo17");
    x.querySelector(".datepicker__month-button--next").addEventListener("click", function() {
        y = document.getElementById("month-1-demo17");
        y.querySelector(".datepicker__month-button--next").click();
    });
    x = document.getElementById("month-1-demo17");
    x.querySelector(".datepicker__month-button--prev").addEventListener("click", function() {
        y = document.getElementById("month-2-demo17");
        y.querySelector(".datepicker__month-button--prev").click();
    });

    function getDateData(objectDate) {
        let day = objectDate.getDate();
        let month = objectDate.getMonth() + 1;
        let year = objectDate.getFullYear();
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = `0${month}`;
        }
        format1 = `${year}-${month}-${day}`;
        return format1;
    }
    $(document).ready(function() {
        $('#more-slider').owlCarousel({
            loop: true,
            items: 3,
            margin: 25,
            dots: false,
            nav: true,
            autoplay: true,
            autoplayTimeout: 4000,
            smartSpeed: 550,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1170: {
                    items: 3
                }
            }
        });
    });

    $(document).ready(function($) {
        $('#gallery-1').royalSlider({
            fullscreen: {
                enabled: true,
                nativeFS: true
            },
            controlNavigation: 'thumbnails',
            autoScaleSlider: true,
            autoScaleSliderWidth: 800,
            autoScaleSliderHeight: 550,
            loop: true,
            imageScaleMode: 'fit-if-smaller',
            navigateByClick: true,
            numImagesToPreload: 2,
            arrowsNav: true,
            arrowsNavAutoHide: true,
            arrowsNavHideOnTouch: true,
            keyboardNavEnabled: true,
            fadeinLoadedSlide: true,
            globalCaption: true,
            globalCaptionInside: false,
            thumbs: {
                appendSpan: true,
                firstMargin: true,
                paddingBottom: 4
            }
        });

        $('.rsContainer').on('touchmove touchend', function() {});

    });
</script>
@stop