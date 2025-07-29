<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("property"); ?>

            <?php echo Form::select("property_id",ModelHelper::getHostAwayPropertySelect(),null,["class"=>"form-control","required","placeholder"=>"Choose Property","id"=>"property-selector"]); ?>

            <span class="text-danger"><?php echo e($errors->first("property_id")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("checkin"); ?>

            <?php echo Form::text("start_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtFrom","placeholder"=>"Check in","class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("start_date")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("checkout"); ?>

            <?php echo Form::text("end_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtTo","placeholder"=>"Check Out","class"=>"form-control lst" ]); ?>

            <span class="text-danger"><?php echo e($errors->first("end_date")); ?></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("name"); ?>

            <?php echo Form::text("name",null,["class"=>"form-control","required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("name")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("mobile"); ?>

            <?php echo Form::text("mobile",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("mobile")); ?></span>
        </div>
    </div> 
   <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("guests"); ?>

            <?php echo Form::number("guests",null,["class"=>"form-control","id" =>"guests"]); ?>

            <span class="text-danger"><?php echo e($errors->first("guests")); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("email"); ?>

            <?php echo Form::email("email",null,["class"=>"form-control","required"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email")); ?></span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("How did you hear about us?"); ?>

            <?php echo Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"form-control","placeholder"=>"--Select--"]); ?>

            <span class="text-danger"><?php echo e($errors->first("how_did_you_hear_about_us")); ?></span>
        </div>
    </div>
    <div class="col-md-12 d-none">
        <div class="form-group">
            <?php echo Form::label("message"); ?>

            <?php echo Form::textarea("message",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("message")); ?></span>
        </div>
    </div>
   
</div>
<?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/admin/booking_enquiry_home/form.blade.php ENDPATH**/ ?>