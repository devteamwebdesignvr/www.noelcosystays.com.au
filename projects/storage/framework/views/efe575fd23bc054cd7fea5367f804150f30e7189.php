<title></title>
<meta http–equiv=“Content-Type” content=“text/html; charset=UTF-8” /><meta http–equiv=“X-UA-Compatible” content=“IE=edge” /><meta name=“viewport” content=“width=device-width, initial-scale=1.0 “ />
<style type="text/css">@media screen {
	@font-face {
		font-family: 'Lato';
		font-style: normal;
		font-weight: 400;
		src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
	}
	body {margin:0px !important; padding:0px !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none;font-family: 'Poppins', sans-serif;}
	table {border-spacing:0; mso-table-lspace:0pt; mso-table-rspace:0pt;}
	table td {border-collapse: collapse;}
	strong {font-weight: bold !important;}
	td img {-ms-interpolation-mode:bicubic; display:block; width:auto; max-width:auto; height:auto; margin:auto;display:block!important;border:0px!important;}
	td a {text-decoration:none !important;}
    b, strong{font-weight: bold; }
    td{border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; }
</style>
<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:90%; margin: auto;">
	<tbody>
		<tr>
			<td align="center" bgcolor="#ffffff" style="padding:15px;" valign="top">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td align="center" valign="top">
								<div><span style="display: block; font-size: 30px; font-weight: 600; margin: 20px 0 10px 0; color: #2f75b5; font-family: 'Poppins', sans-serif;">Booking Confirmation</span></div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left" bgcolor="#f9f9f9" style="padding:20px;" valign="top">
				<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td align="left" valign="top">
							<h4 style="font-size: 17px; color: #000; font-weight: 600; margin-bottom: 0px; margin-top: 0px; font-family: 'Poppins', sans-serif;">Hey <?php echo e($data['name']); ?>,</h4>
							<p style=" font-size: 15px; color: #000; line-height: 24px; font-weight: 400; margin: 0 0 15px 0; text-align: left; font-family: 'Poppins', sans-serif;">Congratulations, Your booking is confirmed. Please find details below.</p>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
								<tbody>
									<tr>
									  <th  align="left" style="padding: 10px; background: #2f75b5; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>PROPERTY NAME  </strong></th>
                                      <th  align="left" style="padding: 10px; background: #2f75b5; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>CHECKIN </strong></th>
                                      <th  align="left" style="padding: 10px; background: #2f75b5; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>CHECKOUT </strong></th>
									</tr>
									<tr>
										<td align="left" style="padding: 10px; border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; font-family: 'Poppins', sans-serif; color:#000; border-right:0px solid #2f75b5;" valign="top"><strong><?php echo e($property->name); ?></strong></td>
										<td align="right" style="padding: 10px; border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; font-family: 'Poppins', sans-serif; color:#000;" valign="top"><?php echo e($data['checkin']); ?></td>
                                      <td align="right" style="padding: 10px; border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; font-family: 'Poppins', sans-serif; color:#000;" valign="top"><?php echo e($data['checkout']); ?></td>
									</tr>
								</tbody>
							</table>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<th colspan="3" align="center" style="padding: 10px; background: #2f75b5; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>GUEST DETAILS </strong></th>
									</tr>
                                    <tr>
									  <th  align="left" style="padding: 10px; background: #bdd7ee; color: #fff; font-size: 15px; color:#000;" valign="top"><strong> NAME </strong></th>
                                      <th  align="left" style="padding: 10px; background: #bdd7ee; color: #fff; font-size: 15px; color:#000;" valign="top"><strong>EMAIL </strong></th>
                                      <th  align="left" style="padding: 10px; background: #bdd7ee; color: #fff;  font-size: 15px; color:#000;" valign="top"><strong>PHONE NUMBER </strong></th>
									</tr>
									<tr>
										<td align="left" style="padding: 10px; border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; color:#000; border-bottom:0px solid #2f75b5;" valign="top"><?php echo e($data['name']); ?></td>
                                        <td align="left" style="padding: 10px; border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; color:#000; border-bottom:0px solid #2f75b5;" valign="top"><?php echo e($data['email']); ?></td>
										<td align="right" style="padding: 10px; border: 1px solid #2f75b5; font-weight: bold; font-size: 15px; color:#000; border-bottom:0px solid #2f75b5;" valign="top"><?php echo e($data['mobile']); ?></td>
                                  </tr>
									
								</tbody>
							</table>
                              <?php if(isset($data['extra_guesty_information'])): ?> 
                              <!---<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<th colspan="4" align="center" style="padding: 10px; background: #2f75b5; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>ADDITIONAL INFO</strong></th>
									</tr>
                                    <tr>
									  <th  align="left" style="padding: 10px; background: #bdd7ee; color: #fff; text-align: center; font-size: 15px; color:#000;" valign="top"><strong> DATE </strong></th>
                                      <th  align="center" style="padding: 10px; background: #bdd7ee; color: #fff; text-align: center; font-size: 15px; color:#000;" valign="top"><strong>NUMBER OF GUESTS (Including Additional Guest)</strong></th>
                                                                            <th  align="center" style="padding: 10px; background: #bdd7ee; color: #fff; text-align: center; font-size: 15px; color:#000;" valign="top"><strong>EXTRA PERSON FEE (Max Guest: <?php echo e($property->max_guest); ?>)  </strong></th>
                                      <th  align="center" style="padding: 10px; background: #bdd7ee; color: #fff; text-align: center; font-size: 15px; color:#000;" valign="top"><strong> TOTAL ADDITIONAL  CHARGE</strong></th>
									</tr>
									<?php $__currentLoopData = json_decode($data['extra_guesty_information'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                      <td align="right"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; " valign="top"><?php echo e(date('d F-Y', strtotime($c['date']))); ?></td>
                                      <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; " valign="top"><?php echo e($c['total_guest']); ?></td>
                                        <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; " valign="top"><?php if($c['extra_guest']>0): ?> <?php echo e($c['extra_guest']); ?> x <?php echo $payment_currency; ?><?php echo e($c['per_person_amount']); ?> <?php endif; ?></td>
                                      <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; " valign="top"><?php if($c['extra_guest']>0): ?>  <?php echo $payment_currency; ?><?php echo e($c['amount']); ?> <?php endif; ?></td>
                                    </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									
								</tbody>
							</table>  --->
                            <?php endif; ?>
                              
                              
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px;">
								<tbody>
									<tr>
										<th colspan="5" align="center"  style="padding: 10px; background: #2f75b5; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>BOOKING DETAIL  </strong></th>
									</tr>
									<tr>
										<th align="center" style="padding: 10px; background: #bdd7ee; color: #000; text-align: center; font-size: 15px;" valign="top"><strong>SUMMARY :</strong></th>
										<th align="left" style="padding: 10px; background: #bdd7ee; color: #000; text-align: center; font-size: 15px;" valign="top"><strong>AMOUNT :</strong></th>
									</tr>
									
	                                   	<?php $main_data=(json_decode($data['amount_data'],true)); ?>
	                                    <tr>
	                                        <td align="left" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">Base Rate (Includes up to <?php echo e($property->guestsIncluded); ?> guests)</td>
	                                        <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top"><?php echo $payment_currency; ?><?php echo e(number_format($booking->gross_amount,2)); ?></td>
	                                    </tr>	                                   
	                                    <?php if(isset($main_data['pricePerExtraPerson']) && $main_data['pricePerExtraPerson'] > 0): ?>
                                            <tr>
                                                <td align="left" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">
                                                    Extra Person Fee (Max Guest: <?php echo e($data['max_guest_data']); ?>)

                                                    <?php if($data['extra_guesty_information']): ?>
                                                        <?php $extra_guesty_information = json_decode($data['extra_guesty_information'], true); ?>
                                                        <br>
                                                        <?php $__currentLoopData = $extra_guesty_information; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <?php echo e($c['name']); ?> (<?php echo e($c['date']); ?>) — <?php echo e($c['extra_guest']); ?> × <?php echo $payment_currency; ?><?php echo e(number_format($c['per_person_amount'], 2)); ?> = <?php echo $payment_currency; ?><?php echo e(number_format($c['amount'], 2)); ?><br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">
                                                    <?php echo $payment_currency; ?><?php echo e(number_format($main_data['pricePerExtraPerson'], 2)); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>

	                                    <?php if(isset($main_data['cleaningFee'])): ?>
	                                        <?php if($main_data['cleaningFee']>0): ?>
	                                            <tr>
	                                                <td align="left"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">Cleaning Fee</td>
	                                                <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top"><?php echo $payment_currency; ?><?php echo e(number_format($main_data['cleaningFee'],2)); ?></td>
	                                            </tr>
	                                        <?php endif; ?>
	                                    <?php endif; ?>
	                                    <?php if(isset($main_data['checkinFee'])): ?>
	                                        <?php if($main_data['checkinFee']>0): ?>
	                                            <tr>
	                                                <td align="left"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">Checkin Fee</td>
	                                                <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top"><?php echo $payment_currency; ?><?php echo e(number_format($main_data['checkinFee'],2)); ?></td>
	                                            </tr>
	                                        <?php endif; ?>
	                                    <?php endif; ?>
	                                    <?php if(isset($main_data['discount'])): ?>
	                                        <?php if($main_data['discount']>0): ?>
	                                            <tr>
	                                                <td align="left"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">Discount</td>
	                                                <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top">- <?php echo $payment_currency; ?><?php echo e(number_format($main_data['discount'],2)); ?></td>
	                                            </tr>
	                                        <?php endif; ?>
	                                    <?php endif; ?>
	                                    <?php if(isset($main_data['tax'])): ?>
	                                        <?php $__currentLoopData = $main_data['tax']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                        <?php if($value>0): ?>
	                                            <tr>
	                                                <td align="left"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top"><?php echo e(ucwords($title)); ?></td>
	                                                <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-bottom:0px solid #2f75b5;" valign="top"> <?php echo $payment_currency; ?><?php echo e(number_format($value,2)); ?></td>
	                                            </tr>
	                                        <?php endif; ?>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                    <?php endif; ?>
	                                   	<tr>
	                                       <td align="left"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5;" valign="top">Total Price</td>
	                                       <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5;" valign="top"><?php echo $payment_currency; ?><?php echo e(number_format($booking->total_amount,2)); ?></td>
	                                   	</tr>
	                                    <?php $amounts=json_decode($data['amount_data_hostaway'],true);  ?>
	                                    <?php if($amounts): ?>
	                                        <?php $__currentLoopData = $amounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                        <tr>
	                                            <td align="left"  style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-right:0px solid #2f75b5; border-top:0px solid #2f75b5;" valign="top"><?php echo e($c['title']); ?> <?php echo e(date('d,F Y',strtotime($c['scheduledDate']))); ?></td>
	                                            <td align="right" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #2f75b5; border-top:0px solid #2f75b5;" valign="top"><?php echo $payment_currency; ?><?php echo e(number_format($c['amount'],2)); ?></td>
	                                        </tr>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                    <?php endif; ?>
									</tbody>
								</table>
	     						
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center" bgcolor="#ffffff" style="padding:15px;" valign="top">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td align="center" valign="top">
								<div><span style="display: block; font-size: 16px; font-weight: 600; margin: 0px 0 10px 0; color: #000;">Thanks for reading!</span></div>
								<p style=" font-size: 14px; color: #000; line-height: 24px; font-weight: 400; margin: 0 0 5px 0;"><?php echo ModelHelper::getDataFromSetting('mail_footer'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table><?php /**PATH /home/noelcosystays/htdocs/www.noelcosystays.com.au/projects/resources/views/mail/booking-first-customer-hostaway.blade.php ENDPATH**/ ?>