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
    <!-- start banner sec -->

<section class="about-owner">
    <div class="container px-0 lg-px-2">
        <div class="owner-infoo">
            <div class="img" data-aos="fade-up" data-aos-duration="1000">
                <div class="abt-owner">
                  <div class="abt-img mb-2"><img src="<?php echo e(asset($data->image)); ?>" class="img-fluid" alt=""></div>
                </div>
            </div>
            <div class="cont">
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
               
            </div>
        </div>
    </div>
</section>
    <?php echo $data->seo_section; ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/about-owner.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/about-owner-responsive.css" />
<?php $__env->stopSection(); ?> 
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script src="<?php echo e(asset('front')); ?>/js/about-owner.js" ></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/front/static/about-owner.blade.php ENDPATH**/ ?>