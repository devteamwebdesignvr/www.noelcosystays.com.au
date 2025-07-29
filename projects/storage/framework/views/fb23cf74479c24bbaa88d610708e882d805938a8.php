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
            <h1 data-aos="zoom-in" data-aos-duration="1500" class="aos-init aos-animate"><?php echo e($name); ?></h1>
            <div class="checklist">
                <p>
                    <a href="<?php echo e(url('/')); ?>" class="text"><span>Home</span></a>
                    <a class="g-transparent-a"><?php echo e($name); ?></a>
                </p>
            </div>
        </div>
    </section>
<section class="how-we-value-wrapp atr">
   <div class="container">
    
      <div class="row">
          <?php $__currentLoopData = App\Models\AttractionCategory::orderBy("id","desc")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-lg-4 col-md-6 col-12 atrr">
            <div class="img-card"><a href="<?php echo e(url('attractions/category/'.$c->seo_url)); ?>"><img src="<?php echo e(asset($c->image)); ?>" class="img-fluid" alt=""></a>
               <div class="overlay"></div>
            </div>
            <div class="atr-cont"><a href="<?php echo e(url('attractions/category/'.$c->seo_url)); ?>"><h4><?php echo e($c->name); ?></h4></a></div>
         </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
</section>



<?php $__env->stopSection(); ?>
<?php $__env->startSection("css"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/attractions.css" />
<link rel="stylesheet" href="<?php echo e(asset('front')); ?>/css/attractions-responsive.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection("js"); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<script>

  $(document).ready(function(){
        $(".target-class").each(function(){
            var a=$(this).height();
             if(a < 280){
                $(this).parents(".parent-class").find(".mr").css("display", "none");
            }
            else{
                $(this).parents(".parent-class").find(".mr").css("display", "block");
                $(this).css("height", "280px");
            }
        })
        
     var a = $(".target-class").height();
   
  });

    $(document).on("click",".readmore",function(){
        that=$(this);
        that.removeClass("readmore").addClass("readless").html("Read Less");
        that.parents(".parent-class").find(".target-class").css({"height": "auto"});
    });
    $(document).on("click",".readless",function(){
        that=$(this);
        that.removeClass("readless").addClass("readmore").html("Read More");
        that.parents(".parent-class").find(".target-class").css({"height": "280px"});
    });
    
   


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-rupa/htdocs/rupa.webdesignvrvr.com/projects/resources/views/front/static/attractions.blade.php ENDPATH**/ ?>