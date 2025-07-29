<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("name"); ?>

            <?php echo Form::text("name",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("name")); ?></span>
        </div>
    </div>


        
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("image"); ?>

            <?php echo Form::file("image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->image!=""): ?>
                     <img src="<?php echo e(asset(($data->image))); ?>" width="200" > <br>
                     
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input custom-control-input-danger" name="remove_image" value="yes" type="checkbox" id="remove_image" >
                        <label for="remove_image" class="custom-control-label">Remove  Image</label>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            
            <?php echo Form::label("email"); ?>

            <?php echo Form::email("email",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email")); ?></span>
            
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            
            <?php echo Form::label("stay_date"); ?>

            <?php echo Form::text("stay_date",null,["class"=>"form-control datepicker"]); ?>

            <span class="text-danger"><?php echo e($errors->first("stay_date")); ?></span>
            
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            
            <?php echo Form::label("score"); ?>

            <?php echo Form::selectRange("score",1,5,null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("score")); ?></span>
            
        </div>
    </div>
 
    <div class="col-md-3 d-none">
        <div class="form-group">
            
            <?php echo Form::label("Property"); ?>

            <?php echo Form::select("property_id",ModelHelper::getProperptySelectList(),null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("property_id")); ?></span>
            
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            
            <?php echo Form::label("status"); ?>

            <?php echo Form::select("status",["true"=>"true","false"=>"false"],null,["class"=>"form-control","required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("status")); ?></span>
            
        </div>
    </div>
 
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("message"); ?>

            <?php echo Form::textarea("message",null,["class"=>"form-control","rows"=>2]); ?>

            <span class="text-danger"><?php echo e($errors->first("message")); ?></span>
        </div>
    </div>

  


</div>
<?php /**PATH /home/hiddencharmsuites/htdocs/www.hiddencharmsuites.com/projects/resources/views/admin/testimonials/form.blade.php ENDPATH**/ ?>