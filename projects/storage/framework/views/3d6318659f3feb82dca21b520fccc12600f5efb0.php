<?php $__env->startSection("title",$data->meta_title); ?>
<?php $__env->startSection("keywords",$data->meta_keywords); ?>
<?php $__env->startSection("description",$data->meta_description); ?>
<?php $__env->startSection("logo",$data->image); ?>
<?php $__env->startSection("header-section"); ?>
<?php echo $data->header_section; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("footer-section"); ?>
<?php echo $data->footer_section; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("container"); ?>
<?php $payment_currency=ModelHelper::getDataFromSetting('payment_currency'); ?>
<style>
   .readMore a {
   color: white;
   }
</style>
<!-- Banner slider -->
<section class="banner-wrapper p-0">
   <div class="video-sec">
      <video src="<?php echo asset($setting_data['home_video']); ?>" loop="" muted="" autoplay="" playsinline="" class="js-hero-slide__inner" id="mob"></video>
      <button onclick="playVideo()" id="play"><i class="fa-solid fa-play"></i></button>
      <button onclick="pauseVideo()" id="pause"><i class="fa-solid fa-pause"></i></button>
      <div class="overlay">
         <div class="hero-content aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1500">
            <div class="container">
               <?php echo $setting_data['home-video-text']; ?>

            </div>
         </div>
      </div>
   </div>
   <div class="search-sec" >
      <div class="container">
         <div class="search-bar">
              
            <form method="get" action="<?php echo e(url('properties')); ?>">
               <div class="row">
                  <div class="col-2 md-12 sm-12 select d-none">
                    <label for="check-in">Location</label>
                     <?php echo Form::select("location_id",ModelHelper::getLocationSelectList(),null,["class"=>"","placeholder"=>"Location","title"=>"Location","id"=>"loc"]); ?>

                  </div>
                  <div class="col-6 col-lg md-6 icns mb-lg-0 position-relative  datepicker-section datepicker-common-2 main-check">
                     <div class="row">
                        <div class="check left icns mb-lg-0 position-relative datepicker-common-2">
                           <label for="check-in">Check In</label>
                           <?php echo Form::text("start_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"start_date","placeholder"=>"check in","class"=>"form-control d-none"]); ?>

                           <div class="form-dates">
                              <span class="dates" id="chooesen_start_date">-</span>
                              <span class="months" id="chooesen_start_month"></span>
                           
                           </div>
                        </div>
                        <div class="check right icns mb-lg-0 position-relative datepicker-common-2 check-out">
                           <label for="check-out">Check Out</label>
                           <?php echo Form::text("end_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"end_date","placeholder"=>"check out","class"=>" form-control lst d-none" ]); ?>

                           <div class="form-dates">
                              <span class="dates" id="chooesen_end_date">-</span>
                              <span class="months" id="chooesen_end_month"></span>
                           </div>
                        </div>
                        <div class="col-12 md-12 sm-12 datepicker-common-2 datepicker-main">
                           <input type="text" id="demo17" value="" aria-label="Check-in and check-out dates" aria-describedby="demo17-input-description" readonly />
                        </div>
                     </div>
                  </div>
                  <div class="col-3 md-12 sm-12 guest d-none">
                     <label for="guests">Adult</label>
                     <!--<input type="text" name="Guests" readonly="" value="1 Guests" class="form-control gst" id="show-target-data" placeholder="Adult" title="Select Guests">-->
                     <img src="<?php echo e(asset('/')); ?>/front/images/user.png" alt="">
                     <input type="hidden" value="1" name="adults" id="adults-data" />
                     <input type="hidden" value="0" name="child" id="child-data" />
                     <div class="adult-popup" id="guestsss">
                        <i class="fa fa-times close1"></i>
                        <div class="adult-box">
                           <div class="adult-value">
                              <p id="adults-data-show">0 Adult</p>
                              <!-- <p class="adult-name">Adult</p> -->
                           </div>

                           <div class="adult-btn">
                              <button class="button1" type="button" onclick="functiondec('#adults-data','#show-target-data','#child-data')" value="Decrement Value">-</button>
                              <button class="button11 button1" type="button" onclick="functioninc('#adults-data','#show-target-data','#child-data')" value="Increment Value">+</button>
                           </div>
                        </div>
                        <div class="adult-box d-none">
                           <div class="adult-value">
                              <p id="child-data-show">0 Children</p>
                              <!-- <p class="adult-name">Children</p> -->
                           </div>
                           <div class="adult-btn">
                              <button class="button1" type="button" onclick="functiondec('#child-data','#show-target-data','#adults-data')" value="Decrement Value">-</button>
                              <button class="button11 button1" type="button" onclick="functioninc('#child-data','#show-target-data','#adults-data')" value="Increment Value">+</button>
                           </div>
                        </div>
                        <div class="pets-box d-none">
                           <p class="pets-label">Pets</p>
                           <div class="pets-calculator">
                              <div class="pets-value">
                                 <label for="pets-yes">Yes</label>
                                 <input type="radio" id="pets-yes" name="pets" value="Yes">
                              </div>
                              <div class="pets-value">
                                 <label for="pets-no">No</label>
                                 <input type="radio" id="pets-no" name="pets" value="No">
                              </div>
                           </div>
                        </div>
                        <button class="main-btn  close111" type="button" onclick=""><span>Apply</span></button>
                     </div>
                  </div>
                  <div class="col-3 md-12 sm-12 guest-info">
                     <label for="guest-field">Guests</label>
                     <select name="Guests" id="Guests">
                        <?php for($i=1; $i<=26; $i++): ?>
                        <option value="<?php echo e($i); ?> Guests" <?php if(Request::get('Guests') == "$i Guests"): ?> selected <?php endif; ?>><?php echo e($i); ?> <?php if($i<2): ?> Guest <?php else: ?> Guests <?php endif; ?></option>
                        <?php endfor; ?>
                     </select>
                  </div>
                  <div class="col-3 md-12 sm-12 srch-btn">
                     <button type="submit" class="main-btn "><span>Check Availability</span></button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>

</section>


<?php
$list=App\Models\HostAway\HostAwayProperty::where(["is_home"=>"true","is_active"=>"true","status"=>"true"])->orderBy("id","desc")->get();
?>
<?php if(count($list)>0): ?>     
<section class="home-list">
   <div class="container">
<div class="head-sec">
			<h2>Vacation Rentals</h2>
		</div>
      <div class="row">
         <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-lg-4 col-md-6 col-sm-12 prop-card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1500">
            <div class="pro-img">
              <?php
             $images=[];
             foreach(json_decode($c->listingImages,true) as $c1){
                $images[$c1['sortOrder']]=$c1;
             } 
            $i=0; 
         ?>
         <?php if($c->feature_image): ?>
            <?php $image=$c->feature_image;?>
         <?php else: ?>
             <?php if($c->listingImages): ?>
                 <?php $io=0; ?>
                 <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($i==0): ?>
                        <?php $image=$c1['url'];  $i++; break;?>
                     <?php else: ?>
                     <?php endif; ?>
                 <?php $i++;?>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
             <?php endif; ?>
         <?php endif; ?>
              
            <a href="<?php echo e(url($c->seo_url)); ?>"><img src="<?php echo e(asset($image)); ?>" class="img-fluid" alt="<?php echo e($c->name); ?>"></a>
           
            </div>
            <div class="pro-cont ">
               <h3 class="title"><a href="<?php echo e(url($c->seo_url)); ?>"><?php echo e($c->title ?? $c->name); ?></a></h3>
               <div class="amn">
                     <ul class="first">
                  <?php if($c->personCapacity): ?>
                      <li><i class="fa-solid fa-user"></i><?php echo e($c->personCapacity); ?> Guests </li>
                  <?php endif; ?>
                  <?php if($c->bedroomsNumber): ?>
                      <li><i class="fa-solid fa-bed"></i><?php echo e($c->bedroomsNumber); ?> Beds </li>
                  <?php endif; ?>
                  <?php if($c->bathroomsNumber): ?>
                      <li><i class="fa-solid fa-bath"></i><?php echo e($c->bathroomsNumber); ?> Baths </li>
                  <?php endif; ?>
               </ul>
               </div>
                 <?php
                  $price=$data->price;
                  $ar1=App\Models\HostAway\HostAwayDate::where("single_date",date('Y-m-d'))->where("hostaway_id",$c->host_away_id)->first();
                  if($ar1){
                  $price=$ar1->price;
                  }
                  ?>
                  <?php if($price): ?>               
                 <div class="prop-view-btn">
                       	<div class="view">
						<h5>From <span>
							<?php echo e($payment_currency); ?><?php echo e($price); ?>

							</span> / Night
						</h5>
					</div>
						<a href="<?php echo e(url($c->seo_url)); ?>" class="main-btn">Book Now</a>
					</div>
            </div><?php endif; ?>


         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      
   </div>
</section>
<?php endif; ?>

<!-- section about us -->
<section class="about-us-home" >
   <div class="container">
      <div class="row">
         <div class="col-lg-5 col-12 abt-left">
            <!--  <div class="head-sec">
               <p>About us</p>
               
               </div> -->
            <div class="abt-cont">
               <h2 data-aos="zoom-in-right" data-aos-duration="1500">About us</h2>

               <p data-aos="zoom-in-right" data-aos-duration="1500"><?php echo $data->mediumDescription; ?></p>
            </div>
            <a  href="<?php echo e(url('about-us')); ?>" class="main-btn" data-aos="fade-up" data-aos-duration="1000">
            <span class="circle">
            <span class="icon arrow"></span>
            </span>
            <span class="button-text">View More</span>
            </a>
         </div>
         <div class="col-lg-7 col-12 abt-right">
            <div class="abt-co-img">
                              <div class="abt-co-img-left" >
                  <?php if($data->about_image1): ?><img src="<?php echo e(asset($data->about_image1)); ?>" class="img-fluid" alt=""><?php endif; ?>
               </div>
                                             <div class="abt-co-img-right" >
                  <?php if($data->about_image2): ?><img src="<?php echo e(asset($data->about_image2)); ?>" class="img-fluid" alt=""><?php endif; ?>
               </div>
                           </div>
         </div>
      </div>
   </div>
</section>

<!--location cards-->

<?php
$locaiton = App\Models\Location::where("status","true")->orderBy('id')->get();
?>
<?php if(count($locaiton)): ?>
<section class="featured-pro d-none" id="abt">
  <div class="container">
    <div class="head-sec">
      <h2>
        Locations We Host
      </h2>
    </div>
    <div class="row">
      <?php $__currentLoopData = $locaiton; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-lg-6 col-md-6 col-12 main-prop" data-aos="fade-top" data-aos-duration="1000">
        <div class="prop-contt">
          <div class="pro-img">
            <?php if($c->image): ?><img src="<?php echo e(asset($c->image)); ?>" class="img-fluid" alt="<?php echo e($c->name); ?>"><?php endif; ?>
          </div>
          <div class="pro-cont">
            <h3 class="title">
              <?php echo e($c->name); ?>

            </h3>
            <div class="line">
            </div>
          </div>
          <a href="<?php echo e(url('properties/location/'.$c->seo_url)); ?>">
          </a>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>



<section class="gallery d-none">
    <div class="container">
        <div class="row">
            <div class="col-3 md-12 sm-12">
                <div class="head-sec">
                    <div id="arrow-overview" class="arrow-mask-wrap arrow-mask-right affix">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 94.33 17.9"><defs><style>.cls-1 {fill: #fff;stroke: #313C2F;stroke-miterlimit: 10;}</style></defs><g id="arrow-right-long" data-name="arrow-right-long-Layer 2"><g id="arrow-right-long-Layer_1-2" data-name="arrow-right-long-Layer 1"><polyline class="cls-1" points="84.59 0.37 93.6 8.57 84.59 17.55"></polyline><line class="cls-1" x1="93.6" y1="8.57" y2="8.57"></line></g></g></svg>
                    </div>
                    <h2>Photo <br>Gallery </h2>
                </div>
                <a href="#" data-href="<?php echo e(url('gallery')); ?>" class="main-btn gallery-btn"><i class="fa-solid fa-image"></i> View All Photos </a>
            </div>
            <div class="col-9 md-12 sm-12">
                <div class="row rev">
                        <?php $i=1;?>
                  <?php $__currentLoopData = App\Models\Gallery::orderBy("id","desc")->limit(6)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($i==1 || $i==4 || $i==5): ?>
                         <div class="col-7">
                     <?php else: ?>
                         <div class="col-5">
                     <?php endif; ?>
                           <div class="img">
                              <a href="#" data-href="<?php echo e(asset($c->image)); ?>" data-fancybox="images">
                                 <img src="<?php echo e(asset($c->image)); ?>" class="img-fluid" alt="">
                              </a>
                           </div>
                        </div>
                     <?php $i++;?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
  </div>
</section>
  
<!-- cta -->
<section class="business d-none" style="background-image:url(<?php echo e(asset($data->strip_image)); ?>)">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="box">
         
               <h2><?php echo $data->strip_title; ?></h2>
               <p><?php echo e($data->strip_desction); ?></p>
               <a  href="#" data-href="<?php echo e(url('contact-us')); ?>" class="main-btn ">Let's Connect <i class="fa-solid fa-arrow-right"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>


<?php
$list=App\Models\Attraction::orderBy("id","desc")->take(3)->get();
?>
<?php if(count($list)>0): ?>     
<section class="home-list">
   <div class="container">
<div class="head-sec">
			<h2>Attractions</h2>
		</div>
      <div class="row">
         <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-lg-4 col-md-6 col-sm-12 prop-card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1500">
            <div class="pro-img">                           
             <a href="<?php echo e(url('attractions/detail/'.$c->seo_url)); ?>"><img src="<?php echo e(asset($c->image)); ?>" class="img-fluid" alt="<?php echo e($c->name); ?>"></a>           
            </div>
            <div class="pro-cont ">
               <h3 class="title"><a href="<?php echo e(url('attractions/detail/'.$c->seo_url)); ?>"><?php echo e($c->title ?? $c->name); ?></a></h3>
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="attr-btn"><a href="<?php echo e(url('attractions')); ?>" class="main-btn">View More</a>         </div>
   </div>
</section>
<?php endif; ?>

<!-- about end -->


<?php
 $reviews = App\Models\HostAway\HostAwayReview::where(["type"=>"guest-to-host","status"=>"published"])->where("rating",">=",5)->whereNotNull("publicReview")->orderBy("arrivalDate","desc")->get();
?>
<?php if(count($reviews)>0): ?>
<!--Testimonial section-->
<section class="testimonial ">
    <div class="container">
        <div class="head-sec">
            <h2>What Our Guests Have to Say</h2>
        </div>
        <div class="testy">
            <div class="owl-carousel" id="test-slider">
                <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <div class="item">
                            <div class="test-card">
                                <div class="top-text">
                                	<div class="icon">
                                        <img src="<?php echo e(asset('front')); ?>/images/left.png" class="img-fluid" alt="User">
                                    </div>
                                </div>
                                <div class="cont-sec">
                                    <div class="para">
                                        <p><?php echo e($c->publicReview ?? ''); ?></p>
                                    </div>
                                    <h3><?php echo e(Helper::getReviewName($c->guestName) ?? ''); ?></h3>
                                    <div class="rating">
                                        <span class="rating-count">
                                        <i class="fa-solid fa-star checked"></i>
                                        <i class="fa-solid fa-star checked"></i>
                                        <i class="fa-solid fa-star checked"></i>
                                        <i class="fa-solid fa-star checked"></i>
                                        <i class="fa-solid fa-star checked"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>




<!-- Owner Section Start -->


<section class="about-owner">
    <div class="container px-0 lg-px-2">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 img" ">
                <div class="abt-owner">
                   <?php if($data->owner_image): ?> <div class="abt-img mb-2"><img src="<?php echo e(asset($data->owner_image)); ?>" class="img-fluid" alt=""></div><?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 cont" >
            	<div class="own-content">
                    <h2>Hosts</h2>

                  <?php echo $data->longDescription; ?>

               </div>
                <div class="abt-detail d-flex flex-wrap">
                    <div class="call-us">
                        <div class="icon-area">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="call-area">
                            Phone:
                            <a  href="tel:<?php echo $setting_data['mobile'] ?? '#'; ?>"><?php echo $setting_data['mobile'] ?? '#'; ?></a>
                        </div>
                    </div>
                    <div class="email-us">
                        <div class="icon-area">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="call-area">
                            Email:
                            <a  href="mailto:<?php echo $setting_data['email'] ?? '#'; ?>"><?php echo $setting_data['email'] ?? '#'; ?></a>
                        </div>
                    </div>
                </div>
               <div class="abt-btn"><a href="<?php echo e(url('about-owner')); ?>" class="main-btn">View More</a>         </div>
            </div>
        </div>
    </div>
</section>

 <section class="Blog-sec">

        <div class="container">
 <div class="head-sec">
            <h2>Latest Blogs</h2>
        </div>
            <div class="row">


          
  <?php $__empty_1 = true; $__currentLoopData = App\Models\Blogs\Blog::orderBy('id')->limit(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-4 col-md-4 col-12">
                                <?php $date=$b->publish_date; if($date){}else{$date=$b->created_at;} ?>
                    <div class="blog">

                            <?php if($b->featureImage): ?>
                            <a href="<?php echo e(url('blog/'.$b->seo_url)); ?>/"><img src="<?php echo e(asset($b->featureImage)); ?>" alt="<?php echo e($b->title); ?>" class="img-fluid"  /></a>
                                  <?php endif; ?>
                            <div class="content-blog">
                            <h3><a href="<?php echo e(url('blog/'.$b->seo_url)); ?>/"><?php echo e($b->title); ?></a></h3>
                            <p><?php echo e(Str::limit($b->shortDescription,100)); ?></p>
                            <a href="<?php echo e(url('blog/'.$b->seo_url)); ?>/" class="main-btn mt-4">Read More</a>
                            </div>


                    </div>
                </div>
            
       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

         <?php endif; ?>

      </div>      




        </div>

    </section>
<!-- Owner Section End -->


<!-- form -->

<section class="booking_form">
    <div class="container">
        <div class="head-sec">
            <h2>Booking Enquiry</h2>
        </div>
        <div class="row">
                 <div class="col-lg-7 col-md-7 col-12 contact-form">
                    <div class="inner-container" >
                        <div class="sec-title">
                            <!-- <h3>Send us a message</h3> -->
                            
                        </div>
                        <div class="contact-form">
                            <?php echo Form::open(["route"=>"booking-contact-enquiry-post"]); ?>

                                <div class="row clearfix">
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label>Full Name</label>
                                        <input type="text" name="name" id="form_fname" placeholder="Full name" value="" required="">
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
                                   <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label>Preferred Property</label>
                                  <?php echo Form::select("property_id",ModelHelper::getHostAwayPropertySelect(),null,["class"=>"form-control","required","placeholder"=>"Choose Property","id"=>"property-selector"]); ?>

                                    </div> 

                                        <div class="form-group col-lg-6 col-sm-12">
                                        <label> Check in Date</label>
                                        <?php echo Form::text("start_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtFrom","placeholder"=>"Check in","class"=>"form-control"]); ?>

                                    </div>

                                       <div class="form-group col-lg-6 col-sm-12">
                                        <label> Check out Date</label>
                                        <?php echo Form::text("end_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtTo","placeholder"=>"Check Out","class"=>"form-control lst" ]); ?>

                                    </div>

                                        <div class="form-group col-lg-6 col-sm-12">
                                        <label>Number of Guests (adults/children)</label>
                                        <input type="number" name="guests" id="guest" placeholder="Number of guest (adults/children)" value="" required="">
                                    </div>
                                  
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>How did you hear about us?</label>
                                        <?php echo Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"","placeholder"=>"--Select--"]); ?>

                                    </div> 
                              
                               
                                     <?php if($setting_data['g_captcha_enabled']): ?>
                                        <?php if($setting_data['g_captcha_enabled']=="yes"): ?>
                                            <?php if($setting_data['google_captcha_site_key']!="" && $setting_data['google_captcha_secret_key']!=""): ?>
                							<script src="https://www.google.com/recaptcha/api.js" async defer></script>
                							<div class="form-group col-lg-12 col-md-12 col-sm-12">
                							    <div class="g-recaptcha" data-sitekey="<?php echo e($setting_data['google_captcha_site_key']); ?>"></div>
                							 </div>  
                							 <?php endif; ?>
        							    <?php endif; ?>
        							 <?php endif; ?>
                                    <div class=" col-lg-12 col-md-12 col-sm-12">
                                        <button type="submit" name="submit" class="main-btn"><span>Send Message</span></button>
                                    </div>
                                </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                 </div>
            </div>
        </div>
</section>
<?php if($data->description): ?>
<section class="instagram-section">
  <div class="head-sec">
      <h2>instagram</h2>
  </div>
  <div class="container-fluid">
  <?php echo $data->description; ?>

  </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('datepicker')); ?>/dist/css/hotel-datepicker.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/home.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/home-responsive.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection("js"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
/**document.addEventListener("DOMContentLoaded", function () {
        let checkIn = flatpickr("#txtFrom", {
            dateFormat: "d-m-Y",
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                // Automatically clear check-out if it is before check-in
                let checkoutInput = document.getElementById("txtTo");
                if (checkoutInput.value) {
                    let checkOutDate = new Date(checkoutInput.value);
                    if (checkOutDate <= selectedDates[0]) {
                        checkoutInput.value = ""; // clear if invalid
                    }
                }
                // Set check-out minDate = selected check-in + 1 day
                checkOut.set("minDate", new Date(selectedDates[0].getTime() + 86400000));
            }
        });

        let checkOut = flatpickr("#txtTo", {
            dateFormat: "d-m-Y",
            minDate: "today"
        });
    });  */
  
   $(document).ready(function() {
      $(".gst1").click(function() {
         $("#guestsss1").css("display", "block");
      });
      $(".close12").click(function() {
         $("#guestsss1").css("display", "none");
      });
      $(".close1112").click(function() {
         $("#guestsss1").css("display", "none");
      });
   });
   
   function functiondec($getter_setter, $show, $cal) {
      val = parseInt($($getter_setter).val());
      if (val > 0) {
         val = val - 1;
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
   }
   
   function functioninc($getter_setter, $show, $cal) {
      val = parseInt($($getter_setter).val());
      val = val + 1;
      $($getter_setter).val(val);
      person1 = val;
      person2 = parseInt($($cal).val());
      $show_data = person1 + person2;
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
   }
   
   function functiondec1($getter_setter, $show, $cal) {
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
      if ($getter_setter == "#adults-data1") {
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
   }
   
   function functioninc1($getter_setter, $show, $cal) {
      val = parseInt($($getter_setter).val());
      val = val + 1;
      $($getter_setter).val(val);
      person1 = val;
      person2 = parseInt($($cal).val());
      $show_data = person1 + person2;
      $show_actual_data = $show_data + " Guests";
      $($show).val($show_actual_data);
      if ($getter_setter == "#adults-data1") {
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
   }
</script>
<script src="<?php echo e(asset('datepicker')); ?>/node_modules/fecha/dist/fecha.min.js"></script>
<script src="<?php echo e(asset('datepicker')); ?>/dist/js/hotel-datepicker.js"></script>
<script>
   <?php
         $new_data_blocked = LiveCart::iCalDataCheckInCheckOutCheckinCheckout(0);
         $checkin = json_encode($new_data_blocked['checkin']);
         $checkout = json_encode($new_data_blocked['checkout']);
         $blocked = json_encode($new_data_blocked['blocked']);
   ?>
   var checkin = <?php echo $checkin;  ?>;
   var checkout = <?php echo ($checkout);  ?>;
   var blocked = <?php echo ($blocked);  ?>;
   function clearDataForm() {
      $("#start_date").val('');
      $("#end_date").val('');
   }
   (function() {
      <?php if(Request::get("start_date")): ?>
      <?php if(Request::get("end_date")): ?>
      $("#demo17").val("<?php echo e(request()->start_date); ?> - <?php echo e(request()->end_date); ?>");
      <?php endif; ?>
      <?php endif; ?>
      abc = document.getElementById("demo17");
      var demo17 = new HotelDatepicker(
         abc, {
            <?php if($checkin): ?>
                noCheckInDates: checkin,
            <?php endif; ?>
            <?php if($checkout): ?>
                noCheckOutDates: checkout,
            <?php endif; ?>
            <?php if($blocked): ?>
                disabledDates: blocked,
            <?php endif; ?>
            onDayClick: function() {

                  d = new Date();
                  d.setTime(demo17.start);
                  document.getElementById("start_date").value = getDateData(d);
                  d = new Date();
                  //console.log(demo17.end)
                  if (Number.isNaN(demo17.end)) {
                      document.getElementById("end_date").value = '';
                  } else {
                      d.setTime(demo17.end);
                      document.getElementById("end_date").value = getDateData(d);
                  }
                  var startDate = new Date(demo17.start);
                  var endDate = new Date(demo17.end);

                  var startDay = startDate.getDate();
                  if(startDay){
                      $('#chooesen_start_date').text(startDay);
                  }
                  var startMonth = startDate.toLocaleString('default', { month: 'short' });
                  if(startMonth){
                      $('#chooesen_start_month').text(startMonth);
                  }
                  var endDay = endDate.getDate();
                  if(endDay){
                      $('#chooesen_end_date').text(endDay);
                  }
                  var endMonth = endDate.toLocaleString('default', { month: 'short' });
                  if(endMonth){
                      $('#chooesen_end_month').text(endMonth);
                  }
            },
            clearButton: function() {return true;}
         }
      );
      <?php if(Request::get("start_date")): ?>
            <?php if(Request::get("end_date")): ?>
                setTimeout(function() {$("#demo17").val("<?php echo e(request()->start_date); ?> - <?php echo e(request()->end_date); ?>")document.getElementById("start_date").value = "<?php echo e(request()->start_date); ?>";document.getElementById("end_date").value = "<?php echo e(request()->end_date); ?>";}, 1000);
            <?php endif; ?>
      <?php endif; ?>
   })();
   
   $(document).on("click", "#clear", function() {$("#clear-demo17").click();});
   x = document.getElementById("month-2-demo17");
   x.querySelector(".datepicker__month-button--next").addEventListener("click", function() {y = document.getElementById("month-1-demo17");y.querySelector(".datepicker__month-button--next").click();});
   x = document.getElementById("month-1-demo17");
   x.querySelector(".datepicker__month-button--prev").addEventListener("click", function() {y = document.getElementById("month-2-demo17");y.querySelector(".datepicker__month-button--prev").click();});
   function getDateData(objectDate) { let day = objectDate.getDate(); let month = objectDate.getMonth() + 1; let year = objectDate.getFullYear(); if (day < 10) {day = '0' + day;} if (month < 10) {month = `0${month}`;} format1 = `${year}-${month}-${day}`; return format1; }
   $(document).on("click", ".view-more", function() {
      that = $(this);
      that.parents(".parent-class").find(".view-more").css({
         "display": "none"
      });
      that.parents(".parent-class").find(".view-less").css({
         "display": "block"
      });
      that.parents(".parent-class").find(".readMore_review").css({
         "height": "auto"
      });
   });
   $(document).on("click", ".view-less", function() {
      that = $(this);
      that.parents(".parent-class").find(".view-more").css({
         "display": "block"
      });
      that.parents(".parent-class").find(".view-less").css({
         "display": "none"
      });
      that.parents(".parent-class").find(".readMore_review").css({
         "height": "78px"
      });
   });
   $(document).ready(function() {
      $(".readMore_review").each(function() {
         var a = $(this).height();
         if (a < 78) {
            $(this).parents(".parent-class").find(".view-more").css("display", "none");
         } else {
            $(this).parents(".parent-class").find(".view-more").css("display", "block");
            $(this).css("height", "78px");
         }
      });
      var a = $(".readMore_review").height();
   });
   $('#more-slider').owlCarousel({
      loop: true,
      items: 2,
      margin: 15,
      autoplay: false,
      dots: false,
      nav: true,
      loop: true,
      autoplayTimeout: 4000,
      smartSpeed: 550,
      navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      responsive: {0: {items: 1},768: {items: 2},1170: {items: 2}}
   });
   $('.pro-img-slider').owlCarousel({
      loop: true,
      items: 1,
      margin: 0,
      autoplay: false,
      dots: false,
      nav: true,
      loop: true,
      autoplayTimeout: 4000,
      smartSpeed: 550,
      navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      responsive: {0: {items: 1},768: {items: 1},1170: {items: 1}}
   });

</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
 <script>
   var checkin = '';
    var checkout = '';
     $(document).on("change","#property-selector",function(){
        data={_token:"<?php echo e(csrf_token()); ?>",id:$(this).val()};
        url="<?php echo e(route('get-checkin-checkout-data-new')); ?>";
        $.post(url,data,function(data){
           console.log(data); 
              checkin = data.checkin;
             checkout = data.checkout;
            
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
        
                        return [checkout.indexOf(string) == -1]
        
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
     });
     
     
    function ajaxCallingData(){
        //alert('hello');
        pet_fee_data_guarav=$("#pet_data").val();
        adults=$("#adult_data").val();
        childs=$("#child_data").val();
        if($("#property-selector").val()!=""){
             if($("#txtFrom").val()!=""){
                 if($("#txtTo").val()!=""){
                    if($("#adult_data").val()>0){
                         $.post("<?php echo e(route('admin-checkajax-get-quote')); ?>",{start_date:$("#txtFrom").val(),end_date:$("#txtTo").val(),pet_fee_data_guarav:pet_fee_data_guarav,adults:adults,childs:childs,book_sub:true,property_id:$("#property-selector").val(),extra_discount:$("#extra-discount").val()},function(data){
                            if(data.status==400){
                                $("#submit-button-gaurav-data").hide();
                                toastr.error(data.message);
                            }else{
                               $("#pricedata-gaurav").html(data.data_view);
                            }
                        });
                    }
                 }
             }  
        }
    }
    $(document).on("change","#adult_data,#child_data,#pet_data",function(){
        ajaxCallingData();
    });
    
    $(document).on("keyup","#extra-discount",function(){
        ajaxCallingData();
    })
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/front/static/home.blade.php ENDPATH**/ ?>