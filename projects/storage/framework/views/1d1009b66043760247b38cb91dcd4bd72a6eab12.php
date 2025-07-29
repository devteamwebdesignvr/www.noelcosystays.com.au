<div class="row d-none">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("type"); ?>

            <?php echo Form::text("type",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("type")); ?></span>
        </div>
    </div>

   
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("question"); ?>

            <?php echo Form::textarea("question",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("question")); ?></span>
        </div>
    </div>



</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo Form::label("answer"); ?>

            <?php echo Form::textarea("answer",null,["class"=>"form-control","rows"=>"2"]); ?>

            <span class="text-danger"><?php echo e($errors->first("answer")); ?></span>
        </div>
    </div>
 


</div><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/admin/faqs/form.blade.php ENDPATH**/ ?>