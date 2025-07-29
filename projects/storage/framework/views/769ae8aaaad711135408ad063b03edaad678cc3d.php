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

<?php
$payment_currency=$setting_data['payment_currency'];
$name=$data->name;
$bannerImage=asset('front/images/internal-banner.webp');
if($data->bannerImage){
$bannerImage=asset($data->bannerImage);
}
?>
<section class="page-title" style="background-image: url(<?php echo e($bannerImage); ?>);">
	<div class="auto-container">
		<h1 data-aos="zoom-in" data-aos-duration="1500" class="aos-init aos-animate"><?php echo e($name); ?></h1>
		<div class="checklist">
			<p>
				<a href="<?php echo e(url('/')); ?>" class="text"><span>Home</span></a>
				<a class="g-transparent-a"><?php echo e($name); ?></a>
			</p>
		</div>
	</div>
</section>
<a href="#p-list" class="sticky main-btn book1 check">
	<span class="button-text">CHECK AVAILABILITY</span>
</a>
<?php
$total_sleep=0;
$ids=[];
if(Request::get("Guests")){

    $number = explode(' ', Request::get("Guests"))[0];
    $total_sleep+= (int)($number);
}

$list=App\Models\HostAway\HostAwayProperty::query();
$list->where(["is_active"=>"true","status"=>"true"]);

if(Request::get("start_date")){
    if(Request::get("end_date")){
        $new_data=(HostAwayAPI::getSearchPropertiesList(Request::get("start_date"),Request::get("end_date"),$total_sleep));
        if($new_data['status']=="200"){
            $ids=$new_data['data'];
            $list->whereIn("host_away_id",$ids);
        }
    }
}

if(Request::get("location_id")){
    $list->where("location_id",Request::get("location_id"));
}
if(Request::get("pet")){
    $list->where("is_pet",Request::get("pet"));
}

$yes_is_pet='';
$no_is_pet='';
$list=$list->orderBy("id","desc")->paginate(100);
?>
<div class="search-sec" data-aos="fade-up">
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
              
                    <a href="<?php echo e(url($c->seo_url).'?'.http_build_query(request()->all())); ?>"><img src="<?php echo e(asset($image)); ?>" class="img-fluid" alt="<?php echo e($c->name); ?>"></a>
           
            </div>
            <div class="pro-cont ">
               <h3 class="title"><a href="<?php echo e(url($c->seo_url).'?'.http_build_query(request()->all())); ?>"><?php echo e($c->title ?? $c->name); ?></a></h3>
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
						<h5><span><?php echo e($payment_currency); ?> <?php echo e($price); ?>

							</span> / Night
						</h5>
					</div>
						<a href="<?php echo e(url($c->seo_url).'?'.http_build_query(request()->all())); ?>" class="main-btn">Book Now</a>
			    </div>
              <?php endif; ?>
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      
   </div>
</section>
<?php else: ?>
<div class="d-flex justify-content-center mt-4">
    <p>Unfortunately, the selected dates are unavailable. Please adjust your search and try again</p>
</div>    
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.2.4/assets/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('datepicker')); ?>/dist/css/hotel-datepicker.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/porperty-list.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/porperty-list-responsive.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script src="<?php echo e(asset('front')); ?>/js/properties-list.js"></script>
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
						// ajaxCallingData();
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
				clearButton: function() {
					return true;
				}
			}
		);

		<?php if(Request::get("start_date")): ?>
            <?php if(Request::get("end_date")): ?>
                setTimeout(function() {
                    $("#demo17").val("<?php echo e(request()->start_date); ?> - <?php echo e(request()->end_date); ?>");
                    document.getElementById("start_date").value = "<?php echo e(request()->start_date); ?>";
                    document.getElementById("end_date").value = "<?php echo e(request()->end_date); ?>";
                    <?php
                         $start_date = strtotime(request()->start_date);
                         $end_date = strtotime(request()->end_date);
                         $start_day = date('d', $start_date); 
                         $start_month = date('M', $start_date);
                         $end_day = date('d', $end_date); 
                         $end_month = date('M', $end_date);
                    ?>
                     $('#chooesen_start_date').text("<?php echo e($start_day); ?>");
                     $('#chooesen_start_month').text("<?php echo e($start_month); ?>");
                     $('#chooesen_end_date').text("<?php echo e($end_day); ?>");
                     $('#chooesen_end_month').text("<?php echo e($end_month); ?>");
                }, 1000);
            <?php endif; ?>
		<?php endif; ?>

	})();

	$(document).on("click", "#clear", function() {
		$("#clear-demo17").click();
	})
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
		//console.log(day); // 23

		let month = objectDate.getMonth() + 1;
		//console.log(month + 1); // 8

		let year = objectDate.getFullYear();
		// console.log(year); // 2022


		if (day < 10) {
			day = '0' + day;
		}

		if (month < 10) {
			month = `0${month}`;
		}
		format1 = `${year}-${month}-${day}`;
		return format1;
		console.log(format1); // 07/23/2022
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com/projects/resources/views/front/static/property-list.blade.php ENDPATH**/ ?>