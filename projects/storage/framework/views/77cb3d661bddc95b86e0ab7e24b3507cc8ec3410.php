<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("name"); ?>

            <?php echo Form::text("name",null,["class"=>"form-control","required"=>"required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("name")); ?></span>
        </div>
    </div>
 
    <div class="col-md-6">
        <div class="form-group">
          <label>SEO URL ( Only A-z,0-9,_,- are allowed)</label>
            <?php echo Form::text("seo_url",null,["class"=>"form-control", "readonly","pattern"=>"[a-zA-Z0-9-_]+", "title"=>"Enter Valid SEO URL", "oninvalid"=>"this.setCustomValidity('SEO URL is not Valid Please enter first letter must be a-z and only accept chars a-z 0-9,-,_')" ,"onchange"=>"try{setCustomValidity('')}catch(e){}", "oninput"=>"setCustomValidity(' ')","required"=>"required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("seo_url")); ?></span>
        </div>
    </div>
 


 
  <?php if(isset($data)): ?>
<?php if($data->seo_url=="home"): ?>  

    <div class="col-md-4 ">
        <div class="form-group">
            <?php echo Form::label("about_image1"); ?>

            <?php echo Form::file("about_image1",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("about_image1")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->about_image1!=""): ?>
                     <img src="<?php echo e(asset(($data->about_image1))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("about_image2"); ?>

            <?php echo Form::file("about_image2",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("about_image2")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->about_image2!=""): ?>
                     <img src="<?php echo e(asset(($data->about_image2))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-4 d-none">
        <div class="form-group">
            <?php echo Form::label("owner_image"); ?>

            <?php echo Form::file("owner_image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("owner_image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->owner_image!=""): ?>
                     <img src="<?php echo e(asset(($data->owner_image))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php elseif($data->seo_url=="about-us"): ?>

      <div class="col-md-3 ">
        <div class="form-group">
            <?php echo Form::label("bannerImage"); ?>

            <?php echo Form::file("bannerImage",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("bannerImage")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->bannerImage!=""): ?>
                     <img src="<?php echo e(asset(($data->bannerImage))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
     <div class="col-md-3 ">
        <div class="form-group">
            <?php echo Form::label("about_image1"); ?>

            <?php echo Form::file("about_image1",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("about_image1")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->about_image1!=""): ?>
                     <img src="<?php echo e(asset(($data->about_image1))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-md-3 ">
        <div class="form-group">
            <?php echo Form::label("about_image2"); ?>

            <?php echo Form::file("about_image2",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("about_image2")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->about_image2!=""): ?>
                     <img src="<?php echo e(asset(($data->about_image2))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
     <div class="col-md-3 d-none">
        <div class="form-group">
            <?php echo Form::label("about_image3"); ?>

            <?php echo Form::file("owner_image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("owner_image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->owner_image!=""): ?>
                     <img src="<?php echo e(asset(($data->owner_image))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="col-md-6 ">
        <div class="form-group">
            <?php echo Form::label("bannerImage"); ?>

            <?php echo Form::file("bannerImage",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("bannerImage")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->bannerImage!=""): ?>
                     <img src="<?php echo e(asset(($data->bannerImage))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="col-md-6 ">
        <div class="form-group">
            <?php echo Form::label("image"); ?>

            <?php echo Form::file("image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->image!=""): ?>
                     <img src="<?php echo e(asset(($data->image))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>


    <div class="col-md-12 d-none">
        <div class="form-group">
            <?php echo Form::label("templete"); ?>

            <?php echo Form::select("templete",Helper::getTempletes(),null,["class"=>"form-control","required"=>"required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("templete")); ?></span>
        </div>
    </div>
    <div class="col-md-4 d-none">
        <div class="form-group">
            <?php echo Form::label("publish"); ?>

            <?php echo Form::select("publish",["published"=>"published","draft"=>"draft","pending"=>"pending"],null,["class"=>"form-control","required"=>"required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("publish")); ?></span>
        </div>
    </div>

   
</div>
<?php if(isset($data)): ?>
<?php if($data->seo_url=="home"): ?>

<div class="row ">
    <div class="col-md-4 ">
        <div class="form-group">
            <?php echo Form::label("strip_title"); ?>

            <?php echo Form::text("strip_title",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("strip_title")); ?></span>
        </div>
    </div>

    <div class="col-md-4 ">
        <div class="form-group">
            <?php echo Form::label("strip_description"); ?>

            <?php echo Form::textarea("strip_desction",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("strip_desction")); ?></span>
        </div>
    </div>

    <div class="col-md-4 ">
        <div class="form-group">
            <?php echo Form::label("strip_image"); ?>

            <?php echo Form::file("strip_image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("strip_image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->strip_image!=""): ?>
                     <img src="<?php echo e(asset(($data->strip_image))); ?>" width="200" > 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php endif; ?>
<?php endif; ?>
<div class="row d-none">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("description"); ?>

            <?php echo Form::textarea("description",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("description")); ?></span>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("shortDescription"); ?>

            <?php echo Form::textarea("shortDescription",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("shortDescription")); ?></span>
        </div>
    </div>
  
</div>
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("mediumDescription"); ?>

            <?php echo Form::textarea("mediumDescription",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("mediumDescription")); ?></span>
        </div>
    </div>
 
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("longDescription"); ?>

            <?php echo Form::textarea("longDescription",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("longDescription")); ?></span>
        </div>
    </div>
  
</div>

<div class="row">
    <div class="col-md-12 alert alert-warning text-center">
        <h3>Seo Section</h3>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("meta_title"); ?>

            <?php echo Form::textarea("meta_title",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("meta_title")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("meta_keywords"); ?>

            <?php echo Form::textarea("meta_keywords",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("meta_keywords")); ?></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("meta_description"); ?>

            <?php echo Form::textarea("meta_description",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("meta_description")); ?></span>
        </div>
    </div>
</div>
<div class="row d-none">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("header_section"); ?>

            <?php echo Form::textarea("header_section",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("header_section")); ?></span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("footer_section"); ?>

            <?php echo Form::textarea("footer_section",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("footer_section")); ?></span>
        </div>
    </div>
</div><?php /**PATH /home/webdesignvrvr-lee-anne/htdocs/lee-anne.webdesignvrvr.com/projects/resources/views/admin/cms/form.blade.php ENDPATH**/ ?>