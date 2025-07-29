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
<!-- start about section -->
<?php    $show_data_amount=[];?>
<?php $__currentLoopData = $main_data['data']['components']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($c['isIncludedInTotalPrice']==1): ?>
        <?php if($c['name']=="baseRate"): ?>
            <?php  $base_price=$c['total'];  ?>
        <?php else: ?>
            <?php $show_data_amount[$c['type']]['data'][]=$c; 
                if(isset($show_data_amount[$c['type']]['total'])){
                    $show_data_amount[$c['type']]['total']+=$c['total'];
                }else{
                     $show_data_amount[$c['type']]['total']=$c['total'];
                }
            ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<section class="get-quote">
    <div class="container">
        <div class="row quote-area">
            <div class="col-6 quote-detail">
                <p class="detail-page"><a href="<?php echo e(url($property->seo_url)); ?>"><i class="fa-solid fa-arrow-left"></i><span>Listing page</span></a></p>
                <h2>Confirm and pay</h2>
                <div class="trip">
                    <h4>Trip information</h4>
                    <div class="trip-date">
                        <div class="left date-left">
                            <p class="head">Dates</p>
                            <p><?php echo e(date('F jS, Y',strtotime($start_date))); ?> - <?php echo e(date('F jS, Y',strtotime($end_date))); ?></p>
                        </div>
                        <div class="date-box">
                            <button type="button" class="btn-close"></button>
                            <div class="row date-head">
                                <div class="col-12 left">
                                    <h3><?php echo e(date('F jS, Y',strtotime($start_date))); ?> - <?php echo e(date('F jS, Y',strtotime($end_date))); ?></h3>
                                </div>
                            </div>
                            <form  action="<?php echo e(url('reserve')); ?>" method="get">
                                <div class="date-content">
                                    <?php $__currentLoopData = Request::except(["end_date","start_date"]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field_name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" name="<?php echo e($field_name); ?>" value="<?php echo e($value); ?>" />
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="main-cal">
                                        <div class="ovabrw_datetime_wrapper d-none">
                                            <?php echo Form::text("start_date",Request::get("start_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"start_date","placeholder"=>"Check in"]); ?>

                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <div class="ovabrw_datetime_wrapper d-none">
                                            <?php echo Form::text("end_date",Request::get("end_date"),["required","autocomplete"=>"off","inputmode"=>"none","id"=>"end_date","placeholder"=>"Check Out"]); ?>

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
                            <p><?php echo e($total_guests); ?> Guests   (<?php echo e($adults); ?> Adults , <?php echo e($child); ?> Child) </p>
                        </div>
                        <div class="guest-box">
                            <button type="button" class="btn-close"></button>
                            <form method="get" action="<?php echo e(url('reserve')); ?>">
                                <?php $__currentLoopData = Request::except(["adults","child","Guests"]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field_name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="<?php echo e($field_name); ?>" value="<?php echo e($value); ?>" />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="adults" value="<?php echo e(request()->adults); ?>" id="adults-data">
                                <input type="hidden" name="child" value="<?php echo e(request()->child); ?>" id="child-data">
                                <input type="hidden" name="pet" value="<?php echo e(request()->pet); ?>" id="pet-data">
                                <input type="hidden" name="Guests" value="<?php echo e(request()->Guests); ?>" id="show-target-data">
                                <div class="row guest-head">
                                    <div class="col-12">
                                        <h3><?php echo e(request()->Guests); ?> selected</h3>
                                    </div>
                                </div>
                                <div class="row guest-body">
                                    <div class="col-12 left">
                                        <div class="adult-box">
                                            <p>Adults <span>Ages 13+</span></p>
                                            <div class="adult-btn">
                                                <button class="button1" type="button" onclick="functiondec('#adults-data','#show-target-data','#child-data')" value="Decrement Value">-</button>
                                                <p id="adults-data-show"><?php echo e(request()->adults); ?></p>
                                                <button class="button11 button1" type="button" onclick="functioninc('#adults-data','#show-target-data','#child-data')" value="Increment Value">+</button>
                                            </div>
                                        </div>
                                        <div class="adult-box">
                                            <p>Children<span>Ages 0-12</span></p>
                                            <div class="adult-btn">
                                                <button class="button1" type="button" value="Decrement Value" onclick="functiondec('#child-data','#show-target-data','#adults-data')">-</button>
                                                <p id="child-data-show"><?php echo e(request()->child); ?></p>
                                                <button class="button11 button1" type="button" value="Increment Value" onclick="functioninc('#child-data','#show-target-data','#adults-data')">+</button>
                                            </div>
                                        </div>
                                        <p class="list-guest d-none">
                                            This listing has a maximum of <?php echo e((int)$property->personCapacity); ?> guests, not including infants. Pets are not allowed.
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
                    action='<?php echo e(route("save-booking-data")); ?>'
                    method="POST"  
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="<?php echo e($key['stripe_publish_key']); ?>"
                    id="payment-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount_data_hostaway" value="<?php echo e(json_encode($amount_data_hostaway)); ?>" />
                    <input type="hidden" name="amount_data" value="<?php echo e(json_encode($main_data)); ?>" />
                    <input type="hidden" name="property_id" value="<?php echo e($property->id); ?>" />
                    <input type="hidden" name="checkin" value="<?php echo e(Helper::getDateFormatData(Request::get('start_date'))); ?>"  />
                    <input type="hidden" name="checkout" value="<?php echo e(Helper::getDateFormatData(Request::get('end_date'))); ?>"  />
                    <input type="hidden" name="adults" value="<?php echo e(Request::get('adults')); ?>"  />
                    <input type="hidden" name="child" value="<?php echo e(Request::get('child')); ?>"  />
                    <input type="hidden" name="total_guests" value="<?php echo e($total_guests); ?>"  />
                    <input type="hidden" name="gross_amount" value="<?php echo e($main_data['data']['totalPrice']); ?>"  id="total_amount_data" />
                    <input type="hidden" name="amount" value="<?php echo e($main_data['data']['totalPrice']); ?>"  />
                    <input type="hidden" name="days" value="<?php echo e($day); ?>"  />
                    <input type="hidden" name="total_night" value="<?php echo e($day); ?>"  />
                    <input type="hidden" name="request_id" value="<?php echo e(uniqid()); ?>"  />
                    <input type="hidden" name="discount" value="<?php echo e($main_data['coupon_id']); ?>" >
                    <input type="hidden" name="discount_coupon" value="<?php echo e($main_data['coupon']); ?>" >
                    <?php
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
                    ?>
                    <input type="hidden" name="additional" value="<?php echo e(json_encode($additional)); ?>" >
                    <?php if(count($additional_new_data)>0): ?>
                    <div class="card-details info-detail additional-details">
                        <div class="card-form">                             
                            <div class="card-form-head">
                                <h3>Additional Services</h3>                            
                            </div>
                            <div class='row'>
                                <?php $__currentLoopData = $additional_new_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               
                                    <?php $total_amount_data_1=0;  ?>
                                    <?php if($c['amountType']=="flat"): ?>
                                        <?php if($c['feeAppliedPer']=="reservation"): ?>
                                            <?php $total_amount_data_1=$c['amount'];  
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'];
                                            ?>
                                        <?php elseif($c['feeAppliedPer']=="night"): ?>
                                            <?php $total_amount_data_1=($c['amount']*$day); 
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'].' per Night';
                                            ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if($c['feeAppliedPer']=="reservation"): ?>
                                            <?php $total_amount_data_1=round(($total_amount_data*$c['amount'])/100,2); 
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'] .'%';
                                            ?>
                                        <?php elseif($c['feeAppliedPer']=="night"): ?>
                                            <?php $total_amount_data_1=round(($total_amount_data*$c['amount']*$day)/100,2); 
                                                $label=$c['feeTitle'];
                                                if($c['feeDescription']){
                                                    if($c['feeTitle']){
                                                        //$label.=' ( '.$c['feeDescription'].' ) ';
                                                    }else{
                                                        $label=$c['feeDescription'];
                                                    }
                                                }
                                                $label.=' :- '.$sign.' '.$c['amount'].'% per Night';
                                            ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                   <?php if($c['feeTitle']=="Damage Insurance"): ?>
                              		<div class="col-12 p-0">
                                  		<?php echo Form::label($label); ?>

                                      <span class="text">The plan cost includes the insurance premium and assistance services fee. Insurance coverages are underwritten by: Generali U.S. Branch, New York, NY; NAIC # 11231, for the operating name used in certain states, and other important information about the Insurance & Assistance Services Plan, please see</span>
                                        <div class="addn-link">
                                            <a href="https://www.csatravelprotection.com/certpolicy.do?product=GR330" target="_BLANK">Plan details</a>  
                                           <a href="https://www.generalitravelinsurance.com/customer/disclosures.html" target="_BLANK">Important Disclosures</a>  
                                        </div>
                                       <div class="additional-btn">
                                            <div><input type="radio" name="additional_new_data[<?php echo e($c['id']); ?>]" value="yes" data-amount="<?php echo e($total_amount_data_1); ?>" data-label="<?php echo e($label); ?>" class="additional_new_data_checkbox_label"><label >Yes</label></div>
                                            <div><input type="radio"  name="additional_new_data[<?php echo e($c['id']); ?>]" value="no" class="additional_new_data_checkbox_label"><label >No</label></div>
                                        </div>
                              		
                                	</div>
                                    <?php elseif($c['feeTitle']=="Travel Insurance"): ?>
                              		<div class="col-12 p-0">
                                 		<?php echo Form::label($label); ?>

                                      <span class="text">The plan cost includes the travel insurance premium and assistance services fee. Insurance coverages are underwritten by: Generali U.S. Branch, New York, NY; NAIC # 11231, for the operating name used in certain states, and other important information about the Insurance & Assistance Services Plan, please see</span>
                                        <div class="addn-link">
                                            <a href="https://www.csatravelprotection.com/certpolicy.do?product=G-20VRD" target="_BLANK">Plan details</a> 
                                            <a href="https://www.generalitravelinsurance.com/customer/disclosures.html" target="_BLANK">Important Disclosures</a> 
                                        </div>
                                       <div class="additional-btn">
                                            <div><input type="radio" name="additional_new_data[<?php echo e($c['id']); ?>]" value="yes" data-amount="<?php echo e($total_amount_data_1); ?>" data-label="<?php echo e($label); ?>" class="additional_new_data_checkbox_label"><label >Yes</label></div>
                                            <div><input type="radio"  name="additional_new_data[<?php echo e($c['id']); ?>]" value="no" class="additional_new_data_checkbox_label"><label >No</label></div>
                                        </div>
                              
                                	</div>
                                 	<?php else: ?>
                               		<div class="col-6 p-0">
                                  		<?php echo Form::label($label); ?>

                                  		 <div class="additional-btn">
                                            <div><input type="radio" name="additional_new_data[<?php echo e($c['id']); ?>]" value="yes" data-amount="<?php echo e($total_amount_data_1); ?>" data-label="<?php echo e($label); ?>" class="additional_new_data_checkbox_label"><label >Yes</label></div>
                                            <div><input type="radio"  name="additional_new_data[<?php echo e($c['id']); ?>]" value="no" class="additional_new_data_checkbox_label"><label >No</label></div>
                                        </div>
                                  	
                                	</div>
                                    <?php endif; ?>
                                   
                                   
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="card-details info-detail">
                        <div class="card-box">
                            <div class="box-area">
                                <div class="card-head">
                                    <img src="<?php echo e(asset('front')); ?>/images/credit-card.svg" alt="" />
                                    <p class="credit-debit">Credit/Debit card</p>
                                    <p class="card-amt">+ <?php echo e($sign); ?> <?php echo e(number_format($main_data['data']['totalPrice'],2)); ?> in credit/debit card fees</p>
                                </div>
                                <div class="card-radio">
                                    <input type="radio" class="radio-card">
                                </div>
                            </div>
                        </div>
                        <div class="card-form">
                            <div class="card-form-head">
                                <h3>Pay with Credit/Debit card</h3>
                                <img src="<?php echo e(asset('front')); ?>/images/credit-card.svg" alt="" />
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
                                <select name="phone" id="country-select"></select>
                                <div class="from-number">
                                    <span class="phone-number">Phone number</span>
                                    <div class="form-text">
                                        <span>(+1)</span>
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
                                    <?php echo Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"","placeholder"=>"--Select--"]); ?>

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
                                    <a href="<?php echo e(url('terms-and-conditions')); ?>"  target="_BLANK" >Terms and Conditions</a> and 
                                    <a href="<?php echo e(url('privacy-policy')); ?>"  target="_BLANK" >Privacy Policy</a> and 
                                    <a href="javascript:;">House Rules  <span class="icon">!<span class="box-msg"><?php echo $property->houseRules; ?></span></span></a>.
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
                            <?php  
                                $i=1; 
                                $images=[];
                                foreach(json_decode($property->listingImages,true) as $c1){
                                    $images[$c1['sortOrder']]=$c1;
                                }
                            ?>
                            <?php if($property->feature_image): ?>
                                <?php $image=$property->feature_image;?>
                            <?php else: ?>
                                <?php if($property->listingImages): ?>
                                    <?php $io=0; ?>
                                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($i==1): ?>
                                            <?php $image=$c1['url']; break;?>
                                        <?php else: ?>
                                        <?php endif; ?>
                                        <?php $i++;?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($image): ?>
                                <div class="pro-img"><img src="<?php echo e(asset($image)); ?>" class="img-fluid" alt="<?php echo e($property->title); ?>" title="<?php echo e($property->title); ?>" /></div>
                            <?php endif; ?>
                            <div class="pro-cont">
                                <p class="home-type"><?php echo e($total_night); ?> NIGHTS IN <?php echo e($property->internalListingName); ?></p>
                                <h4 class="pro-name"><?php echo e($property->title ?? $property->name); ?></h4>
                            </div>
                        </div>
                        <div class="price-details">
                            <p class="p-detail">Payment will be charged when you book this property, please review the <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#myModal2">Cancellation Policy</a> and important information before booking.</p>
                            <div class="price-area">
                                <div class="prc fees">
                                    <div class="fees-value">
                                        <p class="value"><span class="val">$<?php echo e(number_format($base_price/$total_night,2)); ?> x <?php echo e($total_night); ?> nights</span></p>
                                        <div class="discount-price-box">
                                            <div class="price-box-head">
                                                <h5>Base Price Breakdown</h5>
                                            </div>
                                            <div class="price-box-content">
                                            <?php for($i=0;$i<$total_night;$i++): ?>
                                                <?php
                                                        $date = strtotime(Helper::getDateFormatData(Request::get('start_date')));
                                                        $date = strtotime("+".$i." day", $date);
                                                           $date= date('Y-m-d', $date);
                                                ?>
                                                <?php $__currentLoopData = App\Models\HostAway\HostAwayDate::where(["hostaway_id"=>$property->host_away_id,"single_date"=>$date])->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                            if($total_night>29){
                                                              $partnersListingMarkup=$property->monthlyDiscount;
                                                            }elseif($total_night>6){
                                                              $partnersListingMarkup=$property->weeklyDiscount;
                                                            }else{
                                                              $partnersListingMarkup=$property->bookingEngineMarkup;
                                                            }
                                                    ?>
                                              
                                              <div>
                                                    <p><?php echo e(date('m-d-Y',strtotime($c->single_date))); ?></p>
                                                    <p class="amt"><?php echo e($sign); ?> <?php echo e(number_format($c->price*$partnersListingMarkup,2)); ?></p>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endfor; ?>
                                            </div>
                                            <div class="price-box-bottom">
                                                <p>Total</p>
                                                <p class="amt"><?php echo e($sign); ?> <?php echo e(number_format($base_price,2)); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="total"><?php echo e($sign); ?> <?php echo e(number_format($base_price,2)); ?></p>
                                </div>
                                <?php $__currentLoopData = $show_data_amount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $fee_name=ucfirst($key);
                                        if($fee_name=="Fee"){
                                            $fee_name=" Cleaning Fee";
                                        }
                                        if($fee_name=="Tax"){
                                            $fee_name="Taxes";
                                        }
                                    ?>
                                    <div class="prc fees">
                                        <div class="fees-value">
                                            <p class="value"><span class="val"><?php echo e($fee_name); ?></span></p>
                                            <div class="discount-price-box">
                                                <div class="price-box-head">
                                                    <h5><?php echo e($fee_name); ?></h5>
                                                </div>
                                                <div class="price-box-content">
                                                    <?php $__currentLoopData = $show_data_amount[$key]['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div>
                                                            <p><?php echo e($c1['title']); ?></p>
                                                            <p class="amt"><?php echo e($sign); ?> <?php echo e(number_format($c1['total'],2)); ?></p>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <div class="price-box-bottom">
                                                    <p>Total</p>
                                                    <p class="amt"><?php echo e($sign); ?> <?php echo e(number_format($show_data_amount[$key]['total'],2)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="total"><?php echo e($sign); ?> <?php echo e(number_format($show_data_amount[$key]['total'],2)); ?></p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($main_data['coupon_id']!=""): ?>
                                    <div class="prc fees">
                                       <div class="total-amt cou">
                                          <p class="value">Successful coupon apply</p>
                                       </div>
                                    </div>
                                    <div id="coupon-form" style="display: block;">
                                       <div class="total-amt">
                                            <form method="get"  style="display:inline-block;">
                                                <?php $__currentLoopData = Request::except(["coupon"]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c_gaurav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($c_gaurav); ?>" />
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <label for="name">Promo code</label>
                                                <div class="c-btn">
                                                    <input type="text" class="form-control" disabled value="<?php echo e(request()->get("coupon")); ?>" placeholder="Enter Coupon Code" name="" required="">
                                                    <button class="submit main-btn "><span>Remove Promo code</span></button>
                                                </div>
                                            </form>
                                            <p class="total"></p>
                                       </div>
                                    </div>
                               <?php else: ?>
                                    <div class="prc fees">
                                        <div class="total-amt cou">
                                            <p class="value"><input type="checkbox" name="is_coupon" id="is_coupon"> Do you have promo code?</p>
                                        </div>
                                    </div>
                                    <div id="coupon-form" style="display: none;">
                                       <div class="total-amt">
                                            <form method="get"  style="display:inline-block;">
                                                <?php $__currentLoopData = Request::except(["coupon"]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c_gaurav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($c_gaurav); ?>" />
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <label for="name">Promo Code</label>
                                                <div class="c-btn">
                                                    <input type="text" class="form-control" value="" placeholder="Enter Promo code" name="coupon" required="">
                                                    <button class="submit main-btn "><span>Apply</span></button>
                                                </div>
                                            </form>
                                            <p class="total"></p>
                                       </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div id="main_total_data_show">
                                <div class="total-amt">
                                    <p class="value">Total</p>
                                    <p class="total"><?php echo e($sign); ?> <?php echo e(number_format($main_data['data']['totalPrice'],2)); ?></span></p>
                                </div>
                            </div>
                            <div class="price-area">
                                <?php $__currentLoopData = $main_data['data']['components']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($c['isIncludedInTotalPrice']==0): ?>
                                        <?php if($c['name']!="baseRate"): ?>
                                            <div class="prc fees">
                                                <div class="fees-value">
                                                    <p class="value"><span class="val"><?php echo e($c['title']); ?></span> 
                                                        <?php if($c['name']=="damageDeposit"): ?>
                                                            <span class="icon">!<span class="box-msg">
                                                                A damage deposit of <?php echo e($sign); ?> <?php echo e(number_format($c['total'],2)); ?>  will be collected via your Guest Portal after the completion of your booking.
                                                            </span></span>
                                                        <?php endif; ?>
                                                    </p>
                                                    <?php if($c['name']!="damageDeposit"): ?>
                                                    <div class="discount-price-box">
                                                        <div class="price-box-head">
                                                            <h5><?php echo e($c['title']); ?></h5>
                                                        </div>
                                                        <div class="price-box-content">
                                                            <div>
                                                                <p><?php echo e($c['title']); ?></p>
                                                                <p class="amt"><?php echo e($sign); ?> <?php echo e(number_format($c['total'],2)); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="price-box-bottom">
                                                            <p>Total</p>
                                                            <p class="amt"><?php echo e($sign); ?> <?php echo e(number_format($c['total'],2)); ?></p>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="total"><?php echo e($sign); ?> <?php echo e(number_format($c['total'],2)); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $amount_data_hostaway; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="total-amt">
                                        <p class="value"><?php echo e($c['title']); ?> (<?php echo e(date('d F-Y',strtotime($c['scheduledDate']))); ?>)</p>
                                        <p class="total"><?php echo e($sign); ?> <?php echo e(number_format($c['amount'],2)); ?></span></p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('datepicker')); ?>/dist/css/hotel-datepicker.css"/>
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/get-quote.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/get-quote-responsive.css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo e(asset('front')); ?>/js/get-quote.js"></script>
<script>
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
                                    <p class="total"><?php echo e($sign); ?> `+amount_data_1+`</span></p>
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
                        <p class="total"><?php echo e($sign); ?> `+$total_amount_data.toFixed(2)+`</span></p>
                    </div>
                `;
        $("#main_total_data_show").html($html);
    }
</script>
<script>



    $(document).ready(function() {
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
      var options = [{ id: '<?php echo e(asset('front/images/us.png')); ?>', text: 'United States' }];
      $('#country-select').select2({
        templateResult: formatOption,
        templateSelection: formatOption,
        data: options,
        minimumResultsForSearch: Infinity
      });
    });

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
   <script src="<?php echo e(asset('datepicker')); ?>/node_modules/fecha/dist/fecha.min.js"></script>
   <script src="<?php echo e(asset('datepicker')); ?>/dist/js/hotel-datepicker.js"></script>
    <script>
    <?php
        $new_data_blocked=LiveCart::iCalDataCheckInCheckOutCheckinCheckout($property->id);
        $checkin=json_encode($new_data_blocked['checkin']);
        $checkout=json_encode($new_data_blocked['checkout']);
        $blocked=json_encode($new_data_blocked['blocked']);
    ?>
    function ajaxCallingData(){}
    function clearDataForm(){$("#start_date").val('');$("#end_date").val('');}
    var checkin = <?php echo $checkin;  ?>;
    var checkout = <?php echo ($checkout);  ?>;
    var blocked= <?php echo ($blocked);  ?>;
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
                inline: true, 
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
                      ajaxCallingData();
                    }
                }
            }
        );
        <?php if(Request::get("start_date")): ?>
            <?php if(Request::get("end_date")): ?>
                setTimeout(function(){$("#demo17").val("<?php echo e(request()->start_date); ?> - <?php echo e(request()->end_date); ?>");document.getElementById("start_date").value ="<?php echo e(request()->start_date); ?>";document.getElementById("end_date").value ="<?php echo e(request()->end_date); ?>";ajaxCallingData();},1000);
            <?php endif; ?>
        <?php endif; ?>
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
          <?php //dd($cancellation); ?>
          <?php if(isset($cancellation['status'])): ?>
            <?php if($cancellation['status']=="success"): ?>
                <?php if(isset($cancellation['result'])): ?>
                    <?php if(isset($cancellation['result']['cancellationPolicyItem'])): ?>
                
                      <?php $__currentLoopData = $cancellation['result']['cancellationPolicyItem']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <p  style="color:black;"><?php echo e($c['refundAmount']); ?>% refund up to <?php echo e(($c['timeDelta']/(60*60*24))*-1); ?> days before the <?php echo e($c['event']); ?> date.</p>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-rupa/htdocs/rupa.webdesignvrvr.com/projects/resources/views/front/static/get-quote.blade.php ENDPATH**/ ?>