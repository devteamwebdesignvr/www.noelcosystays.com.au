<h4 class="text-warning">Seo Section</h4>
<div class="row">
  
        	 <?php
$selected=[];
if(isset($data)){
    if($data->collection_ids){
        $ara=json_decode($data->collection_ids,true);
        if(is_array($ara)){
            if(count($ara)>0){
                $selected=$ara;
            }
        }
    }
}
?>
    <div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("Collection"); ?>

			<?php echo Form::select("collection_ids[]",ModelHelper::getCategoryCategorySelectList(),$selected,["class"=>"form-control select2","multiple"]); ?>

			<span class="text-danger"><?php echo e($errors->first("collection_ids")); ?></span>
		</div>
	</div>
	
    	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("location"); ?>

			<?php echo Form::select("location_id",ModelHelper::getLocationSelectList(),null,["class"=>"form-control","placeholder"=>"Choose Location"]); ?>

			<span class="text-danger"><?php echo e($errors->first("heading")); ?></span>
		</div>
	</div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("title"); ?>

            <?php echo Form::text("title",null,["class"=>"form-control","required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("title")); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>SEO URL ( Only A-z,0-9,_,- are allowed)*</label>
            <?php echo Form::text("seo_url",null,["class"=>"form-control", "pattern"=>"[a-zA-Z0-9-_]+", "title"=>"Enter Valid SEO URL", "oninvalid"=>"this.setCustomValidity('SEO URL is not Valid Please enter first letter must be a-z and only accept chars a-z 0-9,-,_')" ,"onchange"=>"try{setCustomValidity('')}catch(e){}", "oninput"=>"setCustomValidity(' ')","required"=>"required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("seo_url")); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("Home page show"); ?>

            <?php echo Form::select("is_home",Helper::getBooleanDataActual(),null,["class"=>"form-control"]); ?>

        </div>
    </div>
</div>
  <div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("rental_Agreement_attachment"); ?>

            <?php echo Form::file("rental_aggrement_attachment",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("rental_aggrement_attachment")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->rental_aggrement_attachment!=""): ?>
                     <a href="<?php echo e(asset(($data->rental_aggrement_attachment))); ?>" target="_BLANK" >Attachment</a>  <br>
                     
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input custom-control-input-danger" name="remove_rental_aggrement_attachment" value="yes" type="checkbox" id="remove_rental_aggrement_attachment" >
                        <label for="remove_rental_aggrement_attachment" class="custom-control-label">Remove Rental Agreement Attachment</label>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("banner_image"); ?>

            <?php echo Form::file("banner_image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("banner_image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->banner_image!=""): ?>
                     <img src="<?php echo e(asset(($data->banner_image))); ?>" width="200px">  <br>
                     
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input custom-control-input-danger" name="remove_banner_image" value="yes" type="checkbox" id="remove_banner_image" >
                        <label for="remove_banner_image" class="custom-control-label">Remove Rental Aggrement Attachment</label>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("feature_image"); ?>

            <?php echo Form::file("feature_image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("feature_image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->feature_image!=""): ?>
                     <img src="<?php echo e(asset(($data->feature_image))); ?>" width="200px">  <br>
                 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("meta_title"); ?>

            <?php echo Form::textarea("meta_title",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("meta_title")); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("meta_keywords"); ?>

            <?php echo Form::textarea("meta_keywords",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("meta_keywords")); ?></span>
        </div>
    </div>

    <div class="col-md-4">
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
</div>


<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("rating"); ?>

            <?php echo Form::number("rating",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("rating")); ?></span>
        </div>
    </div>
</div>
<div class="row d-none">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("footer_section"); ?>

            <?php echo Form::textarea("footer_section",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("footer_section")); ?></span>
        </div>
    </div>
</div>
<div class="row d-none">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("virtual_tour"); ?>

            <?php echo Form::textarea("virtual_tour",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("virtual_tour")); ?></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("map"); ?>

            <?php echo Form::textarea("map",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("map")); ?></span>
        </div>
    </div>
</div>

<?php /**PATH /home/webdesignvrvr-rupa/htdocs/rupa.webdesignvrvr.com/projects/resources/views/admin/host_fully_properties/form.blade.php ENDPATH**/ ?>