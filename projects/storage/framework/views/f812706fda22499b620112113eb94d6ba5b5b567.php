<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo Form::label("email_type"); ?>

            <?php echo Form::text("email_type",null,["class"=>"form-control","id"=>"email_type"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email_type")); ?></span>
        </div>
    </div>
   
    <div class="col-md-6">
        <div class="form-group">
            
            <?php echo Form::label("email_subject"); ?>

            <?php echo Form::text("email_subject",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email_subject")); ?></span>
            
        </div>
    </div>
   
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("email_body"); ?>

            <?php echo Form::textarea("email_body",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email_body")); ?></span>
        </div>
    </div>


</div><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/admin/email-templetes/form.blade.php ENDPATH**/ ?>