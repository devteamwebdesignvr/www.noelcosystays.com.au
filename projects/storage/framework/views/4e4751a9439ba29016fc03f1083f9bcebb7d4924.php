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
   <?php
  $list=App\Models\Attraction::where("category_id",$data->id)->orderBy("id","desc")->paginate(1000);
  ?>  
	<!-- end banner sec -->
   
<section class="summary-section ">
        <div class="container"> 
           <?php $i=0; ?>
              <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($i%2==0): ?>
            <div class="row position-relative" id="a1">
                <div class="col-lg-7 col-md-12 col-sm-12 position-relative">
                    <div class="inner-column" >
                        <?php if($c->image): ?>
                        <div class="image">
                            <img src="<?php echo e(asset($c->image)); ?>" alt="<?php echo e($c->name); ?>"  class="attachment-full size-full aos-init aos-animate" loading="lazy" >
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 position-relative right-contentss">
                    <div class="inner-column-content  parent-class">
                        <h3><a <?php if($c->type=="internal"): ?> href="<?php echo e(url('attractions/detail/'.$c->seo_url)); ?>"  <?php else: ?> href="<?php echo e($c->seo_url); ?>" target="_BLANK"    <?php endif; ?> ><?php echo e($c->name); ?></a></h3>
                        <div class="line"></div>
                        <p class="target-class"><?php echo e($c->description); ?></p>
                        <a class="main-btn mr"><span class="readmore">Readmore</span></a>
                    </div>
                </div>
                <div class="dot">
                  <img src="<?php echo e(asset('front')); ?>/img/dot-shape.png">
                </div>
            </div>
            <?php else: ?>
            <div class="row position-relative" id="a1">
                <div class="col-lg-7 order-lg-2 col-md-12 col-sm-12 position-relative">
                    <div class="inner-column" >
                        <div class="image">
                            <img src="<?php echo e(asset($c->image)); ?>" alt="<?php echo e($c->name); ?>"  class="attachment-full size-full aos-init aos-animate" loading="lazy" >
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-lg-1 col-md-12 col-sm-12 position-relative right-contentss">
                    <div class="inner-column-content parent-class">
                        <h3 ><a <?php if($c->type=="internal"): ?> href="<?php echo e(url('attractions/detail/'.$c->seo_url)); ?>"  <?php else: ?> href="<?php echo e($c->seo_url); ?>" target="_BLANK"    <?php endif; ?>><?php echo e($c->name); ?></a></h3>
                        <div class="line"></div>
                        <p  class="target-class" ><?php echo e($c->description); ?></p>
                        <a class="main-btn mr"><span class="readmore">Readmore</span></a>
                    </div>
                </div>
                <div class="dot">
                  <img src="<?php echo e(asset('front')); ?>/img/dot-shape.png">
                </div>
            </div>


               <?php endif; ?>
            <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="row align-items-center">
               <?php echo e($list->links()); ?>

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
<?php echo $__env->make("front.layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-reji/htdocs/reji.webdesignvrvr.com/projects/resources/views/front/attractions/category.blade.php ENDPATH**/ ?>