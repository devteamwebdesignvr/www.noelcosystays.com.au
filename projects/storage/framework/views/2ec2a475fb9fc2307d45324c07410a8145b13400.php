 <div class="loader-head " id="sygnius-loader">
    <div class="loader">
    	 <img src="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.png')); ?>" alt="Logo" class="img-fluid logo-loader">
    	<img src="<?php echo e(asset('front')); ?>/images/scroll-loader1.gif" alt="">
    	<p>Please wait..</p>
    </div>
</div>
<header class="page-header mob">
    <div class="container">
        <div class="row">
            <a href="<?php echo e(url('/')); ?>" class="logo"><img src="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.png')); ?>" alt="Logo" class="img-fluid"></a>
            <div class="menu-toggle1" id="menu-toggle1"><i class="fa fa-bars"></i></div>
            <div class="menu-bar-in" id="tag1">
                <div class="mobile-nav">
                    <div class="mobile-menu-logo">
                        <a href="<?php echo e(url('/')); ?>" class="logo"><img src="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.png')); ?>" alt="Logo" class="img-fluid"></a>
                        <span id="close-menu"><i class="fa fa-times" id="close-menu1"></i></span>
                    </div>
                    <nav class="navbar navbar-expand-lg">
                        <div class="navbar-collapse" id="main_nav">
                             <ul class="navbar-nav">
                    <li class="nav-item"><a href="<?php echo e(url('/')); ?>" class="nav-link ">Home</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('about-us')); ?>" class="nav-link ">About Us</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('properties')); ?>" class="nav-link ">Properties</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('services')); ?>" class="nav-link ">Services</a></li>
                    
                    <li class="nav-item"><a href="<?php echo e(url('attractions')); ?>" class="nav-link">Attractions</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('contact-us')); ?>" class="nav-link">Contact Us</a> </li>
                </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="deskheader stickheader">
   <div class="container">
        <div class="row">
            <div class="col-2">
               <div class="header-logo">
                    <a href="<?php echo e(url('/')); ?>" class="logo"><img src="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.png')); ?>" alt="Logo" class="img-fluid" width="100" height="65"></a>
                </div> 
            </div>
            <div class="col-8 header-nav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="<?php echo e(url('/')); ?>" class="nav-link ">Home</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('about-us')); ?>" class="nav-link ">About Us</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('properties')); ?>" class="nav-link ">Properties</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('services')); ?>" class="nav-link ">Services</a></li>
                    
                    <li class="nav-item"><a href="<?php echo e(url('attractions')); ?>" class="nav-link">Attractions</a></li>
                    <li class="nav-item"><a href="<?php echo e(url('contact-us')); ?>" class="nav-link">Contact Us</a> </li>
                </ul>
            </div>
            <div class="col-2 header-contact">
                <div class="reservations">
                    <div class="icon">   <img src="<?php echo e(asset('front')); ?>/images/phone-call.png" alt=""></div>
                    <div class="text"><a href="tel:<?php echo $setting_data['mobile']; ?>"><?php echo $setting_data['mobile']; ?></a> </div>
                </div> 
            </div>
        </div>  
    </div>
</header><?php /**PATH /home/webdesignvrvr-asif/htdocs/asif.webdesignvrvr.com/projects/resources/views/front/layouts/header.blade.php ENDPATH**/ ?>