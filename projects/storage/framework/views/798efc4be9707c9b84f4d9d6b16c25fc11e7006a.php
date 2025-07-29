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
      <!-- <video src="<?php echo asset($setting_data['home_video']); ?>" loop="" muted="" autoplay="" playsinline="" class="js-hero-slide__inner" id="mob"></video> -->
      <img src="<?php echo e(asset('front')); ?>/images/home-banner.webp" alt="">
      <!-- <button onclick="playVideo()" id="play"><i class="fa-solid fa-play"></i></button>
         <button onclick="pauseVideo()" id="pause"><i class="fa-solid fa-pause"></i></button> -->
      <div class="overlay">
         <div class="hero-content aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1500">
            <div class="container">
               <?php echo $setting_data['home-video-text']; ?>

            </div>
         </div>
      </div>
   </div>
   <div class="container booking-area">
      <div class="search-bar">
         <form method="get" action="<?php echo e(url('properties')); ?>">
            <div class="row">
               <div class="col-3 md-12 sm-12 select d-none">
                  <?php echo Form::select("location_id",ModelHelper::getLocationSelectList(),null,["class"=>"","placeholder"=>"Select Location","title"=>"Select Location","id"=>"loc"]); ?>

                  <i class="fa-solid fa-location-dot"></i>
               </div>
               <div class="col-6 col-lg md-8 icns mb-lg-0 position-relative  datepicker-section datepicker-common-2 main-check">
                  <div class="row">
                     <div class="check left icns mb-lg-0 position-relative datepicker-common-2">
                        <?php echo Form::text("start_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"start_date","placeholder"=>"Check in","class"=>"form-control"]); ?>

                        <i class="fa-solid fa-calendar-days"></i>
                     </div>
                     <div class="check right icns mb-lg-0 position-relative datepicker-common-2">
                        <?php echo Form::text("end_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"end_date","placeholder"=>"Check Out","class"=>"form-control lst" ]); ?>

                        <i class="fa-solid fa-calendar-days"></i>
                     </div>
                     <div class="col-12 md-12 sm-12 datepicker-common-2 datepicker-main">
                        <input type="text" id="demo17" value="" aria-label="Check-in and check-out dates" aria-describedby="demo17-input-description" readonly />
                     </div>
                  </div>
               </div>
               <div class="col-3 md-12 sm-12 guest">
                  <input type="text" name="Guests" readonly="" class="form-control gst1" id="show-target-data1" placeholder="Add guests" title="Select Guests">
                  <i class="fa-solid fa-users "></i>
                  <input type="hidden" value="0" name="adults" id="adults-data1" />
                  <input type="hidden" value="0" name="child" id="child-data1" />
                  <div class="adult-popup" id="guestsss1">
                     <i class="fa fa-times close12"></i>
                     <div class="adult-box">
                        <p id="adults-data1-show"><span>Adult</span> 18+</p>
                        <div class="adult-btn">
                           <button class="button1" type="button" onclick="functiondec1('#adults-data1','#show-target-data1','#child-data1')" value="Decrement Value">-</button>
                           <button class="button11 button1" type="button" onclick="functioninc1('#adults-data1','#show-target-data1','#child-data1')" value="Increment Value">+</button>
                        </div>
                     </div>
                     <div class="adult-box">
                        <p id="child-data1-show"><span>Children</span> (0-17)</p>
                        <div class="adult-btn">
                           <button class="button1" type="button" onclick="functiondec1('#child-data1','#show-target-data1','#adults-data1')" value="Decrement Value">-</button>
                           <button class="button11 button1" type="button" onclick="functioninc1('#child-data1','#show-target-data1','#adults-data1')" value="Increment Value">+</button>
                        </div>
                     </div>
                     <button class="main-btn  close1112" type="button" onclick="">Apply</button>
                  </div>
               </div>
               <div class="col-3 md-12 sm-12 srch-btn">
                  <button type="submit" class="main-btn ">Check Availability</button>
               </div>
            </div>
         </form>
      </div>
   </div>
 
   <div class="images-sec">
         <img src="front/images/banner_logo_1.png" title="Home" alt="Home" class="banner_img_1">  
         <img src="front/images/banner_logo_2.png" title="Home" alt="Home" class="banner_img_2">
  
        </div>
        <div class="view-all-property">
           <a href="<?php echo e(url('properties')); ?>" class="">View All Properties</a>
        </div>
</section>

<section class="about-us">
   <div class="container">
      <div class="row">
         <div class="col-6 about-content-sec">
            <div class="abt-content">
               <p class="head">About</p>
               <div class="abt-para">
                  <?php echo $data->longDescription; ?>

               </div>
               <div class="abt-btn d-none">
                  <a href="<?php echo e(url('about-us')); ?>" class="main-btn">Read More</a>
               </div>
            </div>
         </div>
         <div class="col-6 about-image-sec">
            <div class="abt-image">
               <div class="abt-img1 aos-init aos-animate" data-aos="fade-down" data-aos-duration="1000">
                  <img src="<?php echo e(asset($data->about_image1)); ?>" title="Home" alt="Home">
               </div>
               <div class="abt-img2 aos-init" data-aos="fade-up" data-aos-duration="1000">
                  <img src="<?php echo e(asset($data->about_image2)); ?>" title="Home" alt="Home">
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- property -->
<section class="properties-list">
   <div class="container">
      <div class="head-sec">
         <h2>Vacation Rentals</h2>
      </div>
      <div class="owl-carousel1 property-list-slider1 row" id="list-slider1">
         <?php
         $list=App\Models\HostAway\HostAwayProperty::where("is_home","true")->orderBy("id","desc")->get();
         ?>
         <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
     
         <div class="item col-md-6 col-12">
            <div class="property-list">
               <div class="list-image">
                  <div class="owl-carousel pro-img-slider">
                     <div class="item">
                        <a href="<?php echo e(url($c->seo_url)); ?>" title="<?php echo e($c->name); ?>"><img src="<?php echo e(asset($image)); ?>" alt="Luxury 7BR Villa Vizcaya" title="<?php echo e($c->name); ?>"></a>
                     </div>
                    <?php $io=0; ?>
                     <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($i==6): ?> <?php break; ?> <?php endif; ?>
                        <?php if($i==1 && $io==0): ?>
                             <?php $i++;$io++; ?>
                             <?php continue; ?>
                        <?php endif; ?>
                         <div class="item">
                            <a href="<?php echo e(url($c->seo_url)); ?>" title="<?php echo e($c->name); ?>"><img src="<?php echo e(asset($c1['url'])); ?>" alt="<?php echo e($c1['caption']); ?>"></a>
                         </div>
                         
                        <?php $i++;$io++; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                  </div>
               </div>
               <div class="list-content">
                  <h3><a href="<?php echo e(url($c->seo_url)); ?>"><?php echo e($c->name); ?></a>
                  </h3>
                  <p><?php echo e($c->city); ?>, <?php echo e($c->state); ?></p>
                  <ul class="list-amenity">
                     <li><i class="fa-solid fa-user-group"></i> <span><?php echo e($c->personCapacity); ?> Guests</span>  </li>
                     <li><i class="fa-solid fa-bed"></i> <span><?php echo e($c->bedroomsNumber); ?> Bedrooms</span> </li>
                     <li><i class="fa-solid fa-shower"></i> <span><?php echo e($c->bathroomsNumber); ?> Baths</span> </li>
                  </ul>
                  <div class="list-btn">
                     <?php
                     $price=$c->price;
                     $ar1=App\Models\HostAway\HostAwayDate::where("single_date",date('Y-m-d'))->where("hostaway_id",$c->host_away_id)->first();
                     if($ar1){
                     $price=$ar1->price;
                     }
                     ?>
                     <div class="price">
                        <p>From <?php echo e($payment_currency); ?> <?php echo e($price); ?> / Night </p>
                     </div>
                     <div class="pro-btn">
                        <a href="<?php echo e(url($c->seo_url)); ?>" class="main-btn">BOOK NOW</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="pro_sec_btn">
         <a href="<?php echo e(url('properties')); ?>" class="main-btn">View More</a>
      </div>
   </div>
</section>

<?php $list=App\Models\Service::orderBy("id","desc")->get(); ?>
<?php if(count($list)>0): ?>
<section class="galleries-section">
   <div class="container">
      <div class="head-sec">
         <h2>Discover the Elegance of Naples</h2>
      </div>
      <div class="row">
         <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-4 gallery-details">
            <div class="activites-image">
               <a href="#">
                  <?php if($c->image): ?>
                  <img src="<?php echo e(asset($c->image)); ?>" alt="<?php echo e($c->name); ?>">
                  <?php endif; ?>
                  <div class="overlay-content">
                     <?php echo $c->longDescription; ?>

                  </div>
               </a>
            </div>
            <h4><a href="#"><?php echo e($c->name); ?></a></h4>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
</section>
<?php endif; ?>

<?php if(App\Models\Testimonial::where("status","true")->count()>0): ?>
<!--Testimonial section-->
<section class="testimonial" style="background-image:url('<?php echo e(asset($data->strip_image)); ?>');">
   <div class="container">
      <div class="main-row">
         <div class="head-sec">
            <div class="line"></div>
            <h2>What Our Guests Have to Say</h2>
         </div>
         <div class="testy">
            <div class="owl-carousel" id="test-slider">
               <?php $__currentLoopData = App\Models\Testimonial::where("status","true")->orderBy("stay_date","desc")->take(6)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="item">
                  <div class="test-card">
                     <div class="cont-sec">
                        <div class="para">
                           <p><?php echo e($c->message); ?></p>
                        </div>
                        <div class="user-review">
                           <?php if($c->image): ?>
                           <img src="<?php echo e(asset($c->image)); ?>" alt="">
                           <?php else: ?>
                           <img src="<?php echo e(asset('front')); ?>/images/users.png" alt="">
                           <?php endif; ?>
                           <div class="people">
                              <h3><?php echo e($c->name); ?></h3>
                              <p class="indentity">Stayed <?php echo e(date('F Y',strtotime($c->stay_date))); ?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>

<?php
$list=App\Models\Attraction::orderBy("id","desc")->paginate(6);
?>
<?php if(count($list)>0): ?>
<!-- start attractions -->
<section class="attractions_wrapper">
   <div class="container">
      <div class="row ">
         <div class="section-title">
            <div class="line"></div>
            <h2> Attractions</h2>
         </div>
      </div>
      <div class="row attractions-item-wrap">
         <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-lg-4 col-md-4 col-12">
            <div class="attractions_left">
               <div class="attr_img mdl">
                  <a  <?php if($c->type=="internal"): ?> href="<?php echo e(url('attractions/detail/'.$c->seo_url)); ?>"  <?php else: ?> href="<?php echo e($c->seo_url); ?>" target="_BLANK"    <?php endif; ?> >
                  <img src="<?php echo e(asset($c->image)); ?>" alt="<?php echo e($c->name); ?>" class="img-fluid" />
                  <div class="attr-over">
                     <h4><?php echo e($c->name); ?></h4>
                     <p><?php echo e($c->description); ?></p>
                  </div>
                  </a>
               </div>
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <div class="text-center">
            <a href="<?php echo e(url('attractions')); ?>" class="main-btn mt-4">View More</a>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>
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
   				console.log(demo17.end)
   				if (Number.isNaN(demo17.end)) {
   					document.getElementById("end_date").value = '';
   				} else {
   					d.setTime(demo17.end);
   					document.getElementById("end_date").value = getDateData(d);
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
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-asif/htdocs/asif.webdesignvrvr.com/projects/resources/views/front/static/home.blade.php ENDPATH**/ ?>