<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("Page"); ?>

            <?php echo Form::select("type",ModelHelper::getPageSelectList(),null,["class"=>"form-control","required","placeholder"=>"Choose Page"]); ?>

            <span class="text-danger"><?php echo e($errors->first("type")); ?></span>
        </div>
    </div>
    <div class="col-md-4 d-none">
        <div class="form-group">
            <?php echo Form::label("link"); ?>

            <?php echo Form::text("thumbnail",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("thumbnail")); ?></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("image"); ?>

            <?php echo Form::file("image",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("image")); ?></span>
             <?php if(isset($data)): ?>
                <?php if($data->image!=""): ?>
                     <img src="<?php echo e(asset(($data->image))); ?>" width="200" /> 
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php /**PATH /home/webdesignvrvr-lisa/htdocs/lisa.webdesignvrvr.com/projects/resources/views/admin/galleries/form.blade.php ENDPATH**/ ?>