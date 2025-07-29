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
        $bannerImage=asset('front/images/internal-banner.webp');
        if($data->bannerImage){
            $bannerImage=asset($data->bannerImage);
        }
    ?>
	<!-- start banner sec -->
    

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
	<!-- end banner sec -->

  
<?php  $faqs = App\Models\Faq::orderBy('id','desc')->get();?>
<?php if(count($faqs)>0): ?>
<section class="faq" id="faqs">
   <div class="container">
      <div class="head-sec">
         <h2>Frequently Asked Questions</h2>
      </div>
      <div class="faq-sec">
         <div class="accordion" id="accordionExample">
             <?php $i =1; ?>
             <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <?php if($i == 1): ?>
                    <div class="accordion-item">
                       <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse"     data-bs-target="#collapseOne<?php echo e($c->id); ?>" aria-expanded="true" aria-controls="collapseOne<?php echo e($c->id); ?>"><?php echo $c->question; ?></button></h2>
                       <div id="collapseOne<?php echo e($c->id); ?>" class="accordion-collapse collapse show"
                          data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $c->answer; ?></div>
                       </div>
                    </div>
                 <?php else: ?>
                    <div class="accordion-item">
                       <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"data-bs-target="#collapseTwo<?php echo e($c->id); ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo e($c->id); ?>"><?php echo $c->question; ?></button></h2>
                       <div id="collapseTwo<?php echo e($c->id); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $c->answer; ?></div>
                       </div>
                    </div>
                 <?php endif; ?>
                 <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
  
      </div>
   </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>
         <?php $__env->startSection("css"); ?>
         <?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/home.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/home-responsive.css" />
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/front/static/faq.blade.php ENDPATH**/ ?>