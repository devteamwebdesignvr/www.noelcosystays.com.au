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
        $total_guests=Request::get('adults')+Request::get('child');
        $now = strtotime(Helper::getDateFormatData(Request::get("start_date"))); 
        $your_date = strtotime(Helper::getDateFormatData(Request::get("end_date")));
        $datediff =  $your_date-$now;
        $day= ceil($datediff / (60 * 60 * 24));
        $total_night=$day;
        $sign=$property->currencyCode;
        if($property->currencyCode == 'INR'){
            $sign = '₹';
        }else{
           $sign = '$';
        }
        $base_price=0;
        $key=[
            'stripe_publish_key'=>ModelHelper::getDataFromSetting('stripe_publish_key'),
            'stripe_secret_key'=>ModelHelper::getDataFromSetting('stripe_secret_key'),
        ];
        if($property){
            if($property->stripe_publish_key){
                if($property->stripe_secret_key){
                    $key=[
                        'stripe_publish_key'=>$property->stripe_publish_key,
                        'stripe_secret_key'=>$property->stripe_secret_key,
                    ];
                }
            }
        }
        $amount=$main_data['data']['totalPrice'];
        $listing_id=$property->host_away_id;
        $start_date=Helper::getDateFormatData(Request::get("start_date"));
        $end_date=Helper::getDateFormatData(Request::get("end_date"));
        $adult=Request::get("adults");
        $child=Request::get("child");
        $adults=Request::get("adults");
        $child=Request::get("child");
        $total_guests=$adults+$child;
        $amount_data_hostaway=[];
        $cancellation=(HostAwayAPI::cancellationPolicy($property->cancellationPolicyId));
        $days=Helper::calculateDays(date('Y-m-d'),$start_date);
        $guestAutoPaymentId=HostAwayApi::getguestAutopaymentId();
        $ikj=1;
        $impletement=false;
        $imAutoGuestArray=[];
        $getAutoPayment=HostAwayApi::getAUtopayment();
        $per_data='';
        $amount12455=0;
        if($getAutoPayment['status']==200){
            if($getAutoPayment['token']){
                if(isset($getAutoPayment['token']['status'])){
                    if($getAutoPayment['token']['status']=="success"){
                        if(isset($getAutoPayment['token']['result'])){
                            if($getAutoPayment['token']['result']){
                                foreach($getAutoPayment['token']['result'] as $c){
                                    if($c['guestAutoInvoiceId']==$guestAutoPaymentId){
                                        $imAutoGuestArray[]=$c;
                                        if($c['triggerEvent']=="reservation"){
                                            if($c['flatFee']){
                                                $amount12455=$c['flatFee'];
                                            }else{
                                                $per_data=$c['percentageFee'];
                                                $amount12455=round(($c['percentageFee']*$amount)/100,2);
                                            }
                                        }
                                        if($c['triggerEvent']=="arrival"){
                                            $days_data=Helper::calculateDays(date('Y-m-d'),$start_date);
                                            $payment_daays=($c['triggerTimeDelta']/24)*-1;
                                            if($days_data>$payment_daays){
                                                $scheduledDate=date('Y-m-d h:i:s', strtotime($c['triggerTimeDelta']." hours",strtotime($start_date)));
                                                if($c['percentageFee']){
                                                    $amount1=round(($c['percentageFee']*$amount)/100,2);
                                                }else{
                                                    if($amount12455>0){
                                                        $amount1=$amount-$amount12455;
                                                    }
                                                }
                                                $title=" Payment on";$paymentMethod="credit_card";$status="awaiting";
                                                $amount_data_hostaway[$ikj]=["title"=>$title,"amount"=>$amount1,"paymentMethod"=>$paymentMethod,'status'=>$status,'scheduledDate'=>$scheduledDate];
                                                $ikj++;
                                            }
                                        }
                                        if($c['triggerEvent']=="departure1"){
                                            
                                            $days_data=Helper::calculateDays(date('Y-m-d'),$end_date);
                                            $payment_daays=($c['triggerTimeDelta']/24)*-1;
                                            if($days_data>$payment_daays){
                                                $scheduledDate=date('Y-m-d h:i:s', strtotime($c['triggerTimeDelta']." hours",strtotime($end_date)));
                                                if($c['percentageFee']){
                                                    $amount1=round(($c['percentageFee']*$amount)/100,2);
                                                }else{
                                                    if($amount12455>0){
                                                        $amount1=$amount-$amount12455;
                                                    }
                                                }
                                                $title=" Payment on";$paymentMethod="credit_card";$status="awaiting";
                                                $amount_data_hostaway[$ikj]=["title"=>$title,"amount"=>$amount1,"paymentMethod"=>$paymentMethod,'status'=>$status,'scheduledDate'=>$scheduledDate];
                                                $ikj++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $paymentMethod="credit_card";$status="awaiting";
        $amount111=$amount;
        foreach($amount_data_hostaway as $c1){
            $amount111-=$c1['amount'];
        }
        $scheduledDate=date('Y-m-d h:i:s');
        $amount_data_hostaway[0]=["title"=>'Pay Now',"amount"=>$amount111,"paymentMethod"=>$paymentMethod,'status'=>$status,'scheduledDate'=>$scheduledDate];
        ksort($amount_data_hostaway);
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
<!-- start about section -->
@php    $show_data_amount=[];@endphp
@foreach($main_data['data']['components'] as $c)
    @if($c['isIncludedInTotalPrice']==1)
        @if($c['name']=="baseRate")
            @php  $base_price=$c['total'];  @endphp
        @else
            @php $show_data_amount[$c['type']]['data'][]=$c; 
                if(isset($show_data_amount[$c['type']]['total'])){
                    $show_data_amount[$c['type']]['total']+=$c['total'];
                }else{
                     $show_data_amount[$c['type']]['total']=$c['total'];
                }
            @endphp
        @endif
    @endif
@endforeach
<section class="get-quote">
    <div class="container">
        <div class="row quote-area">
            <div class="col-6 quote-detail">
                <p class="detail-page"><a href="{{ url($property->seo_url) }}"><i class="fa-solid fa-arrow-left"></i><span>Listing page</span></a></p>
                <h2>Confirm and pay</h2>
                <div class="trip">
                    <h4>Trip information</h4>
                    <div class="trip-date">
                        <div class="left date-left">
                            <p class="head">Dates</p>
                            <p>{{date('F jS, Y',strtotime($start_date))}} - {{date('F jS, Y',strtotime($end_date))}}</p>
                        </div>
                        <div class="date-box">
                            <button type="button" class="btn-close"></button>
                            <div class="row date-head">
                                <div class="col-12 left">
                                    <h3>{{date('F jS, Y',strtotime($start_date))}} - {{date('F jS, Y',strtotime($end_date))}}</h3>
                                </div>
                            </div>
                            <form  action="{{ url('reserve') }}" method="get">
                                <div class="date-content">
                                    @foreach(Request::except(["end_date","start_date"]) as $field_name=>$value)
                                        <input type="hidden" name="{{$field_name}}" value="{{ $value }}" />
                                    @endforeach
                                    <div class="main-cal">
                                        <div class="ovabrw_datetime_wrapper d-none">
                                            {!! Form::text("start_date",Request::get("start_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"start_date","placeholder"=>"Check in"]) !!}
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <div class="ovabrw_datetime_wrapper d-none">
                                            {!! Form::text("end_date",Request::get("end_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"end_date","placeholder"=>"Check Out"]) !!}
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <input type="text" id="demo17" value="" aria-label="Check-in and check-out dates" aria-describedby="demo17-input-description" readonly/>
                                    </div>
                                </div>
                                <div class="date-btn">
                                    <button class="apply-date main-btn"><span>Apply</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="trip-guest">
                        <div class="left guest-left">
                            <p class="head">Guests</p>
                            <p>{{$total_guests}} Guests   ({{ $adults }} Adults , {{ $child }} Child) </p>
                        </div>
                        <div class="guest-box">
                            <button type="button" class="btn-close"></button>
                            <form method="get" action="{{ url('reserve') }}">
                                @foreach(Request::except(["adults","child","Guests"]) as $field_name=>$value)
                                    <input type="hidden" name="{{$field_name}}" value="{{ $value }}" />
                                @endforeach
                                <input type="hidden" name="adults" value="{{ request()->adults }}" id="adults-data">
                                <input type="hidden" name="child" value="{{ request()->child }}" id="child-data">
                                <input type="hidden" name="pet" value="{{ request()->pet }}" id="pet-data">
                                <input type="hidden" name="Guests" value="{{ request()->Guests }}" id="show-target-data">
                                <div class="row guest-head">
                                    <div class="col-12">
                                        <h3>{{ request()->Guests }} selected</h3>
                                    </div>
                                </div>
                                <div class="row guest-body">
                                    <div class="col-12 left">
                                        <div class="adult-box">
                                            <p>Adults <span>Ages 13+</span></p>
                                            <div class="adult-btn">
                                                <button class="button1" type="button" onclick="functiondec('#adults-data','#show-target-data','#child-data')" value="Decrement Value">-</button>
                                                <p id="adults-data-show">{{ request()->adults }}</p>
                                                <button class="button11 button1" type="button" onclick="functioninc('#adults-data','#show-target-data','#child-data')" value="Increment Value">+</button>
                                            </div>
                                        </div>
                                        <div class="adult-box">
                                            <p>Children<span>Ages 0-12</span></p>
                                            <div class="adult-btn">
                                                <button class="button1" type="button" value="Decrement Value" onclick="functiondec('#child-data','#show-target-data','#adults-data')">-</button>
                                                <p id="child-data-show">{{ request()->child }}</p>
                                                <button class="button11 button1" type="button" value="Increment Value" onclick="functioninc('#child-data','#show-target-data','#adults-data')">+</button>
                                            </div>
                                        </div>
                                        <p class="list-guest d-none">
                                            This listing has a maximum of {{ (int)$property->personCapacity }} guests, not including infants. Pets are not allowed.
                                        </p>
                                    </div>
                                </div>
                                <div class="guest-button">
                                    <a href="javascript:;" class="cancl">Clear</a>
                                    <button type="submit" class="main-btn"> <span>Apply</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form 
                    action='{{route("save-booking-data")}}'
                    method="POST"  
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{ $key['stripe_publish_key'] }}"
                    id="payment-form">
                    @csrf
                    <input type="hidden" name="amount_data_hostaway" value="{{ json_encode($amount_data_hostaway) }}" />
                    <input type="hidden" name="amount_data" value="{{ json_encode($main_data) }}" />
                    <input type="hidden" name="property_id" value="{{ $property->id }}" />
                    <input type="hidden" name="checkin" value="{{ Helper::getDateFormatData(Request::get('start_date')) }}"  />
                    <input type="hidden" name="checkout" value="{{ Helper::getDateFormatData(Request::get('end_date')) }}"  />
                    <input type="hidden" name="adults" value="{{ Request::get('adults') }}"  />
                    <input type="hidden" name="child" value="{{ Request::get('child') }}"  />
                    <input type="hidden" name="total_guests" value="{{ $total_guests }}"  />
                    <input type="hidden" name="gross_amount" value="{{ $main_data['data']['totalPrice'] }}"  id="total_amount_data" />
                    <input type="hidden" name="amount" value="{{ $main_data['data']['totalPrice'] }}"  />
                    <input type="hidden" name="days" value="{{ $day }}"  />
                    <input type="hidden" name="total_night" value="{{ $day }}"  />
                    <input type="hidden" name="request_id" value="{{ uniqid() }}"  />
                    <input type="hidden" name="discount" value="{{ $main_data['coupon_id'] }}" >
                    <input type="hidden" name="discount_coupon" value="{{ $main_data['coupon'] }}" >
                    @php
                        $additional=HostAwayAPI::getlistingFeeSettings($property->host_away_id);
                        $additional_new_data=[];
                        if($additional['status']==200){
                            if(isset($additional['data'])){
                                if(isset($additional['data']['result'])){
                                    if(is_array($additional['data']['result'])){
                                        foreach($additional['data']['result'] as $a){
                                            if($a['isMandatory']==1){}else{
                                                $additional_new_data[]=$a;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $total_amount_data=$main_data['data']['totalPrice'];
                    @endphp
                    <input type="hidden" name="additional" value="{{ json_encode($additional) }}" >
                    @if(count($additional_new_data)>0)
                    <div class="card-details info-detail additional-details">
                        <div class="card-form">                             
                            <div class="card-form-head">
                                <h3>Additional Services</h3>                            
                            </div>
                            <div class='row'>
                                @foreach($additional_new_data as $c)
                               
                                    @php $total_amount_data_1=0;  @endphp
                                    @if($c['amountType']=="flat")
                                        @if($c['feeAppliedPer']=="reservation")
                                            @php $total_amount_data_1=$c['amount'];  
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'];
                                            @endphp
                                        @elseif($c['feeAppliedPer']=="night")
                                            @php $total_amount_data_1=($c['amount']*$day); 
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'].' per Night';
                                            @endphp
                                        @endif
                                    @else
                                        @if($c['feeAppliedPer']=="reservation")
                                            @php $total_amount_data_1=round(($total_amount_data*$c['amount'])/100,2); 
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'] .'%';
                                            @endphp
                                        @elseif($c['feeAppliedPer']=="night")
                                            @php $total_amount_data_1=round(($total_amount_data*$c['amount']*$day)/100,2); 
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'].'% per Night';
                                            @endphp
                                        @endif
                                    @endif
                                    @isset($label)
                                    @php $label = preg_replace('/\$/', '<span style="font-family:sans-serif;">$</span>', $label); @endphp
                                    @endisset
                                    
                                   @if($c['feeTitle']=="Damage Insurance")
                              		<div class="col-12 p-0">                                  		
                                       <label for="price">{!! $label !!}</label>
                                      <span class="text">The plan cost includes the insurance premium and assistance services fee. Insurance coverages are underwritten by: Generali U.S. Branch, New York, NY; NAIC # 11231, for the operating name used in certain states, and other important information about the Insurance & Assistance Services Plan, please see</span>
                                        <div class="addn-link">
                                            <a href="https://www.csatravelprotection.com/certpolicy.do?product=GR330" target="_BLANK">Plan details</a>  
                                           <a href="https://www.generalitravelinsurance.com/customer/disclosures.html" target="_BLANK">Important Disclosures</a>  
                                        </div>
                                       <div class="additional-btn">
                                            <div><input type="radio" name="additional_new_data[{{$c['id']}}]" value="yes" data-amount="{{  $total_amount_data_1 }}" data-label="{{  $label }}" class="additional_new_data_checkbox_label"><label >Yes</label></div>
                                            <div><input type="radio"  name="additional_new_data[{{$c['id']}}]" value="no" class="additional_new_data_checkbox_label"><label >No</label></div>
                                        </div>
                              		
                                	</div>
                                    @elseif($c['feeTitle']=="Travel Insurance")
                              		<div class="col-12 p-0">
                                 		  <label for="price">{!! $label !!}</label>
                                      <span class="text">The plan cost includes the travel insurance premium and assistance services fee. Insurance coverages are underwritten by: Generali U.S. Branch, New York, NY; NAIC # 11231, for the operating name used in certain states, and other important information about the Insurance & Assistance Services Plan, please see</span>
                                        <div class="addn-link">
                                            <a href="https://www.csatravelprotection.com/certpolicy.do?product=G-20VRD" target="_BLANK">Plan details</a> 
                                            <a href="https://www.generalitravelinsurance.com/customer/disclosures.html" target="_BLANK">Important Disclosures</a> 
                                        </div>
                                       <div class="additional-btn">
                                            <div><input type="radio" name="additional_new_data[{{$c['id']}}]" value="yes" data-amount="{{  $total_amount_data_1 }}" data-label="{{  $label }}" class="additional_new_data_checkbox_label"><label >Yes</label></div>
                                            <div><input type="radio"  name="additional_new_data[{{$c['id']}}]" value="no" class="additional_new_data_checkbox_label"><label >No</label></div>
                                        </div>
                              
                                	</div>
                                 	@else
                              
                                     @isset($label)
                               		<div class="col-6 p-0">
                                  		 <label for="price">{!! $label !!}</label>
                                  		 <div class="additional-btn">
                                            <div><input type="radio" name="additional_new_data[{{$c['id']}}]" value="yes" data-amount="{{  $total_amount_data_1 }}" data-label="{{  $label }}" class="additional_new_data_checkbox_label"><label >Yes</label></div>
                                            <div><input type="radio"  name="additional_new_data[{{$c['id']}}]" value="no" class="additional_new_data_checkbox_label"><label >No</label></div>
                                        </div>
                                  	
                                	</div>
                                    @endisset
                                    @endif                                                                      
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card-details info-detail">
                        <div class="card-box">
                            <div class="box-area">
                                <div class="card-head">
                                    <img src="{{ asset('front')}}/images/credit-card.svg" alt="" />
                                    <p class="credit-debit">Credit/Debit card</p>
                                    <p class="card-amt">+ {{$sign}} {{number_format($main_data['data']['totalPrice'],2)}} in credit/debit card fees</p>
                                </div>
                                <div class="card-radio">
                                    <input type="radio" class="radio-card">
                                </div>
                            </div>
                        </div>
                        <div class="card-form">
                            <div class="card-form-head">
                                <h3>Pay with Credit/Debit card</h3>
                                <img src="{{ asset('front')}}/images/credit-card.svg" alt="" />
                            </div>
                            <style> .hide{display:none;}</style>
                            <div class="error hide" >
                                <div class="alert alert-danger"></div>
                            </div>
                            <div class='form-row row'>
                                <div class="col-6 form-floating name-on-card  required">
                                    <input type="text" class="form-control" id="name_on_card" placeholder="Enter Name on Card" title="Enter Name on Card" name="name_on_card">
                                    <label for="name_on_card">Name on Card</label>
                                </div>
                                 <div class="col-6 form-floating card required">
                                    <input autocomplete='off' type="text" class="form-control  card-number" id="card_number" placeholder="Enter Card Number" title="Enter  Card Number" name="card_number" required>
                                    <label for="card_number">Card Number</label>
                                </div>
                            </div>
                            <div class='form-row row'>
                                <div class="col-4 form-floating cvc required">
                                    <input autocomplete='off' type="text" class="form-control card-cvc" id="card_cvv" placeholder="Enter CVV" title="Enter CVV" name="card_cvv" required>
                                    <label for="card_cvv">Card (CVV)</label>
                                </div>
                                <div class="col-4 form-floating expiration required">
                                    <input autocomplete='off' type="text" class="form-control card-expiry-month" id="card_exp_month" placeholder="Enter Expiration Month (MM)" title="Enter Expiration Month (MM)" name="card_exp_month" required>
                                    <label for="card_exp_month">Expiration Month(MM)</label>
                                </div>
                                <div class="col-4 form-floating expiration required">
                                    <input autocomplete='off' type="text" class="form-control card-expiry-year" id="card_year" placeholder="Enter Expiration Year (YYYY)" title="Enter Expiration Year (YYYY)" name="card_year" required>
                                    <label for="card_year">Year (YYYY)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-detail">
                        <h3>Contact information</h3>
                        <div class="row">
                            <div class="col-6 form-floating">
                                <input type="text" class="form-control" id="name" placeholder="Enter First Name" title="Enter First Name" name="firstname"  required="">
                                <label for="name">First name*</label>
                            </div>
                            <div class="col-6 form-floating">
                                <input type="text" class="form-control" id="last-name" placeholder="Enter Last Name" title="Enter Last Name" name="lastname" >
                                <label for="lastname">Last name</label>
                            </div>
                            <div class="col-12 form-floating phone-form">
                                <!--<select name="phone" id="country-select"></select> -->
                                <select name="country_code" id="country-select">
                                </select>
                                <div class="from-number">
                                    <span class="phone-number">Phone number</span>
                                    <div class="form-text">
                                        <input type="tel" class="form-control" id="mobile"  title="Enter Mobile" name="mobile" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-floating">
                                <input type="email" class="form-control" id="email" placeholder="Enter Email" title="Enter Email" name="email" required=""> 
                                <label for="email">Email address*</label>
                            </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 px-0">
                                    <label>How did you hear about us?</label>
                                    {!! Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"","placeholder"=>"--Select--"]) !!}
                                </div> 
                            <div class="col-12 form-floating d-none">
                                <textarea class="form-control" name="message" placeholder="Enter Message" title="Enter Message" id="floatingTextarea"></textarea>
                                <label for="floatingTextarea">Message</label>
                            </div> 
                        </div>
                        <div class="form-message">
                            <p>The booking confirmation will be sent to this email address.</p>
                        </div>
                        <div class="form-input ">
                            <h4>Complete booking</h4>
                            <div class="form-input-details">
                                <input type="checkbox" name="complete" required checked="" >
                                <label for="complete">
                                    By completing this booking, you agree to the 
                                    <a href="{{ url('terms-and-conditions') }}"  target="_BLANK" >Terms and Conditions</a> and 
                                    <a href="{{ url('privacy-policy') }}"  target="_BLANK" >Privacy Policy</a> and 
                                    <a href="javascript:;">House Rules  <span class="icon">!<span class="box-msg">{!! $property->houseRules !!}</span></span></a>.
                                </label>
                            </div>
                        </div>
                        <div class="form-btn sub">
                            <button type="submit" class="submit main-btn" name="operation" value="send-quote" id="sig-submitBtn"><span>Confirm and book now <i class="fa-solid fa-arrow-right"></i></span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6 book-detail-sec">
                <div class="stick">
                    <div class="sticky-area">
                        <div class="quote-pro">
                            @php  
                                $i=1; 
                                $images=[];
                                foreach(json_decode($property->listingImages,true) as $c1){
                                    $images[$c1['sortOrder']]=$c1;
                                }
                            @endphp
                            @if($property->feature_image)
                                @php $image=$property->feature_image;@endphp
                            @else
                                @if($property->listingImages)
                                    @php $io=0; @endphp
                                    @foreach($images as $c1)
                                        @if($i==1)
                                            @php $image=$c1['url']; break;@endphp
                                        @else
                                        @endif
                                        @php $i++;@endphp
                                    @endforeach 
                                @endif
                            @endif
                            @if($image)
                                <div class="pro-img"><img src="{{ asset($image) }}" class="img-fluid" alt="{{$property->title}}" title="{{$property->title}}" /></div>
                            @endif
                            <div class="pro-cont">
                                <p class="home-type">{{ $total_night }} NIGHTS IN {{$property->internalListingName}}</p>
                                <h4 class="pro-name">{{$property->title ?? $property->name}}</h4>
                            </div>
                        </div>
                        <div class="price-details">
                            <p class="p-detail">Payment will be charged when you book this property, please review the <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#myModal2">Cancellation Policy</a> and important information before booking.</p>
                            <div class="price-area">
                                <div class="prc fees">
                                    <div class="fees-value">
                                        <p class="value"><span class="val" style="font-family:sans-serif;">{{$sign}}{{ number_format($base_price/$total_night,2)  }} x {{ $total_night }} nights</span></p>
                                        <div class="discount-price-box">
                                            <div class="price-box-head">
                                                <h5>Base Price Breakdown</h5>
                                            </div>
                                            <div class="price-box-content">
                                            @for($i=0;$i<$total_night;$i++)
                                                @php
                                                        $date = strtotime(Helper::getDateFormatData(Request::get('start_date')));
                                                        $date = strtotime("+".$i." day", $date);
                                                           $date= date('Y-m-d', $date);
                                                @endphp
                                                @foreach(App\Models\HostAway\HostAwayDate::where(["hostaway_id"=>$property->host_away_id,"single_date"=>$date])->get() as $c)
                                                    @php
                                                            if($total_night>29){
                                                              $partnersListingMarkup=$property->monthlyDiscount;
                                                            }elseif($total_night>6){
                                                              $partnersListingMarkup=$property->weeklyDiscount;
                                                            }else{
                                                              $partnersListingMarkup=$property->bookingEngineMarkup;
                                                            } $partnersListingMarkup =1;
                                                    @endphp
                                              
                                              <div>
                                                    <p>{{date('m-d-Y',strtotime($c->single_date))}}</p>
                                                    <p class="amt" style="font-family:sans-serif;">{{$sign}} {{number_format($c->price*$partnersListingMarkup,2)}}</p>
                                                </div>
                                                @endforeach
                                            @endfor
                                            </div>
                                            <div class="price-box-bottom">
                                                <p>Total</p>
                                                <p class="amt" style="font-family:sans-serif;">{{$sign}} {{number_format($base_price,2)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="total" style="font-family:sans-serif;">{{$sign}} {{number_format($base_price,2)}}</p>
                                </div>
                                @foreach($show_data_amount as $key=>$c)
                                    @php
                                        $fee_name=ucfirst($key);
                                        if($fee_name=="Fee"){
                                            $fee_name=" Cleaning Fee";
                                        }
                                        if($fee_name=="Tax"){
                                            $fee_name="Taxes";
                                        }
                                    @endphp
                                    <div class="prc fees">
                                        <div class="fees-value">
                                            <p class="value"><span class="val">{{ $fee_name }}</span></p>
                                            <div class="discount-price-box">
                                                <div class="price-box-head">
                                                    <h5>{{ $fee_name }}</h5>
                                                </div>
                                                <div class="price-box-content">
                                                    @foreach($show_data_amount[$key]['data'] as $c1)
                                                        <div>
                                                            <p>{{$c1['title']}}</p>
                                                            <p class="amt" style="font-family:sans-serif;">{{$sign}} {{number_format($c1['total'],2)}}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="price-box-bottom">
                                                    <p>Total</p>
                                                    <p class="amt" style="font-family:sans-serif;">{{$sign}} {{number_format($show_data_amount[$key]['total'],2)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="total" style="font-family:sans-serif;">{{$sign}} {{number_format($show_data_amount[$key]['total'],2)}}</p>
                                    </div>
                                @endforeach
                                @if($main_data['coupon_id']!="")
                                    <div class="prc fees">
                                       <div class="total-amt cou">
                                          <p class="value">Successful coupon apply</p>
                                       </div>
                                    </div>
                                    <div id="coupon-form" style="display: block;">
                                       <div class="total-amt">
                                            <form method="get"  style="display:inline-block;">
                                                @foreach(Request::except(["coupon"]) as $key=>$c_gaurav)
                                                    <input type="hidden" name="{{  $key }}" value="{{ $c_gaurav }}" />
                                                @endforeach
                                                <label for="name">Promo code</label>
                                                <div class="c-btn">
                                                    <input type="text" class="form-control" disabled value="{{ request()->get("coupon") }}" placeholder="Enter Coupon Code" name="" required="">
                                                    <button class="submit main-btn "><span>Remove Promo code</span></button>
                                                </div>
                                            </form>
                                            <p class="total"></p>
                                       </div>
                                    </div>
                               @else
                                    <div class="prc fees">
                                        <div class="total-amt cou">
                                            <p class="value"><input type="checkbox" name="is_coupon" id="is_coupon"> Do you have promo code?</p>
                                        </div>
                                    </div>
                                    <div id="coupon-form" style="display: none;">
                                       <div class="total-amt">
                                            <form method="get"  style="display:inline-block;">
                                                @foreach(Request::except(["coupon"]) as $key=>$c_gaurav)
                                                    <input type="hidden" name="{{  $key }}" value="{{ $c_gaurav }}" />
                                                @endforeach
                                                <label for="name">Promo Code</label>
                                                <div class="c-btn">
                                                    <input type="text" class="form-control" value="" placeholder="Enter Promo code" name="coupon" required="">
                                                    <button class="submit main-btn "><span>Apply</span></button>
                                                </div>
                                            </form>
                                            <p class="total"></p>
                                       </div>
                                    </div>
                                @endif
                            </div>
                            <div id="main_total_data_show">
                                <div class="total-amt">
                                    <p class="value">Total</p>
                                    <p class="total" style="font-family:sans-serif;">{{$sign}} {{number_format($main_data['data']['totalPrice'],2)}}</span></p>
                                </div>
                            </div>
                            <div class="price-area">
                                @foreach($main_data['data']['components'] as $c)
                                    @if($c['isIncludedInTotalPrice']==0)
                                        @if($c['name']!="baseRate")
                                            <div class="prc fees">
                                                <div class="fees-value">
                                                    <p class="value"><span class="val">{{$c['title']}}</span> 
                                                        @if($c['name']=="damageDeposit")
                                                            <span class="icon">!<span class="box-msg">
                                                                A damage deposit of {{$sign}} {{number_format($c['total'],2)}}  will be collected via your Guest Portal after the completion of your booking.
                                                            </span></span>
                                                        @endif
                                                    </p>
                                                    @if($c['name']!="damageDeposit")
                                                    <div class="discount-price-box">
                                                        <div class="price-box-head">
                                                            <h5>{{$c['title']}}</h5>
                                                        </div>
                                                        <div class="price-box-content">
                                                            <div>
                                                                <p>{{$c['title']}}</p>
                                                                <p class="amt" style="font-family:sans-serif;">{{$sign}} {{number_format($c['total'],2)}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="price-box-bottom">
                                                            <p>Total</p>
                                                            <p class="amt" style="font-family:sans-serif;">{{$sign}} {{number_format($c['total'],2)}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <p class="total" style="font-family:sans-serif;">{{$sign}} {{number_format($c['total'],2)}}</p>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                                @foreach($amount_data_hostaway as $c)
                                    <div class="total-amt">
                                        <p class="value">{{ $c['title'] }} ({{  date('d F-Y',strtotime($c['scheduledDate'])) }})</p>
                                        <p class="total" style="font-family:sans-serif;">{{$sign}} {{number_format($c['amount'],2)}}</span></p>
                                    </div>
                                @endforeach
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('datepicker') }}/dist/css/hotel-datepicker.css"/>
<link rel="stylesheet" href="{{ asset('front')}}/css/datepicker.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/get-quote.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/get-quote-responsive.css" />

@stop
@section("js")
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('front')}}/js/get-quote.js"></script>
<script>
   		@php
            $country = [];
            foreach (App\Models\TblCountry::all() as $c) {
                $country[] = ['flag' => asset('front/flags/' . strtolower($c->ISO2) . '.png'), 'text' => $c->ISO2 . '(+' . $c->E164 . ')', 'id' => '+' . $c->E164];
            }

        @endphp
        $(document).ready(function() {
            function formatOption(option) {
                if (!option.flag) {
                    return option.text;
                }
                var optionWithImage = $('<span><img src="' + option.flag + '" class="img-flag" /> ' + option.text +
                    ' </span>');
                return optionWithImage;
            }
            // Add options dynamically
            var options = {!! json_encode($country) !!};;
            $('#country-select').select2({
                templateResult: formatOption,
                templateSelection: formatOption,
                data: options,

            });
            $('#country-select').val("+61").trigger('change')
        });
  
  
  
    $(document).on("change",".additional_new_data_checkbox_label",function(){
        calculateDataTotalandshow();
    });
    function calculateDataTotalandshow(){
        $html='';
        $total_amount_data=parseFloat($("#total_amount_data").val());
        $(".additional_new_data_checkbox_label").each(function(){
            
            if($(this).prop("checked")===true){
                if($(this).val()=="yes"){
                    amount_data_1=parseFloat($(this).data("amount"));
                    label_data_1=$(this).data("label");
                    console.log(amount_data_1);
                    console.log($total_amount_data);
                    $html+=`<div class="price-area">
                                <div class="prc fees">
                                    <p class="value">`+label_data_1+`</p>
                                    <p class="total">{{$sign}} `+amount_data_1+`</span></p>
                                </div>
                            </div>
                    `;
                    $total_amount_data=$total_amount_data+amount_data_1;
                }
            }
        });

        $html+=`

                    <div class="total-amt">
                        <p class="value">Total</p>
                        <p class="total">{{$sign}} `+$total_amount_data.toFixed(2)+`</span></p>
                    </div>
                `;
        $("#main_total_data_show").html($html);
    }
</script>
<script>



    /**$(document).ready(function() {
      function formatOption(option) {
        if (!option.id) {
          return option.text;
        }
        var optionWithImage = $(
          '<span><img src="' + option.id + '" class="img-flag" /> </span>'
        );
        return optionWithImage;
      }
      // Add options dynamically
      var options = [{ id: '{{asset('front/images/us.png')}}', text: 'United States' }];
      $('#country-select').select2({
        templateResult: formatOption,
        templateSelection: formatOption,
        data: options,
        minimumResultsForSearch: Infinity
      });
    }); ***/

    function functiondec($getter_setter,$show,$cal){
        val=parseInt($($getter_setter).val());
        if($getter_setter=="#adults-data"){
          if(val>1){
              val=val-1;
          }
        }else{
            if(val>0){
              val=val-1;
          }
        }
        $($getter_setter).val(val);
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
        $show_actual_data=$show_data+" Guests";
        if($getter_setter=="#adults-data"){
            $($getter_setter+'-show').html(val);
            if(val<=1){
               $($getter_setter+'-show').html(val); 
            }
        }else{
             $($getter_setter+'-show').html(val);
            if(val<=1){
               $($getter_setter+'-show').html(val); 
            }
        }
        $($show).val($show_actual_data);
    }
     function functioninc($getter_setter,$show,$cal){
        val=parseInt($($getter_setter).val());
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
        val=val+1;
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
        $($getter_setter).val(val);
        $show_actual_data=$show_data+" Guests";
        $($show).val($show_actual_data);
        if($getter_setter=="#adults-data"){
            $($getter_setter+'-show').html(val );
            if(val<=1){
               $($getter_setter+'-show').html(val ); 
            }
        }else{
             $($getter_setter+'-show').html(val );
            if(val<=1){
               $($getter_setter+'-show').html(val ); 
            }
        }
    }


</script>
   <script src="{{ asset('datepicker') }}/node_modules/fecha/dist/fecha.min.js"></script>
   <script src="{{ asset('datepicker') }}/dist/js/hotel-datepicker.js"></script>
    <script>
    @php
        $new_data_blocked=LiveCart::iCalDataCheckInCheckOutCheckinCheckout($property->id);
        $checkin=json_encode($new_data_blocked['checkin']);
        $checkout=json_encode($new_data_blocked['checkout']);
        $blocked=json_encode($new_data_blocked['blocked']);
    @endphp
    function ajaxCallingData(){}
    function clearDataForm(){$("#start_date").val('');$("#end_date").val('');}
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
                inline: true, 
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
                }
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
    function getDateData(objectDate){let day = objectDate.getDate();let month = objectDate.getMonth()+1;let year = objectDate.getFullYear();if (day < 10) {day = '0' + day;}if (month < 10) {month = `0${month}`;}        format1 = `${month}-${day}-${year}`;;return  format1 ;}  
</script>
<div class="modal" id="myModal2">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        <h3 style="color:black;">Cancellation Policy</h3>
        <div class="policy-content">
          @php //dd($cancellation); @endphp
          @if(isset($cancellation['status']))
            @if($cancellation['status']=="success")
                @if(isset($cancellation['result']))
                    @if(isset($cancellation['result']['cancellationPolicyItem']))
                
                      @foreach($cancellation['result']['cancellationPolicyItem']  as $c)
                      <p  style="color:black;">{{ $c['refundAmount'] }}% refund up to {{ ($c['timeDelta']/(60*60*24))*-1 }} days before the {{$c['event']}} date.</p>
                      @endforeach
                    @endif
                @endif
            @endif
          @endif
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form  = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
        $('#sygnius-loader').removeClass('d-none');
        $('#sig-submitBtn').prop('disabled', true);

        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
      console.log(status);
      console.log(response);
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
           $('#sygnius-loader').addClass('d-none');
           $('#sig-submitBtn').prop('disabled', false);

        } else {
            // token contains id, last4, and card type
            var $form = $("#payment-form");
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            //$form.find('input[type=text]').empty();
           $('#sygnius-loader').removeClass('d-none');
           $('#sig-submitBtn').prop('disabled', true);
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
              $form.get(0).submit();
        }
    }
  
});
</script>
@stop