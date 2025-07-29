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
?>
<?php echo $__env->make("front.layouts.banner", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Guests section start -->

<section class="about-us">
   <div class="container">
      <div class="abt-info">
         <div class="about-image-sec">
            <div class="abt-image">
               <div class="abt-img1 aos-init aos-animate" data-aos="fade-down" data-aos-duration="1000">
                  <img src="<?php echo e(asset($data->about_image1)); ?>" title="About" alt="About">
               </div>
               <div class="abt-img2 aos-init" data-aos="fade-up" data-aos-duration="1000">
                  <img src="<?php echo e(asset($data->about_image2)); ?>" title="About" alt="About">
               </div>
            </div>
         </div>
         <div class="about-content-sec">
            <div class="abt-content">
               <!-- <span class="ratings"><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i></span> -->
              <!-- <p class="head">About</p> -->
               <div class="abt-para">
                 <?php echo $data->mediumDescription; ?>

               </div>
               
            </div>
         </div>
        
      </div>
   </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/about.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/about-responsive.css" />
<?php $__env->stopSection(); ?> 
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script src="<?php echo e(asset('front')); ?>/js/about.js" ></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-lee-anne/htdocs/lee-anne.webdesignvrvr.com/projects/resources/views/front/static/about.blade.php ENDPATH**/ ?>