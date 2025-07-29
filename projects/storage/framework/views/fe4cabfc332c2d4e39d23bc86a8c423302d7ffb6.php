<?php $__env->startSection("title",$data->meta_title); ?>
<?php $__env->startSection("keywords",$data->meta_keywords); ?>
<?php $__env->startSection("description",$data->meta_description); ?>

<?php $__env->startSection("container"); ?>

    <?php
        $name=$data->name;
        $bannerImage=asset('front/images/internal-banner.webp');
        $payment_currency= $setting_data['payment_currency'];
        if($property->currencyCode == 'INR'){
          $payment_currency= '₹';
        } 
    ?>
	<!-- start banner sec -->
    

    <section class="page-title d-none" style="background-image: url(<?php echo e($bannerImage); ?>);">
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
     
<section class="payments-details mt-4 mb-4">
    <div class="container-fluid">
        <div class="row">

            <div class="col-3 payment-side"></div>
            <div class="col-6 payment-side">
                <div class="payment-bar">
                    <div class="payment-head">
                        <h4>You're all set for <?php echo e($property->name); ?></h4>
                        <p>Congratulations, Your booking is confirmed. You will receive an email with further details.</p>
                    </div>
                    <div class="payment-slider owl-carousel" id="payment-slide">
                        <?php  $i=1; ?>
                        <?php if($property->listingImages): ?>
                             <?php $io=0; ?>
                             <?php $__currentLoopData = json_decode($property->listingImages,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($i==10): ?>
                                    <?php break; ?>
                                <?php endif; ?>
                                <div class="item">
                                    <img src="<?php echo e(asset($c1['url'])); ?>" alt="<?php echo e($c1['caption']); ?>"  title="<?php echo e($c1['caption']); ?>" />
                                </div>
                               <?php $i++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="check-details">
                        <ul>
                            <li>
                                <p>Check-in:</p>
                                <span> <?php echo e(date('F jS, Y',strtotime($booking['checkin']))); ?></span>
                            </li>
                            <li>
                                <p>Check-out:</p>
                                <span> <?php echo e(date('F jS, Y',strtotime($booking['checkout']))); ?></span>
                            </li>
                        </ul>
                        <ul>
                            <li><p>Guests:</p>
                                <span><?php echo e($booking['total_guests']); ?> (<?php echo e($booking['adults']); ?> Adults, <?php echo e($booking['child']); ?> Child)</span>
                            </li>
                            <li>
                                <p>Nights:</p>
                                <span><?php echo e($booking['total_night']); ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="price-details"> 
                        <div class="price-area">
                          
                 
                         	<?php $main_data=(json_decode($booking['financeField'],true));  ?>
                            <?php $__currentLoopData = $main_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($c['type']!="other"): ?>
                                    <div class="prc fees">
                                        <p class="value">
                                            <span><?php echo e($c['title']); ?></span>
                                        </p>
                                        <p class="amt"><?php echo $payment_currency; ?><?php echo e(number_format($c['total'],2)); ?></p>
                                    </div>
                                <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   
                 
                        </div>

                   
                        <div class="total-amt">
                            <p class="value">Total </p>
                            <p class="total"><?php echo $payment_currency; ?><?php echo e(number_format($booking['total_amount'],2)); ?></p>
                        </div>
                        <div class="price-area">
                    

                                <?php $__currentLoopData = $main_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                                    <?php if($c['type']=="other"): ?>
                                 
                                    <div class="prc fees">
                                        <p class="value">
                                            <span><?php echo e($c['title']); ?></span><sub>(Paid via Guest Portal)</sub>
                                        </p>
                                        <p class="amt"><?php echo $payment_currency; ?><?php echo e(number_format($c['total'],2)); ?></p>
                                    </div>
                                   <?php endif; ?>
                     
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
          
                    </div>
                </div>
            </div>
            <div class="col-8 payment-map d-none">
                <?php if($property->map): ?>
                    <iframe src="<?php echo $property->map; ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <?php else: ?>
                  
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
    

<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/payment.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/payment-responsive.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="<?php echo e(asset('front')); ?>/js/payment.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-reji/htdocs/reji.webdesignvrvr.com/projects/resources/views/front/booking/payment/first-preview.blade.php ENDPATH**/ ?>