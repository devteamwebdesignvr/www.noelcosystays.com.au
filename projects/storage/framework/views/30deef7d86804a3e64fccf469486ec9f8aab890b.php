<?php $__env->startSection('title', 'Admin'); ?>
<?php
    $name = 'Booking Enquiries';
    $route = 'booking-enquiries';
?>
<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark"><?php echo e($name); ?> Management</h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <?php
                        $addbar = ['name' => $name, 'add-data' => false, 'add-name' => 'Add ' . Str::singular($name), 'add-anchor' => route($route . '.create')];
                    ?>
                    <?php echo $__env->make('admin.common.add-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card  ">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo e($name); ?> Listing</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="data-table-gaurav" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Checkin</th>
                                    <th>Checkout</th>
                                    <th>Booking-id</th>
                                    <th>Property</th>
                                    <th>Customer</th>
                                    <th>Guests</th>
                                    <th>Nights</th>
                                    <th>Amount</th>
                                    <th>Request of Date</th>
                                    <th>Booking Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sno = 1;
                                    $payment_currency = ModelHelper::getDataFromSetting('payment_currency');
                                ?>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($sno++); ?></td>
                                        <td><?php echo e(date('F jS, Y', strtotime($client->checkin))); ?></td>
                                        <td><?php echo e(date('F jS, Y', strtotime($client->checkout))); ?></td>
                                        <td><?php echo e($client->id); ?></td>
                                        <td><?php echo e(App\Models\HostAway\HostAwayProperty::find($client->property_id)->name ?? $client->property_id); ?></td>
                                        <td>
                                            <?php echo e($client->name); ?>

                                            <br>
                                            <?php echo e($client->email); ?>

                                        </td>
                                        <td><?php echo e($client->total_guests); ?></td>
                                        <td><?php echo e($client->total_night); ?></td>
                                        <td><?php echo $payment_currency; ?><?php echo e($client->total_amount); ?></td>
                                        <td><?php echo e(date('F jS, Y', strtotime($client->created_at))); ?></td>
                                        <td><?php echo Helper::getBookingStatus($client->booking_status, $client->id); ?></td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-outline-primary btn-sm raw-margin-right-8"
                                                data-toggle="modal" data-target="#myModal<?php echo e($client->id); ?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <?php if($client->booking_status != 'booking-cancel'): ?>
                                                <?php if($client->booking_status != 'booking-confirmed'): ?>
                                                    <a href="<?php echo route($route . '.edit', [$client->id]); ?>"
                                                        class="btn btn-outline-success btn-sm raw-margin-right-8 d-none "><i
                                                            class="fa fa-pencil-alt"></i> </a>
                                                <?php endif; ?>
                                                <?php if($client->booking_status == 'booking-confirmed'): ?>
                                                    <form method="post" action="<?php echo route($route . '.destroy', [$client->id]); ?>"
                                                        style="display: inline-block;">
                                                        <?php echo csrf_field(); ?>

                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-sm raw-margin-right-8"
                                                            onclick="return confirm('Are you sure you want to cancel this <?php echo e($name); ?>?')">
                                                            Cancel Booking </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form method="post" action="<?php echo route('booking-requests.destroyData', [$client->id]); ?>"
                                                        style="display: inline-block;">
                                                        <?php echo csrf_field(); ?>

                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-sm raw-margin-right-8"
                                                            onclick="return confirm('Are you sure you want to Delete this <?php echo e($name); ?>?')">
                                                            <i class="fa fa-times"></i> Delete Booking </button>
                                                    </form>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <form method="post" action="<?php echo route('booking-requests.destroyData', [$client->id]); ?>"
                                                    style="display: inline-block;">
                                                    <?php echo csrf_field(); ?>

                                                    <?php echo method_field('DELETE'); ?>

                                                    <button type="submit"
                                                        class="btn btn-outline-danger btn-sm raw-margin-right-8"
                                                        onclick="return confirm('Are you sure you want to Delete this <?php echo e($name); ?>?')">
                                                        <i class="fa fa-times"></i> Delete Booking </button>
                                                </form>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
    <?php $data123=$data; ?>
    <?php $__currentLoopData = $data123; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- The Modal -->
        <div class="modal" id="myModal<?php echo e($client->id); ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Booking Detail</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php
                            $data = $client->toArray();
                            $property = App\Models\HostAway\HostAwayProperty::find($client->property_id);
                        ?>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th colspan="4"><strong>Property Detail </strong></th>
                                </tr>
                                <tr>
                                    <th>Request ID</th>
                                    <td><?php echo e($data['request_id']); ?></td>
                                    <th>Booking Date</th>
                                    <td><?php echo e(date('F jS, Y', strtotime($data['created_at']))); ?></td>
                                </tr>
                                <tr>
                                    <th>Booking Status</th>
                                    <td><?php echo Helper::getBookingStatus($client->booking_status, $client->id); ?></td>
                                    <td><strong>Property Name :</strong></td>
                                    <td><?php echo e($property->name ?? $client->property_id); ?></td>
                                </tr>
                                <tr class="d-none">
                                    <th colspan="3">Rental Aggrement</th>
                                    <th><?php echo e($data['rental_aggrement_status']); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="3">How did you hear about us?</th>
                                    <th><?php echo e($data['how_did_you_hear_about_us']); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"><strong>User Detail </strong></th>
                                </tr>
                                <tr>
                                    <td><strong>Name :</strong></td>
                                    <td><?php echo e($data['name']); ?></td>
                                    <td><strong>Email :</strong></td>
                                    <td><?php echo e($data['email']); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Mobile:</strong></td>
                                    <td colspan="2"><?php echo e($data['mobile']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th colspan="5"><strong>Booking Detail </strong></th>
                                </tr>
                                <tr>
                                    <th><strong>Checkin :</strong></th>
                                    <th><strong>Checkout :</strong></th>
                                    <th><strong>Total Guest :</strong></th>
                                    <th><strong>Total Night :</strong></th>
                                    <th><strong> Amount :</strong></th>
                                </tr>
                                <tr>
                                    <td><?php echo e($data['checkin']); ?></td>
                                    <td><?php echo e($data['checkout']); ?></td>
                                    <td><?php echo e($data['total_guests']); ?> (<?php echo e($data['adults']); ?> Adults, <?php echo e($data['child']); ?>  Child)</td>
                                    <td><?php echo e($data['total_night']); ?></td>
                                    <td>-</td>
                                </tr>
                                <?php if($data['financeField']): ?>
                                <?php $main_data=(json_decode($data['financeField'],true));  ?>
                                    <?php $__currentLoopData = $main_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($c['type']!="other"): ?>
                                               <tr>
                                                  <td colspan="4"><?php echo e($c['title']); ?></td>
                                                  <td align="left">  <?php echo $payment_currency; ?><?php echo e(number_format($c['total'],2)); ?></td>
                                              </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                <tr>
                                    <td colspan="4"><strong>Total Price</strong></td>
                                    <td align="left"><?php echo $payment_currency; ?><?php echo e(number_format($data['total_amount'], 2)); ?></td>
                                </tr>

                                <?php if($data['financeField']): ?>
                                <?php $main_data=(json_decode($data['financeField'],true));  ?>
                                    <?php $__currentLoopData = $main_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($c['type']=="other"): ?>
                                               <tr>
                                                  <td colspan="4"><?php echo e($c['title']); ?><sub>(Paid via Guest Portal)</sub></td>
                                                  <td align="left">  <?php echo $payment_currency; ?><?php echo e(number_format($c['total'],2)); ?></td>
                                              </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <?php if($client->booking_status != 'booking-cancel'): ?>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <a href="<?php echo route($route . '.edit', [$client->id]); ?>"
                                class="btn btn-outline-success btn-sm raw-margin-right-8 d-none"><i
                                    class="fa fa-pencil-alt"></i> </a>
                            <?php if($client->booking_status == 'booking-confirmed'): ?>
                                <form method="post" action="<?php echo route($route . '.destroy', [$client->id]); ?>" style="display: inline-block;">
                                    <?php echo csrf_field(); ?>

                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit" class="btn btn-outline-danger btn-sm raw-margin-right-8"
                                        onclick="return confirm('Are you sure you want to cancel this <?php echo e($name); ?>?')">
                                        Cancel Booking
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>
        $("#data-table-gaurav").DataTable({"lengthMenu": [[50, -1],[50, "All"]]});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/webdesignvrvr-rupa/htdocs/rupa.webdesignvrvr.com/projects/resources/views/admin/booking-enquiries/index.blade.php ENDPATH**/ ?>