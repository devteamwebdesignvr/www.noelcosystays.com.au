<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("property"); ?>

            <?php echo Form::select("property_id",ModelHelper::getProperptySelectList(),null,["class"=>"form-control","required","placeholder"=>"Choose Property","id"=>"property-selector"]); ?>

            <span class="text-danger"><?php echo e($errors->first("property_id")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("checkin"); ?>

            <?php echo Form::text("checkin",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtFrom","placeholder"=>"Check in","class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("checkin")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("checkout"); ?>

            <?php echo Form::text("checkout",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtTo","placeholder"=>"Check Out","class"=>"form-control lst" ]); ?>

            <span class="text-danger"><?php echo e($errors->first("checkout")); ?></span>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label("adults"); ?>

            <?php echo Form::selectRange("adults",0,100,null,["class"=>"form-control","required","id"=>"adult_data"]); ?>

            <span class="text-danger"><?php echo e($errors->first("adults")); ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label("child"); ?>

            <?php echo Form::selectRange("child",0,100,null,["class"=>"form-control","id"=>"child_data"]); ?>

            <span class="text-danger"><?php echo e($errors->first("child")); ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label("pets"); ?>

            <?php echo Form::selectRange("pets",0,100,null,["class"=>"form-control","id"=>"pet_data"]); ?>

            <span class="text-danger"><?php echo e($errors->first("pets")); ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label("extra_discount"); ?>

            <?php echo Form::number("extra_discount",null,["class"=>"form-control","id"=>"extra-discount"]); ?>

            <span class="text-danger"><?php echo e($errors->first("extra_discount")); ?></span>
        </div>
    </div>
</div>
<div class="row" id="pricedata-gaurav">
    
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("name"); ?>

            <?php echo Form::text("name",null,["class"=>"form-control","required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("name")); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("mobile"); ?>

            <?php echo Form::text("mobile",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("mobile")); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo Form::label("email"); ?>

            <?php echo Form::email("email",null,["class"=>"form-control","required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email")); ?></span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("message"); ?>

            <?php echo Form::textarea("message",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("message")); ?></span>
        </div>
    </div>
</div>
<?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/admin/booking-enquiries/form.blade.php ENDPATH**/ ?>