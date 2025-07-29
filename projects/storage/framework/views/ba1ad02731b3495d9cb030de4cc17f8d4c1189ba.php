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
            
            <?php echo Form::label("email"); ?>

            <?php echo Form::email("email",null,["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("email")); ?></span>
            
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            
            <?php echo Form::label("password"); ?>

            <?php echo Form::password("password",["class"=>"form-control"]); ?>

            <span class="text-danger"><?php echo e($errors->first("password")); ?></span>
            
        </div>
    </div>
   

</div>

<?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com/projects/resources/views/admin/users/form.blade.php ENDPATH**/ ?>