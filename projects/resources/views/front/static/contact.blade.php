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
            <h1  class="aos-init aos-animate">{{$name}}</h1>
            <div class="checklist">
                <p>
                    <a href="{{url('/')}}" class="text"><span>Home</span></a>
                    <a class="g-transparent-a">{{$name}}</a>
                </p>
            </div>
        </div>
    </section>
    <!-- end banner sec -->



    <!-- start about section -->
    <section class="contact-page-section">
        <div class="container">
            <div class="row">
                <!-- Contact Info Box -->
            <!-- Sec Title -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12 contact-details">
                    <div class="contact-detail">
                      {!! $data->longDescription !!}
                          </div>
                    <ul class="contact-info">
                        <li><a href="mailto:{!! $setting_data['email'] !!}"><img src="{{ asset('front')}}/images/email.webp" alt=""><span>Email:</span>{!! $setting_data['email'] !!}</a></li>
                        <li><a href="mailto:{!! $setting_data['mobile'] !!}"><img src="{{ asset('front')}}/images/phone.webp" alt=""><span>Phone:</span>{!! $setting_data['mobile'] !!}</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-12 contact-form">
                    <div class="inner-container" >
                        <div class="sec-title">
                            <h3>Send us a message</h3>
                            
                        </div>
                        <div class="contact-form">
                            {!! Form::open(["route"=>"contactPost"])  !!}
                                <div class="row clearfix">
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label>First Name</label>
                                        <input type="text" name="f_name" id="form_fname" placeholder="First name" value="" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label>Last Name</label>
                                        <input type="text" name="l_name" id="form_lname" placeholder="Last name" value="" required="">
                                    </div>
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label>Email Address</label>
                                        <input type="email" name="email" id="form_email" placeholder="Enter email address" value="" required="">
                                    </div>
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Phone Number</label>
                                        <input type="number" name="mobile" id="form_phone" placeholder="Enter phone number" value="" required="">
                                    </div>
                                  
                                  
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>How did you hear about us?</label>
                                        {!! Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"","placeholder"=>"--Select--"]) !!}
                                    </div> 
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Message</label>
                                        <textarea class="" name="message" id="msg" placeholder="Enter message..." required=""></textarea>
                                    </div> 
                               
                                     @if($setting_data['g_captcha_enabled'])
                                        @if($setting_data['g_captcha_enabled']=="yes")
                                            @if($setting_data['google_captcha_site_key']!="" && $setting_data['google_captcha_secret_key']!="")
                							<script src="https://www.google.com/recaptcha/api.js" async defer></script>
                							<div class="form-group col-lg-12 col-md-12 col-sm-12">
                							    <div class="g-recaptcha" data-sitekey="{{ $setting_data['google_captcha_site_key'] }}"></div>
                							 </div>  
                							 @endif
        							    @endif
        							 @endif
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <button type="submit" name="submit" class="main-btn"><span>Send Message</span></button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        </section>


  
@stop
@section("css")
@parent
<link rel="stylesheet" href="{{ asset('front')}}/css/contact.css" />
<link rel="stylesheet" href="{{ asset('front')}}/css/contact-responsive.css" />
@stop
@section("js")
<script>
$('#reload').click(function () {
    $.ajax({
        type: 'GET',
        url: "{{ url('reload-captcha')}}",
        success: function (data) {
            $(".captcha span").html(data.captcha);
        }
    });
});
</script>
@stop