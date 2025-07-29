<footer>
    <div class="container">
        <div class="row">
             <div class="col-4 logo-sec">
                <div class="footer_logo">
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset($setting_data['footer_logo'] ?? 'front/images/logo.png')); ?>" alt="Logo" class="img-fluid"></a>
                </div>
            </div>
            <div class="col-4 quick">
                <ul class="quick-links">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo e(url('about-us')); ?>">About Us</a></li>
                    <li><a href="<?php echo e(url('properties')); ?>">Properties</a></li>
                   
                </ul>
                <ul class="quick-links"> 
                    <li><a href="<?php echo e(url('services')); ?>">Services</a></li>
                    <li><a href="<?php echo e(url('attractions')); ?>">Attractions</a></li>
                    <li><a href="<?php echo e(url('contact-us')); ?>">Contact Us</a></li>
                    
                </ul>
            </div>
            <div class="col-4 first">
                <h4>CONTACT INFO</h4>
                  <div class="footer-contact-info">
                      <p class="footer-contact-phone"><i class="fa-solid fa-mobile-button"></i><a href="tel:<?php echo $setting_data['mobile']; ?>"><?php echo $setting_data['mobile']; ?></a></p>
                      <p class="footer-contact-mail"><i class="fa-solid fa-envelope-open"></i><a href="mailto:<?php echo $setting_data['email']; ?>"><?php echo $setting_data['email']; ?></a></p>
                  </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-4 left">
                    <p><?php echo $setting_data['copyright']; ?></p>
                </div>
                <div class="col-4 right">
                    <div class="footer-about-social-list">
                        <a href="<?php echo e($setting_data['instagram']); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
                        <a href="<?php echo e($setting_data['facebook']); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="col-4 center">
                    <div class="right_copyright">
                        <p>Designed &amp; Developed by <a href="https://www.webdesignvr.com/" target="_blank"><img src="<?php echo e(asset('front')); ?>/images/footer_1.webp"></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="fixed-btn">
    <a href="<?php echo e($setting_data['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="ng-fab"><img src="<?php echo e(asset('front')); ?>/images/logo-whatsapp.svg" alt="" width="34"></a>
    <a href="mailto:<?php echo $setting_data['email']; ?>" class="main-btn footer-contt">Contact Us</a>
</div>
<?php echo $__env->make("front.layouts.js", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent("js"); ?><?php /**PATH /home/webdesignvrvr-asif/htdocs/asif.webdesignvrvr.com/projects/resources/views/front/layouts/footer.blade.php ENDPATH**/ ?>