<?php
    $start_date=$main_data["start_date"];
    $end_date=$main_data["end_date"];
    $now = strtotime($start_date); 
    $your_date = strtotime($end_date);
    $datediff =  $your_date-$now;
    $day= ceil($datediff / (60 * 60 * 24));
    $total_night=$day;
    $total_guests=$main_data["adults"]+$main_data["childs"];
    $base_price=0;
?>
<?php $__currentLoopData = $main_data['data']['components']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($c['isIncludedInTotalPrice']==1): ?>
        <?php if($c['name']=="baseRate"): ?>
            <?php
                $base_price=$c['total']; break;
            ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="row">
    <div class="col-md-6">
        <span style="font-size:13px;"><?php echo $setting_data['payment_currency']; ?> <?php echo e(number_format($base_price/$total_night,2)); ?> X <?php echo e($total_night); ?> Nights</span>
    </div>
    <div class="col-md-6">
       <?php echo $setting_data['payment_currency']; ?>  <?php echo e(number_format($base_price,2)); ?>

    </div>
</div>
<?php $__currentLoopData = $main_data['data']['components']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($c['isIncludedInTotalPrice']==1): ?>
        <?php if($c['name']!="baseRate"): ?>
		   <div class="row">
                <div class="col-md-6">
                    <span style="font-size:13px;"><?php echo e($c['title']); ?></span>
                </div>
                <div class="col-md-6">
                   <?php echo $setting_data['payment_currency']; ?> <?php echo e(number_format($c['total'],2)); ?>

                </div>
            </div>
         <?php endif; ?>
   <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="row">
    <div class="col-md-6">
        <span style="font-size:13px;">Total</span>
    </div>
    <div class="col-md-6">
       <?php echo $setting_data['payment_currency']; ?> <?php echo e(number_format($main_data['data']['totalPrice'],2)); ?>

    </div>
</div>
<?php $__currentLoopData = $main_data['data']['components']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($c['isIncludedInTotalPrice']==0): ?>
        <?php if($c['name']!="baseRate"): ?>
		   <div class="row">
                <div class="col-md-6">
                    <span style="font-size:13px;"><?php echo e($c['title']); ?></span>
                </div>
                <div class="col-md-6">
                   <?php echo $setting_data['payment_currency']; ?> <?php echo e(number_format($c['total'],2)); ?>

                </div>
            </div>
         <?php endif; ?>
   <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/webdesignvrvr-rupa/htdocs/rupa.webdesignvrvr.com/projects/resources/views/front/property/ajax-gaurav-data-get-quote.blade.php ENDPATH**/ ?>