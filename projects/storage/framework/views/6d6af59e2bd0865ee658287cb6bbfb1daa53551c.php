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
	<a href="#check" class="sticky main-btn book1 check">
		<span class="button-text">CHECK AVAILABILITY</span>
	</a>
	<div class="search-info" id="check">
		<div class="container">
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
		</div>
<?php
$total_sleep=0;
$bedroom=0;
$ids=[];
     if(Request::get("Guests")){
        
        if(Request::get("adults")!=""){
            if(is_int((int)Request::get("adults"))){
                $total_sleep+=Request::get("adults");
            }
        }
        if(Request::get("child")!=""){
            if(is_int((int)Request::get("child"))){
                $total_sleep+=Request::get("child");
            }
        }
    }
    
    if(Request::get("start_date")){
        if(Request::get("end_date")){
            $new_data=(HostAwayAPI::getSearchPropertiesList(Request::get("start_date"),Request::get("end_date"),$total_sleep));
            if($new_data['status']=="200"){
                $ids=$new_data['data'];
            }
        }
    }
    
    $list=App\Models\HostAway\HostAwayProperty::query();

    if(count($ids)>0){
        $list->whereIn("host_away_id",$ids);
    }
    
    if(Request::get("bedroom")){
        if(is_int((int)Request::get("bedroom"))){
            $list->where("bedroomsNumber", Request::get("bedroom"));
        }
    }
    
    if(Request::get("location_id")){
        $list->where("location_id",Request::get("location_id"));
    }
    $yes_is_pet='';
    $no_is_pet='';
    $list=$list->orderBy("id","desc")->paginate(100);
?>

<section class="properties-list">
   <div class="container">
      <div class="owl-carousel1 property-list-slider1 row" id="list-slider1">
      	<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="item col-md-6 col-12">
            <div class="property-list">
               <div class="list-image">
               	    <?php
        			    $images=[];
        			    foreach(json_decode($c->listingImages,true) as $c1){
        			        $images[$c1['sortOrder']]=$c1;
        			    }
        			?>
        			<?php  $i=0; ?>
					<?php if($c->feature_image): ?>
    					<?php $image=$c->feature_image;?>
    				<?php else: ?>
    					<?php if($c->listingImages): ?>
        					<?php $io=0; ?>
        					<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            					<?php if($i==0): ?>
            					    <?php $image=$c1['url']; break;?>
            					<?php else: ?>
            					<?php endif; ?>
            					<?php $i++;?>
        					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    					<?php endif; ?>
    				<?php endif; ?>
					<?php if($image): ?>
                 <div class="owl-carousel pro-img-slider">
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
                  <?php endif; ?>
               </div>
               <div class="list-content">
                  <h3><a href="<?php echo e(url($c->seo_url)); ?>"><?php echo e($c->name); ?></a></h3>
                  <p><?php echo e($c->city); ?>, <?php echo e($c->state); ?></p>
                  <ul class="list-amenity">
                     <li><i class="fa-solid fa-user-group"></i> <span><?php echo e($c->personCapacity); ?> Guests</span></li>
                     <li><i class="fa-solid fa-bed"></i> <span><?php echo e($c->bedroomsNumber); ?> Bedrooms</span></li>
                     <li><i class="fa-solid fa-shower"></i> <span><?php echo e($c->bathroomsNumber); ?> Baths</span></li>
                  </ul>
                  <div class="list-btn">
                  	<?php
                  	$price=$c->price;
                  	$ar1=App\Models\HostAway\HostAwayDate::where("single_date",date('Y-m-d'))->where("hostaway_id",$c->host_away_id)->first();
                  if($ar1){
                  	$price=$ar1->price;
                  }
                  ?>
					<?php if($price): ?>
                     <div class="price">
                        <p>From <?php echo e($payment_currency); ?> <?php echo e($price); ?> / Night </p>
                     </div>
                     <?php endif; ?>
                     <div class="pro-btn">
                        <a href="<?php echo e(url($c->seo_url).'?'.http_build_query(request()->all())); ?>" class="main-btn">BOOK NOW</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
      </div>
   </div>
</section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('datepicker')); ?>/dist/css/hotel-datepicker.css"/>
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/porperty-list.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/porperty-list-responsive.css" />
<?php $__env->stopSection(); ?> 
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="<?php echo e(asset('front')); ?>/js/properties-list.js" ></script>
<script>

$(document).ready(function(){
    $(".gst1").click(function(){
        $("#guestsss1").css("display", "block");
    });
    $(".close12").click(function(){
        $("#guestsss1").css("display", "none");
    });
    $(".close1112").click(function(){
        $("#guestsss1").css("display", "none");
    });
});
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
	}
	
	function functiondec1($getter_setter,$show,$cal){
	    val=parseInt($($getter_setter).val());
	     if($getter_setter=="#adults-data1"){
            if(val>1){
                val=val-1;
            }else{
                val=1;
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
	    if($getter_setter=="#adults-data1"){
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
	}
	
	function functioninc1($getter_setter,$show,$cal){
	    val=parseInt($($getter_setter).val());
	    val=val+1;
	    $($getter_setter).val(val);
	    person1=val;
	    person2=parseInt($($cal).val());
	    $show_data=person1+person2;
	    $show_actual_data=$show_data+" Guests";
	    $($show).val($show_actual_data);
	    if($getter_setter=="#adults-data1"){
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
	}
</script>
<script src="<?php echo e(asset('datepicker')); ?>/node_modules/fecha/dist/fecha.min.js"></script>
<script src="<?php echo e(asset('datepicker')); ?>/dist/js/hotel-datepicker.js"></script>
<script>
	<?php
	    $new_data_blocked=LiveCart::iCalDataCheckInCheckOutCheckinCheckout(0);
	    $checkin=json_encode($new_data_blocked['checkin']);
	    $checkout=json_encode($new_data_blocked['checkout']);
	    $blocked=json_encode($new_data_blocked['blocked']);
	?>
	    var checkin = <?php echo $checkin;  ?>;
	    var checkout = <?php echo ($checkout);  ?>;
	    var blocked= <?php echo ($blocked);  ?>;
	    function clearDataForm(){
	        $("#start_date").val('');
	        $("#end_date").val('');
	    }
        (function () {
            <?php if(Request::get("start_date")): ?>
                <?php if(Request::get("end_date")): ?>
                    $("#demo17").val("<?php echo e(request()->start_date); ?> - <?php echo e(request()->end_date); ?>");     
                <?php endif; ?>
            <?php endif; ?>
            abc=document.getElementById("demo17");
            var demo17 = new HotelDatepicker(
                abc,
                {
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
                        if(Number.isNaN(demo17.end)){
                            document.getElementById("end_date").value = '';
                        }else{
                            d.setTime(demo17.end);
                            document.getElementById("end_date").value = getDateData(d);
                        }
                    },
                    clearButton:function(){return true;}
                }
            );
	                
            <?php if(Request::get("start_date")): ?>
                <?php if(Request::get("end_date")): ?>
                    setTimeout(function(){$("#demo17").val("<?php echo e(request()->start_date); ?> - <?php echo e(request()->end_date); ?>");document.getElementById("start_date").value ="<?php echo e(request()->start_date); ?>";document.getElementById("end_date").value ="<?php echo e(request()->end_date); ?>";},1000);
                <?php endif; ?>
            <?php endif; ?>
	    })();
	
        $(document).on("click","#clear",function(){$("#clear-demo17").click();});
        x=document.getElementById("month-2-demo17");
        x.querySelector(".datepicker__month-button--next").addEventListener("click", function(){y=document.getElementById("month-1-demo17");y.querySelector(".datepicker__month-button--next").click();})  ;
        x=document.getElementById("month-1-demo17");
        x.querySelector(".datepicker__month-button--prev").addEventListener("click", function(){y=document.getElementById("month-2-demo17");y.querySelector(".datepicker__month-button--prev").click();})  ;
        function getDateData(objectDate){let day = objectDate.getDate();let month = objectDate.getMonth()+1;let year = objectDate.getFullYear();if (day < 10) {day = '0' + day;}if (month < 10) {month = `0${month}`;}format1 = `${year}-${month}-${day}`;return  format1 ;}  
</script>
<script>
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
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-asif/htdocs/asif.webdesignvrvr.com/projects/resources/views/front/static/property-list.blade.php ENDPATH**/ ?>