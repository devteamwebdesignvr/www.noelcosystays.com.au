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
@section("css")
    <link href="{{asset('front/royalslider.css')}}" rel="stylesheet">
    <link href="{{asset('front/rs-defaulte166.css')}}" rel="stylesheet">
@stop
@section("container")
@php
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
<a href="#book" class="sticky main-btn book1 book-now"><span class="button-text">BOOK NOW</span></a>
 <section id="property" class="padding_top padding_bottom_half">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 listing1 property-details">
               <div class="upper-box">
                   <div class="row">
                       <div class="col-lg-9 col-md-10 col-8 col-sm-8">
                           <div class="rating" data-aos="fade-up" data-aos-duration="1500">
                               <span class="fa fa-star"></span>
                               <span class="fa fa-star"></span>
                               <span class="fa fa-star"></span>
                               <span class="fa fa-star"></span>
                               <span class="fa fa-star"></span>
                               {{ App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"status"=>"published"])->count() }}+ Review
                           </div>
                           <h3 data-aos="fade-right" data-aos-duration="1500">{{$data->homeawayPropertyName}}</h3> 
                            <div class="hotel-info" data-aos="fade-up" data-aos-duration="1500"><i class="fas fa-map-marker-alt"></i>{{$data->address}}</div>
                       </div>
                       <div class="col-lg-3 col-md-2 col-4 col-sm-4">
                            <div class="price">
                                {!! $setting_data['payment_currency'] !!}{{$data->price}} <span>/ Night</span>
                            </div>
                       </div>
                   </div>
                    <ul class="food-list" data-aos="fade-up" data-aos-duration="1500">
                     @if($data->bedroomsNumber)
                       <li><i class="fa fa-bed" aria-hidden="true"></i>  {{$data->bedroomsNumber}} Bedrooms</li>
                       @endif
                     @if($data->bedsNumber)
                       <li><i class="fa fa-bed" aria-hidden="true"></i>  {{$data->bedsNumber}} Beds</li>
                       @endif
                       @if($data->bathroomsNumber)
                       <li><i class="fa fa-bathtub" aria-hidden="true"></i>  {{$data->bathroomsNumber}} Bathrooms</li>
                       @endif
                       @if($data->personCapacity)
                       <li><i class="fa fa-users" aria-hidden="true"></i>  {{$data->personCapacity}} Sleeps </li>
                       @endif
                       @if($data->squareMeters)
                       <li><i class="fa fa-users" aria-hidden="true"></i>  {{$data->squareMeters}} Area </li>
                       @endif
                       @if($data->minNights)
                       <li><i class="fa fa-users" aria-hidden="true"></i>  {{$data->minNights}} Min Night </li>
                       @endif
                       @if($data->maxNights)
                       <li><i class="fa fa-users" aria-hidden="true"></i>  {{$data->maxNights}} Max Night </li>
                       @endif

                   </ul>
               </div>

                  <section class="blog-details-area ptb-90">
                     <div class="container-fluid" style="" id="calender_nrj">
                        <div class="row">
                           <div class="col-md-12 col-xs-12 col-lg-12  col-sm-12 main-content"style="padding-right: 0px;padding-left: 0px;">
                              <div  class="page wrapper main-wrapper">
                                 <div class="row clearfix">
                                    <div class="col span_6 fwImage"style="text-align: center;">
                                       <div id="gallery-1" class="royalSlider rsDefault">

                                      

                                          @if($data->listingImages)
                                             @php $io=0; @endphp
                                                 @foreach(json_decode($data->listingImages,true) as $c1)

                                               
                                               

                                                 <a class="rsImg"   data-rsBigImg="{{asset($c1['url'])}}" href="{{asset($c1['url'])}}">
                                                               <img width="126" height="82" class="rsTmb" src="{{asset($c1['url'])}}" alt="{{$c1['caption']}}"/>
                                                               <span>{{$c1['caption']}}</span>
                                                              
                                                               </a>
                                                 @php $io++; @endphp
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
                  <!-- Slider js -->
                 
                  <div class="property_meta">
                     <div class="propert-box-sec">
                        <div class="tab-content">
                           <h3 class="heading-2">Overview</h3>
                        </div>
                        <hr class="hr">
                     </div>
                     <div class="overview-content">
                        {!! $data->homeawayPropertyDescription !!}
                     </div>
                     <div class="cta-btn" id="r-more">
                        <a class="main-btn mt-4"><span>Read More</span></a>
                    </div>
                    <div class="cta-btn" id="r-less">
                        <a class="main-btn mt-4"><span>Read Less</span></a>
                    </div>
                  </div>
                  <div id="amenities" class="abouttext" style="margin-top: 30px;">
                      @if($data->listingAmenities)
                     <div class="properties-amenities mb-30">
                        <div class="tab-content">
                           <h3 class="heading-2">Amenities</h3>
                        </div>
                        <hr class="hr">
                  

                  
                        <div class="row">
                          
                           @php $io=0; @endphp
                            @foreach(json_decode($data->listingAmenities,true) as $c1)

                              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                 <ul class="amenities">
                                    <li><i class="fa fa-check"></i> {{ $c1['amenityName']}}</li>
                                 </ul>
                              </div>
                                @php $io++; @endphp
                            @endforeach 
                                           
                          
                        </div>
                     
                     </div>
                       @endif  
                  </div>

            
                  <div id="availability" class="abouttext" style="margin-top: 30px;">
                     <div class="properties-amenities mb-40">
                        <h3 class="heading-2">Availability</h3>
                        <hr class="hr">
                     </div>
                     <div class="calender">
                         <iframe src="{{ url('fullcalendar-demo/'.$data->id) }}"  width="100%" height="400" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                     </div>
                  </div>
                  
                  @if($data->virtual_tour)
                    {!! $data->virtual_tour !!}
                  @endif
                   
                  <div id="reviews" class="abouttext" style="margin-top: 30px;">
                     <div class="inside-properties mb-50">
                        <div class="tab-content">
                           <h3 class="heading-2">Review</h3>
                        </div>
                        <hr class="hr">
                        <div class="comments">
                           <div class="comment">
                            @foreach(App\Models\HostAway\HostAwayReview::where(["listingMapId"=>$data->host_away_id,"status"=>"published"])->get() as $c)
                              <div class="comment-content">
                                 @if($c->rating)
                                 <div class="comment-meta">
                              
                                    <span style="font-size: 14px;">{{ round($c->rating/2,2) }}/5</span>
                                  
                                    @for($i=0;$i<($c->rating/2);$i++)
                                       <span class="fa fa-star checked"></span>
                                    @endfor
                                 </div>
                                 @endif
                                 <div class="comment-meta" style="margin-top: 18px;">
                                    <h3 style="">{{$c->guestName}}</h3>
                                 </div>
                                 <p style="font-size: 14px;line-height: 20px;margin-top: 18px;"></p>
                                 <p>{{$c->publicReview}}</p>
                                 <p></p>
                                 <span style="font-size: 14px;font-weight: 500;">Stayed {{date('F Y',strtotime($c->arrivalDate))}}</span>
                              </div>
                              <hr class="hr">
                            @endforeach



                           </div>
                        </div>
                     </div>
                  </div>
               </div>
    <div class="col-lg-4" id="book">
       <div class="get-quote">
           <div class="forms-booking-tab">
              <ul class="tabs">
                 <li class="item booking active" data-form="ovabrw_booking_form">Request A Quote</li>
              </ul>
              <div class="ovabrw_booking_form" id="ovabrw_booking_form" style="">
                 <form class="form booking_form" id="booking_form" action="{{ url('get-quote') }}" method="get" >
                     <input type="hidden" name="property_id" value="{{ $data->id }}">

                    <div class="ovabrw_datetime_wrapper">
                        {!! Form::text("start_date",Request::get("start_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtFrom","placeholder"=>"Check in"]) !!}
                       <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div class="ovabrw_datetime_wrapper">
                       {!! Form::text("end_date",Request::get("end_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtTo","placeholder"=>"Check Out"]) !!}
                       <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    
                  
                   <div class="row"   style="display: none; " >
                                             <!--<div class="col-md-12" style="text-align: left;padding-top: 15px;color: #02c3ff;">-->
                                                 <!--<label>No. of Pet</label>-->
                                             <!--</div>-->
                                             <div class="col-md-12 pets" style="">
                                                 {!! Form::selectRange("no_of_pets",1,$data->max_pet,null,["class"=>"form-control","style"=>"border: 1px solid #cacaca;margin-top: 0px;","id"=>"pet_fee_data_guarav","placeholder"=>"Pets"]) !!}
                                                 <i class="fa-solid fa-paw"></i>
                                             </div>
                                         </div>
                    <div class="ovabrw_service_select rental_item">
                         <input type="text" name="Guests" required value="{{ Request::get('Guests') ?? '1 Guests' }}" readonly class="form-control gst" id="show-target-data" placeholder="Guests">
                   
                              
                              <input type="hidden" value="{{ Request::get('adults') ?? '1' }}" name="adults" id="adults-data" />
                              <input type="hidden" value="{{ Request::get('child') ?? '0' }}" name="child" id="child-data" />
                              
                              
                              <div class="adult-popup">
                             <div class="modal-bodyss" id="guestsss">
                                 <p class="close1" onclick=""><i class="fa fa-times"></i></p>
                                  <div class="ac-box">
                                     <div class="adult">
                                        <span id="adults-data-show">
                                            @if(Request::get('adults'))
                                               @if(Request::get('adults')>1)
                                                   {{ Request::get('adults') }} Adults
                                               @else
                                                   {{ Request::get('adults') }} Adult
                                               @endif
                                            @else
                                            1 Adult
                                            @endif
                                        </span>
                                        <p>(18+)</p>
                                     </div>
                                     <div class="btnssss">
                                        <div class="button button1 btnnn" onclick="functiondec('#adults-data','#show-target-data','#child-data')" value="Increment Value">-</div>  
                                        <div class="button11 button1" onclick="functioninc('#adults-data','#show-target-data','#child-data')" value="Increment Value">+</div>
                                     </div>
                                  </div>
                                   <div class="ac-box">
                                     <div class="adult">
                                        <span id="child-data-show">
                                             @if(Request::get('adults'))
                                               @if(Request::get('adults')>1)
                                                   {{ Request::get('adults') }} Children
                                               @else
                                                   {{ Request::get('adults') }} Child
                                               @endif
                                            @else
                                            Child
                                            @endif
                                        </span>
                                        <p>(0-17)</p>
                                     </div>
                                     <div class="btnssss btnsss">
                                        <div class="button button1" onclick="functiondec('#child-data','#show-target-data','#adults-data')" value="Increment Value">-</div> 
                                        <div class="button11 button1" onclick="functioninc('#child-data','#show-target-data','#adults-data')" value="Increment Value">+</div>
                                     </div>
                                  </div>
                                  <button type="button" class="btn main-btn close1" data-dismiss="modal" onclick=""><span>Apply</span></button>
                              </div>
                         </div>
                       <i class="fa-solid fa-users"></i>
                    </div>

                    

                          <div id="gaurav-new-data-area">
                            
                           </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ovabrw-book-now" >
                                            <button type="button" class="main-btn"  id="reset-button-gaurav-data">
                                             <span>Reset</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="ovabrw-book-now"  id="submit-button-gaurav-data1">
                                            <button type="submit" class="main-btn">
                                            <span> Reserve</span></button>
                                        </div>
                                    </div>
                                </div>
                              
                              <p>Or<br>Contact Owner</p>
                              <p><a href="mailto:{!! $setting_data['email'] ?? '#' !!}"><i class="fa-solid fa-envelope"></i> {!! $setting_data['email'] ?? '#' !!}</a></p>
                 </form>
              </div>
           </div>
        </div>
     </div>




           
            </div>
         </div>
      </section>
@if($data->map)
<div class="map" id="#map">
    <iframe src="{!! $data->map !!}" width="100%" height="400" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
@endif
@stop

@section("js")  
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

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><span>Close</span></button>
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
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><span>Close</span></button>
      </div>

    </div>
  </div>
</div>
<script src="{{asset('front/jquery.royalslider.minf76d.js')}}"></script> 
<script src="https://rawgit.com/jedfoster/Readmore.js/master/readmore.js"></script>
<script>
    function functiondec($getter_setter,$show,$cal){
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
        val=parseInt($($getter_setter).val());
        val=val+1;
        $($getter_setter).val(val);
        person1=val;
        person2=parseInt($($cal).val());
        $show_data=person1+person2;
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
    $('.more').readmore({speed: 75, collapsedHeight:312,moreLink: '<a class="ac" href="#">Show more</a>', lessLink: '<a class="kapat" href="#">Show Less</a>'});
</script>
<script src="{{ asset('front/js/showmore.js')}}"></script>
<script>
$(function(){$(".datepicker").datepicker();});
@php
    $new_data_blocked=LiveCart::iCalDataCheckInCheckOut($data->id);
    $checkin=$new_data_blocked['checkin'];
    $checkout=$new_data_blocked['checkout'];
@endphp
    var checkin = <?php echo json_encode($checkin);  ?>;
    var checkout = <?php echo json_encode($checkout);  ?>;
    $(function() {
        $("#txtFrom").datepicker({
            numberOfMonths: 1,
            minDate: '@minDate',
            dateFormat: 'yy-mm-dd',
            beforeShowDay: function(date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [checkin.indexOf(string) == -1];
            },
            onSelect: function(selected) {
                $("#submit-button-gaurav-data").hide();
                var dt = new Date(selected);
                dt.setDate(dt.getDate() + 1);
                $("#txtTo").datepicker("option", "minDate", dt);
                $("#txtTo").val('');
            },
            onClose: function() {
                $("#txtTo").datepicker("show");
            }
        });
        $("#txtTo").datepicker({
            numberOfMonths: 1,
            dateFormat: 'yy-mm-dd', 
            beforeShowDay: function(date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [checkout.indexOf(string) == -1];
            },
            onSelect: function(selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() - 1);
                $("#txtFrom").datepicker("option", "maxDate", dt);
                ajaxCallingData();
            },
            onClose: function() {
                $('.popover-1').addClass('opened');
            }
        });
    });
    $("#reset-button-gaurav-data").click(function(){
        $("#txtFrom").val('');
        $("#txtTo").val('');
        $("#adults-area").val('');
        $("#child-area").val('');
        $("#adults-data").val(0);
        $("#child-data").val(0);
        $("#show-target-data").val(null);
        $("#submit-button-gaurav-data").hide();
        $("#gaurav-new-modal-days-area").html('');
        $("#gaurav-new-modal-service-area").html('');
        $("#gaurav-new-data-area").html('');
        $("#adults-data-show").html("Adult");
        $("#child-data-show").html("Child");
        $("#pet_fee_data_guarav").val(0)
        $("#txtFrom").datepicker("option", "maxDate",  '2043-10-10');
    });
    @php
    if(Request::get("start_date")){
        if(Request::get("end_date")){
            @endphp
                $(document).ready(function(){
                    ajaxCallingData();
                });
            @php
        }
    }
    @endphp
    $(document).on("change","#pet_fee_data_guarav",function(){
        ajaxCallingData();
    });
    function ajaxCallingData(){
    }
jQuery(document).ready(function($) {
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
         numImagesToPreload:2,
         arrowsNav:true,
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
    $('.rsContainer').on('touchmove touchend', function(){});
    var a = $(".overview-content").height();
    if(a < 245){
        $("#r-more").css("display", "none");
    }
    else{
        $("#r-more").css("display", "block");
        $(".overview-content").css("height", "245px");
    }

    $("#r-more").click(function(){
        $("#r-less").css("display", "block");
        $("#r-more").css("display", "none");
        $(".overview-content").css("height", "auto");
    });
    $("#r-less").click(function(){
        $("#r-less").css("display", "none");
        $("#r-more").css("display", "block");
        $(".overview-content").css("height", "245px");
    });
});

  </script>
@stop