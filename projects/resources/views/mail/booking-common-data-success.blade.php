

<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px;">
	<tbody>
		<tr>
			<th colspan="5" align="center" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000;" valign="top"><strong>Booking Detail </strong></th>
		</tr>

		<tr>
			<th align="left" style="padding: 10px; background: #C81D1E; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>Checkin :</strong></th>
			<th align="left" style="padding: 10px; background: #C81D1E; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>Checkout :</strong></th>
			<th align="left" style="padding: 10px; background: #C81D1E; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>Total Guest :</strong></th>
			<th align="left" style="padding: 10px; background: #C81D1E; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>Total Night :</strong></th>
			<th align="center" style="padding: 10px; background: #C81D1E; color: #fff; text-align: center; font-size: 15px;" valign="top"><strong>Gross Amount :</strong></th>
			
		</tr>
		<tr>
			<td align="left" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{{$data['checkin'] }}</td>
			<td align="left" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{{$data['checkout'] }}</td>
			<td align="left" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{{$data['total_guests'] }} ({{$data['adults']}} Adults, {{$data['child']}} Child)</td>
			<td align="left" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{{$data['total_night'] }}</td>
			<td align="center" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{!! $setting_data['payment_currency'] !!}{{number_format($data['gross_amount'],2) }}</td>
		</tr>
		
		
		      @php
                $main_data=(json_decode($data['amount_data'],true));
            @endphp
        @foreach($main_data['data']['components'] as $c)
            @if($c['isIncludedInTotalPrice']==1)
                @if($c['name']!="baseRate")
        


				<tr>
					<td align="left" colspan="4" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top"><strong>{{$c['title']}} :</strong></td>
					<td align="center" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{!! $setting_data['payment_currency'] !!}{{number_format($c['total'],2)}}</td>
				</tr>

               @endif
           @endif
       @endforeach
             


		<tr>
			<td align="left" colspan="4" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top"><strong>Total Price <span style="color:green;">(Paid)</span>:</strong></td>
			<td align="center" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{!! $setting_data['payment_currency'] !!}{{number_format($main_data['data']['totalPrice'],2)}}</td>
		</tr>

       @foreach($main_data['data']['components'] as $c)
            @if($c['isIncludedInTotalPrice']==0)
            

			<tr>
				<td align="left" colspan="4" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-right:0px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top"><strong>{{$c['title']}} :</strong></td>
				<td align="center" style="padding: 10px; font-weight: bold; font-size: 15px; color:#000; border: 1px solid #C81D1E; border-bottom:0px solid #C81D1E;" valign="top">{!! $setting_data['payment_currency'] !!}{{number_format($c['total'],2)}}</td>
			</tr>
           @endif
       @endforeach
		
	



	</tbody>
</table>