@extends("front.layouts.master")
@section("title",$data->meta_title)
@section("keywords",$data->meta_keywords)
@section("description",$data->meta_description)

@section("container")

    @php
        $name=$data->name;
        $bannerImage=asset('front/images/internal-banner.webp');
        $payment_currency= $setting_data['payment_currency'];
        if($property->currencyCode == 'INR'){
          $payment_currency= '₹';
        } 
    @endphp
	<!-- start banner sec -->
    

    <section class="page-title d-none" style="background-image: url({{$bannerImage}});">
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

	<!-- start about section -->
     
<section class="payments-details mt-4 mb-4">
    <div class="container-fluid">
        <div class="row">

            <div class="col-3 payment-side"></div>
            <div class="col-6 payment-side">
                <div class="payment-bar">
                    <div class="payment-head">
                        <h4>You're all set for {{$property->name }}</h4>
                        <p>Congratulations, Your booking is confirmed. You will receive an email with further details.</p>
                    </div>
                    <div class="payment-slider owl-carousel" id="payment-slide">
                        @php  $i=1; @endphp
                        @if($property->listingImages)
                             @php $io=0; @endphp
                             @foreach(json_decode($property->listingImages,true) as $c1)
                                @if($i==10)
                                    @break
                                @endif
                                <div class="item">
                                    <img src="{{asset($c1['url'])}}" alt="{{$c1['caption']}}"  title="{{$c1['caption']}}" />
                                </div>
                               @php $i++; @endphp
                            @endforeach
                        @endif
                    </div>
                    <div class="check-details">
                        <ul>
                            <li>
                                <p>Check-in:</p>
                                <span> {{date('F jS, Y',strtotime($booking['checkin']))}}</span>
                            </li>
                            <li>
                                <p>Check-out:</p>
                                <span> {{date('F jS, Y',strtotime($booking['checkout']))}}</span>
                            </li>
                        </ul>
                        <ul>
                            <li><p>Guests:</p>
                                <span>{{$booking['total_guests'] }} ({{$booking['adults']}} Adults, {{$booking['child']}} Child)</span>
                            </li>
                            <li>
                                <p>Nights:</p>
                                <span>{{$booking['total_night'] }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="price-details"> 
                        <div class="price-area">
                          
                 
                         	@php $main_data=(json_decode($booking['financeField'],true));  @endphp
                            @foreach($main_data as $c)
                                @if($c['type']!="other")
                                    <div class="prc fees">
                                        <p class="value">
                                            <span>{{$c['title']}}</span>
                                        </p>
                                        <p class="amt">{!! $payment_currency !!}{{number_format($c['total'],2)}}</p>
                                    </div>
                                @endif
                           @endforeach
                   
                 
                        </div>

                   
                        <div class="total-amt">
                            <p class="value">Total </p>
                            <p class="total">{!! $payment_currency !!}{{number_format($booking['total_amount'],2)}}</p>
                        </div>
                        <div class="price-area">
                    

                                @foreach($main_data as $c)
                        
                                    @if($c['type']=="other")
                                 
                                    <div class="prc fees">
                                        <p class="value">
                                            <span>{{$c['title']}}</span><sub>(Paid via Guest Portal)</sub>
                                        </p>
                                        <p class="amt">{!! $payment_currency !!}{{number_format($c['total'],2)}}</p>
                                    </div>
                                   @endif
                     
                           @endforeach
                        </div>
          
                    </div>
                </div>
            </div>
            <div class="col-8 payment-map d-none">
                @if($property->map)
                    <iframe src="{!! $property->map !!}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                  
                @endif
            </div>
        </div>
    </div>
</section>
    

@stop
@section("css")
@parent
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" href="{{ asset('front')}}/css/payment.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/payment-responsive.css" />
@stop
@section("js")
@parent
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('front')}}/js/payment.js"></script>
@stop