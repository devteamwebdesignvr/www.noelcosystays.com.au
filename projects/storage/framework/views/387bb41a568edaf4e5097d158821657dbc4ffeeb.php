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
                  <div class="col-4 md-12 sm-12 select d-none">
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
                     <select name="Guests" id="Guests" class="fs-5">
                        <?php for($i=1; $i<= 8; $i++): ?>
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
         $list=App\Models\HostAway\HostAwayProperty::where("is_home","true")->orderBy("id","desc")->get();
         ?>
<?php if(count($list)>0): ?>     
<section class="home-list">
   <div class="container">

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
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      
   </div>
</section>
<?php endif; ?>
<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-3 md-12 sm-12">
                <div class="head-sec">
                    <div id="arrow-overview" class="arrow-mask-wrap arrow-mask-right affix">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 94.33 17.9"><defs><style>.cls-1 {fill: #fff;stroke: #313C2F;stroke-miterlimit: 10;}</style></defs><g id="arrow-right-long" data-name="arrow-right-long-Layer 2"><g id="arrow-right-long-Layer_1-2" data-name="arrow-right-long-Layer 1"><polyline class="cls-1" points="84.59 0.37 93.6 8.57 84.59 17.55"></polyline><line class="cls-1" x1="93.6" y1="8.57" y2="8.57"></line></g></g></svg>
                    </div>
                    <h2>Photo <br>Gallery </h2>
                </div>
                <a href="<?php echo e(url('gallery')); ?>" class="main-btn gallery-btn"><i class="fa-solid fa-image"></i> View All Photos </a>
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
                              <a href="<?php echo e(asset($c->image)); ?>" data-fancybox="images">
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
</section>
  
<!-- cta -->
<section class="business" style="background-image:url(<?php echo e(asset($data->strip_image)); ?>)">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="box">
         
               <h2><?php echo $data->strip_title; ?></h2>
               <p><?php echo e($data->strip_desction); ?></p>
               <a  href="<?php echo e(url('contact-us')); ?>" class="main-btn ">Let's Connect <i class="fa-solid fa-arrow-right"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>
<?php if(App\Models\Category::count()>0): ?>
<section class="collection-section">
	<div class="container">
		<div class="head-sec">
            <h2>Collections</h2>
            <p>Find the type of stay for you</p>		
        </div>
    	<div class="row">
    	    <?php $i=1;?>
    	    <?php $__currentLoopData = App\Models\Category::orderBy("id","desc")->limit(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        	    <?php if($i<=2): ?>
            		<div class="col-lg-6 col-md-6 col-12">
            			<div class="collection-content">
                			<div class="img">
                			    <?php if($c->image): ?>
                				    <a href="<?php echo e(url('properties/category/'.$c->seo_url)); ?>"><img src="<?php echo e(asset($c->image)); ?>" alt=""></a>
                				<?php endif; ?>
                			</div>
                			<h3><a href="<?php echo e(url('properties/category/'.$c->seo_url)); ?>"><?php echo e($c->name); ?></a></h3>
            			</div>
            		</div>
        		<?php else: ?>
            		<div class="col-lg-4 col-md-4 col-12">
            			<div class="collection-content">
            			    <div class="img">
                			    <?php if($c->image): ?>
                				    <a href="<?php echo e(url('properties/category/'.$c->seo_url)); ?>"><img src="<?php echo e(asset($c->image)); ?>" alt=""></a>
                				<?php endif; ?>
                			</div>
                			<h3><a href="<?php echo e(url('properties/category/'.$c->seo_url)); ?>"><?php echo e($c->name); ?></a></h3>
            			</div>
            		</div>
        		<?php endif; ?>
        		<?php $i++; ?>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	</div>
	</div>
</section>
<?php endif; ?>
  
<?php  $faqs = App\Models\Faq::orderBy('id','desc')->take(5)->get();?>
<?php if(count($faqs)>0): ?>
<section class="faq" id="faqs">
   <div class="container">
      <div class="head-sec">
         <h2>Frequently Asked Questions</h2>
      </div>
      <div class="faq-sec">
         <div class="accordion" id="accordionExample">
             <?php $i =1; ?>
             <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <?php if($i == 1): ?>
                    <div class="accordion-item">
                       <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse"     data-bs-target="#collapseOne<?php echo e($c->id); ?>" aria-expanded="true" aria-controls="collapseOne<?php echo e($c->id); ?>"><?php echo $c->question; ?></button></h2>
                       <div id="collapseOne<?php echo e($c->id); ?>" class="accordion-collapse collapse show"
                          data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $c->answer; ?></div>
                       </div>
                    </div>
                 <?php else: ?>
                    <div class="accordion-item">
                       <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"data-bs-target="#collapseTwo<?php echo e($c->id); ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo e($c->id); ?>"><?php echo $c->question; ?></button></h2>
                       <div id="collapseTwo<?php echo e($c->id); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $c->answer; ?></div>
                       </div>
                    </div>
                 <?php endif; ?>
                 <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
         <div class="faq-btn">
            <a href="<?php echo e(url('faqs')); ?>" class="main-btn">View More</a>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>
<!--location cards -->
<section class="how-we-value-wrapp atr">
   <div class="container">
      <div class="head-sec">
         <div class="heading-logo">
            <h2>Explore</h2>
         </div>
      </div>
      <div class="row">
          <?php $__currentLoopData = App\Models\AttractionCategory::orderBy("id","desc")->take(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-lg-4 col-md-6 col-12 atrr">
            <div class="img-card"><a href="<?php echo e(url('attractions/category/'.$c->seo_url)); ?>"><img src="<?php echo e(asset($c->image)); ?>" class="img-fluid" alt=""></a>
               <div class="overlay"></div>
            </div>
            <div class="atr-cont"><a href="<?php echo e(url('attractions/category/'.$c->seo_url)); ?>"><h4><?php echo e($c->name); ?></h4></a></div>
         </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
</section>



<!-- about end -->
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
<script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-rupa/htdocs/rupa.webdesignvrvr.com/projects/resources/views/front/static/home.blade.php ENDPATH**/ ?>