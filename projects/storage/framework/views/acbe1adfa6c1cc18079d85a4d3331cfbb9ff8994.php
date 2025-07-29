<footer>
  <div class="container">
    <div class="footer-logo text-center">
      <a href="<?php echo e(url('/')); ?>" class="logo">
        <img src="<?php echo e(asset($setting_data['footer_logo'] ?? 'front/images/logo.png')); ?>" alt="Logo" class="img-fluid" data-aos="zoom-in">
      </a>
    </div>
    <div class="row">
      <div class="col-4 first">
        <h4>CONTACT INFO</h4>
        <div class="footer-contact-info">
          <p class="footer-contact-phone"><i class="fa-solid fa-mobile-button"></i><a href="tel:<?php echo $setting_data['mobile'] ?? '#'; ?>"><?php echo $setting_data['mobile'] ?? '#'; ?></a></p>
          <p class="footer-contact-mail"><i class="fa-solid fa-envelope-open"></i><a href="mailto:<?php echo $setting_data['email'] ?? '#'; ?>"><?php echo $setting_data['email'] ?? '#'; ?></a></p>
        </div>
      </div>
      <div class="col-8 quick">
        <ul class="quick-links">
          <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
          <li><a href=" <?php echo e(url('about-us')); ?>">About Us</a></li>
          <li><a href="<?php echo e(url('properties')); ?>"> Vacation Rentals </a></li>
          
          <!--<li><a href="#" data-href=" <?php echo e(url('gallery')); ?>">Gallery</a></li>-->
         
        </ul>
        <ul class="quick-links">
           <li><a href="<?php echo e(url('blogs')); ?>">Blogs</a></li>
           <li><a href="<?php echo e(url('attractions')); ?>">Attractions</a></li>
          <!--
            <li><a href="#" data-href="<?php echo e(url('faqs')); ?>">Faqs</a></li>-->
          <li><a href="<?php echo e(url('contact-us')); ?>">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-4 get d-none">
        <h4>JOIN OUR NEWSLETTER</h4>
        <p>Subscribe our newsletter to get latest updates</p>
        <form action="">
          <input type="email" placeholder="Email Address">
          <button type="submit" class="main-btn">Subscribe</button>
        </form>
      </div>
    </div>
  </div>


  <div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <div class="left_copyright">
            <p><?php echo $setting_data['copyright'] ?? '#'; ?></p>
          </div>
        </div>
        <div class="col-md-2">
          <div class="right_copyright">
            <div class="footer-about-social-list">
              <a  href="<?php echo $setting_data['instagram'] ?? '#'; ?>" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
              <a  href="<?php echo $setting_data['facebook'] ?? '#'; ?>" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
   
            </div>
        </div>
        
        </div>
        <div class="col-md-5 ">
          <div class="center-copyright">
            <p>Designed &amp; Developed by <a href="https://www.webdesignvr.com/" target="_blank"><img src="<?php echo e(asset('front')); ?>/images/footer_img.webp"></a></p>
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- <div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-6 left">
          <p><?php echo $setting_data['copyright'] ?? '#'; ?></p>
        </div>
        <div class="col-6 right">
          <div class="footer-about-social-list">
            <a href="<?php echo $setting_data['instagram'] ?? '#'; ?>" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
            <a href="<?php echo $setting_data['facebook'] ?? '#'; ?>" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="<?php echo $setting_data['tiktok'] ?? '#'; ?>" target="_blank" rel="noopener"><i class="fa-brands fa-tiktok"></i></a>
            <a href="<?php echo $setting_data['youtube'] ?? '#'; ?>" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</footer>
<?php echo $__env->make("front.layouts.js", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent("js"); ?>
<script>
  $(document).on("submit", ".newsletter-data", function(e) {
    e.preventDefault();
    data = $(this).serialize();
    url = $(this).attr("action");
    $.post(url, data, function(data) {
      if (data.status == 200) {
        $(".newsletter-data")[0].reset();
        toastr.success(data.message);
      } else {
        toastr.error(data.message);
      }
    });
  });
</script><?php /**PATH /home/webdesignvrvr-reji/htdocs/reji.webdesignvrvr.com/projects/resources/views/front/layouts/footer.blade.php ENDPATH**/ ?>