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
        $bannerImage=asset('front/images/b1.jpg');
        if($data->bannerImage){
            $bannerImage=asset($data->bannerImage);
        }
    ?>
	<!-- start banner sec -->

    <section class="page-title" style="background-image: url(<?php echo e($bannerImage); ?>);">
        <div class="auto-container">
            <h1  class="aos-init aos-animate"><?php echo e($name); ?></h1>
            <div class="checklist">
                <p>
                    <a href="<?php echo e(url('/')); ?>" class="text"><span>Home</span></a>
                    <a class="g-transparent-a"><?php echo e($name); ?></a>
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
                      <?php echo $data->longDescription; ?>

                          </div>
                    <ul class="contact-info">
                        <li><a href="mailto:<?php echo $setting_data['email']; ?>"><img src="<?php echo e(asset('front')); ?>/images/email.webp" alt=""><span>Email:</span><?php echo $setting_data['email']; ?></a></li>
                        <li><a href="mailto:<?php echo $setting_data['mobile']; ?>"><img src="<?php echo e(asset('front')); ?>/images/phone.webp" alt=""><span>Phone:</span><?php echo $setting_data['mobile']; ?></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-12 contact-form">
                    <div class="inner-container" >
                        <div class="sec-title">
                            <h3>Send us a message</h3>
                            
                        </div>
                        <div class="contact-form">
                            <?php echo Form::open(["route"=>"contactPost"]); ?>

                                <div class="row clearfix">
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label>First Name</label>
                                        <input type="text" name="name" id="form_fname" placeholder="First name" value="" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label>Last Name</label>
                                        <input type="text" name="name" id="form_lname" placeholder="Last name" value="" required="">
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
                                        <?php echo Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"","placeholder"=>"--Select--"]); ?>

                                    </div> 
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Message</label>
                                        <textarea class="" name="message" id="msg" placeholder="Enter message..." required=""></textarea>
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
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
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


  
<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/contact.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/contact-responsive.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection("js"); ?>
<script>
$('#reload').click(function () {
    $.ajax({
        type: 'GET',
        url: "<?php echo e(url('reload-captcha')); ?>",
        success: function (data) {
            $(".captcha span").html(data.captcha);
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com/projects/resources/views/front/static/contact.blade.php ENDPATH**/ ?>