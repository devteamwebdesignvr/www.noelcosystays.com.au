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
<div class="loader-head " id="sygnius-loader">
    <div class="loader">
    	<img src="{{ asset($setting_data['header_logo'] ?? 'front/images/logo.png') }}" alt="Logo" class="img-fluid logo-loader">
    	<img src="{{ asset('front')}}/images/scroll-loader1.gif" alt="">
    	<p>Please wait while we confirm your reservation</p>
    </div>
</div>
    @php
        $name=$data->name;
        $bannerImage=asset('front/images/breadcrumb.webp');
        if($data->bannerImage){
            $bannerImage=asset($data->bannerImage);
        }
        $total_guests=Request::get('adults')+Request::get('child');
        $now = strtotime(Request::get("start_date")); 
        $your_date = strtotime(Request::get("end_date"));
        $datediff =  $your_date-$now;
        $day= ceil($datediff / (60 * 60 * 24));
        $total_night=$day;
        $sign=$property->currencyCode;
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
        $start_date=Request::get("start_date");
        $end_date=Request::get("end_date");
        $adult=Request::get("adults");
        $child=Request::get("child");
        $adults=Request::get("adults");
        $child=Request::get("child");
        $total_guests=$adults+$child;
   //    dd($main_data);
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
@php
    $show_data_amount=[];
@endphp
@foreach($main_data['data']['components'] as $c)
    @if($c['isIncludedInTotalPrice']==1)
        @if($c['name']=="baseRate")
            @php
                $base_price=$c['total']; 
            @endphp
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
@php
//dd($show_data_amount);
@endphp
<section class="get-quote">
	<div class="container">
        <p class="detail-page"><a href="{{ url($property->seo_url) }}"><i class="fa-solid fa-arrow-left"></i><span>Listing page</span></a></p>
		<div class="row quote-area">
			<div class="col-6 quote-detail">
				
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
										<h3>1 Guest selected</h3>
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
									<button type="submit" class="main-btn">
									<span>Apply</span></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<form 
				    action='{{route("save-booking-data")}}'
			     	method="post"
                    id="payment-form">
				    @csrf
				    
                    <input type="hidden" name="amount_data" value="{{ json_encode($main_data) }}" />
                    <input type="hidden" name="property_id" value="{{ $property->id }}" />
                    <input type="hidden" name="checkin" value="{{ Request::get('start_date') }}"  />
                    <input type="hidden" name="checkout" value="{{ Request::get('end_date') }}"  />
                    <input type="hidden" name="adults" value="{{ Request::get('adults') }}"  />
                    <input type="hidden" name="child" value="{{ Request::get('child') }}"  />
                    <input type="hidden" name="total_guests" value="{{ $total_guests }}"  />
                    <input type="hidden" name="gross_amount" value="{{ $main_data['data']['totalPrice'] }}"  />
                    <input type="hidden" name="amount" value="{{ $main_data['data']['totalPrice'] }}"  />
                    <input type="hidden" name="days" value="{{ $day }}"  />
                    <input type="hidden" name="total_night" value="{{ $day }}"  />
                    <input type="hidden" name="request_id" value="{{ uniqid() }}"  />
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
    						 <div id="dropin-container"></div>
                                <input type="hidden" id="nonce" name="payment_method_nonce">
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
    								<select name="phone" id="country-select">
    								</select>
    								<div class="from-number">
    									<span class="phone-number">Phone number</span>
    									<div class="form-text">
    										<span>(+1)</span>
    										<input type="tel" class="form-control" id="mobile"  title="Enter Mobile" name="mobile" required>
    									</div>
    								</div>
    							</div>
    							<div class="col-12 form-floating">
    								<input type="email" class="form-control" id="email" placeholder="Enter Email" title="Enter Email" name="email" required=""> 
    								<label for="email">Email address*</label>
    							</div>
    							<div class="col-12 form-floating d-none">
    								<textarea class="form-control" name="message" placeholder="Enter Message" title="Enter Message" id="floatingTextarea"></textarea>
    								<label for="floatingTextarea">Message</label>
    							</div> 
    						</div>
    						<div class="form-message">
    							<p>The booking confirmation will be sent to this email address.</p>
    						</div>
    						<div class="form-input">
    							<h4>Complete booking</h4>
    							<div class="form-input-details">
    								<input type="checkbox" name="complete" required>
    								<label for="complete">
    								    By completing this booking, you agree to the 
    								    <a href="{{ url('terms-and-conditions') }}"  target="_BLANK" >Terms and Conditions</a> and 
    								    <a href="{{ url('privacy-policy') }}"  target="_BLANK" >Privacy Policy</a> and 
    								    <a href="javascript:;">House Rules 	<span class="icon">!<span class="box-msg">{!! $property->houseRules !!}</span></span></a>.
    								</label>
    							</div>
    						</div>
    						<div class="form-btn sub">
    							<button type="submit" class="submit main-btn" name="operation" value="send-quote"><span>Confirm and book now <i class="fa-solid fa-arrow-right"></i></span></button>
    						</div>
    				
    				</div>
				</form>
			</div>
			<div class="col-6 book-detail-sec">
				<div class="stick">
					<div class="sticky-area">
						<div class="quote-pro">
						    @php  $i=1; @endphp
            				@if($property->feature_image)
            					@php $image=$property->feature_image;@endphp
            				@else
                				@if($property->listingImages)
                					@php $io=0; @endphp
                					@foreach(json_decode($property->listingImages,true) as $c1)
                    					@if($i==1)
                    					    @php $image=$c1['url'];@endphp
                    					@else
                    					@endif
                					@endforeach 
                				@endif
        					@endif
        					@if($image)
							<div class="pro-img">
								<img src="{{ asset($image) }}" class="img-fluid" alt="{{$property->title}}" title="{{$property->title}}" />
							</div>
							@endif
							<div class="pro-cont">
								<p class="home-type">{{ $total_night }} NIGHTS IN {{$property->internalListingName}}</p>
								<h4 class="pro-name">{{$property->title}}</h4>
							</div>
						</div>
						<div class="price-details">
							<p class="p-detail">Payment will be charged when you book this property, please review the <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#myModal2">Cancellation Policy</a> and important information before booking.</p>
							<div class="price-area">
								<div class="prc fees">
									<div class="fees-value">
										<p class="value"><span class="val">${{ number_format($base_price/$total_night,2)  }} X {{ $total_night }} Nights</span></p>
										<div class="discount-price-box">
											<!-- <button type="button" class="btn-close"></button> -->
											<div class="price-box-head">
												<h5>Base Price</h5>
											</div>
											<div class="price-box-content">
												<div>
													<p>{!! $sign !!} {{ number_format($base_price/$total_night,2)  }} * {{ $total_night }}nights</p>
													<p class="amt">{{$sign}} {{number_format($base_price,2)}}</p>
												</div>
											</div>
											<div class="price-box-bottom">
												<p>Total</p>
												<p class="amt">{{$sign}} {{number_format($base_price,2)}}</p>
											</div>
										</div>
									</div>
									<p class="total">{{$sign}} {{number_format($base_price,2)}}</p>
								</div>
					             @foreach($show_data_amount as $key=>$c)
                               
                                      
								            <div class="prc fees">
            									<div class="fees-value">
            										<p class="value"><span class="val">{{ucfirst($key)}}</span> 
        										    
													</p>
												    	<div class="discount-price-box">
                                                    		<div class="price-box-head">
                                                    			<h5>{{ucfirst($key)}}</h5>
                                                    		</div>
                                                    		<div class="price-box-content">
                                                    		    @foreach($show_data_amount[$key]['data'] as $c1)
                                                    			<div>
                                                    				<p>{{$c1['title']}}</p>
                                                    				<p class="amt">{{$sign}} {{number_format($c1['total'],2)}}</p>
                                                    			</div>
                                                    		    @endforeach
                                                    			
                                                    		</div>
                                                    		<div class="price-box-bottom">
                                                    			<p>Total</p>
                                                    			<p class="amt">{{$sign}} {{number_format($show_data_amount[$key]['total'],2)}}</p>
                                                    		</div>
                                                    	</div>
            									
            									
            									</div>
            									<p class="total">{{$sign}} {{number_format($show_data_amount[$key]['total'],2)}}</p>
            								</div>
					                  
                               @endforeach
							</div>
							<div class="total-amt">
								<p class="value">Total</p>
								<p class="total">{{$sign}} {{number_format($main_data['data']['totalPrice'],2)}}</span></p>
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
        														Prior to your check-in, a refundable damage deposit of {{$sign}} {{number_format($c['total'],2)}}  will be pre-authorized on your credit card.
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
            													<p class="amt">{{$sign}} {{number_format($c['total'],2)}}</p>
            												</div>
            											</div>
            											<div class="price-box-bottom">
            												<p>Total</p>
            												<p class="amt">{{$sign}} {{number_format($c['total'],2)}}</p>
            											</div>
            										</div>
            										@endif
            									</div>
            									<p class="total">{{$sign}} {{number_format($c['total'],2)}}</p>
            								</div>
					                     @endif
                                   @endif
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
$(function(){
    $("#sygnius-loader").addClass("d-none");
})
    function functiondec($getter_setter,$show,$cal){
       // $("#submit-button-gaurav-data").hide();
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
	$(document).ready(function() {
	  function formatOption(option) {
	    if (!option.id) {
	      return option.text;
	    }
	    var optionWithImage = $('<span><img src="' + option.id + '" class="img-flag" /> </span>');
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
	});
$(document).on("form","submit",function(){
    $("#sygnius-loader").removeClass("d-none");
});
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
                        $("#demo17").val("{{ request()->start_date }} - {{ request()->end_date }}")
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
                },
                clearButton:function(){
                    return false;
                },
            }
        );
        @if(Request::get("start_date"))
            @if(Request::get("end_date"))
                setTimeout(function(){
                        $("#demo17").val("{{ request()->start_date }} - {{ request()->end_date }}")
                        document.getElementById("start_date").value ="{{ request()->start_date }}";
                        document.getElementById("end_date").value ="{{ request()->end_date }}";
                           ajaxCallingData();
                    },1000);
            @endif
        @endif
    })();
    $(document).on("click","#clear",function(){
        $("#clear-demo17").click();
    })
    x=document.getElementById("month-2-demo17");
    x.querySelector(".datepicker__month-button--next").addEventListener("click", function(){
        y=document.getElementById("month-1-demo17");
        y.querySelector(".datepicker__month-button--next").click();
    })  ;
    x=document.getElementById("month-1-demo17");
    x.querySelector(".datepicker__month-button--prev").addEventListener("click", function(){
        y=document.getElementById("month-2-demo17");
        y.querySelector(".datepicker__month-button--prev").click();
    })  ;
    function getDateData(objectDate){let day = objectDate.getDate();let month = objectDate.getMonth()+1;let year = objectDate.getFullYear();if (day < 10) {day = '0' + day;}if (month < 10) {month = `0${month}`;}format1 = `${year}-${month}-${day}`;return  format1 ;}  
</script>
<!-- The Modal -->
<div class="modal" id="myModal2">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
      	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        <h3>Cancellation Policy</h3>
        <div class="policy-content">
        	<p>100% refund up to 14 days before the arrival date.</p>
        	<p>50% refund up to 7 days before the arrival date.</p>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script src="https://js.braintreegateway.com/web/dropin/1.35.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";

        braintree.dropin.create({
            authorization: client_token,
            container: '#dropin-container',
  googlePay: {
    googlePayVersion: 2,
    merchantId: 'merchant-id-from-google',
    transactionInfo: {
      totalPriceStatus: 'FINAL',
      totalPrice: '{{  $main_data['data']['totalPrice'] }}',
      currencyCode: 'USD'
    },
    allowedPaymentMethods: [{
      type: 'CARD',
      parameters: {
        // We recommend collecting and passing billing address information with all Google Pay transactions as a best practice.
        billingAddressRequired: true,
        billingAddressParameters: {
          format: 'FULL'
        }
      }
    }]
  },  venmo: {} ,  paypal: {
    flow: 'checkout',
    amount: '{{  $main_data['data']['totalPrice'] }}',
    currency: 'USD'
  }
        }, function (createErr, instance) {
            if (createErr) {
                console.error(createErr);
                toastr.error(createErr);
                return;
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                  $("#sygnius-loader").removeClass("d-none");
                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.error(err);
                          toastr.error(err);
                          $("#sygnius-loader").addClass("d-none");
                        return;
                    }

                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>

@stop