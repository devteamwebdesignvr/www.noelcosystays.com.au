@php
    $start_date=$main_data["start_date"];
    $end_date=$main_data["end_date"];
    $now = strtotime($start_date); 
    $your_date = strtotime($end_date);
    $datediff =  $your_date-$now;
    $day= ceil($datediff / (60 * 60 * 24));
    $total_night=$day;
    $total_guests=$main_data["adults"]+$main_data["childs"];
    $base_price=0;
@endphp
@foreach($main_data['data']['components'] as $c)
    @if($c['isIncludedInTotalPrice']==1)
        @if($c['name']=="baseRate")
            @php
                $base_price=$c['total']; break;
            @endphp
        @endif
    @endif
@endforeach
<div class="row">
    <div class="col-md-6">
        <span style="font-size:13px;font-family:sans-serif;">{!!  $main_data['currency'] !!} {{ number_format($base_price/$total_night,2)  }} X {{ $total_night }} Nights</span>
    </div>
    <div class="col-md-6">
       {!! $main_data['currency'] !!}  {{number_format($base_price,2)}}
    </div>
</div>
@foreach($main_data['data']['components'] as $c)
    @if($c['isIncludedInTotalPrice']==1)
        @if($c['name']!="baseRate")
		   <div class="row">
                <div class="col-md-6">
                    <span style="font-size:13px;">{{$c['title']}}</span>
                </div>
                <div class="col-md-6" style="font-family:sans-serif;">
                   {!! $main_data['currency'] !!} {{number_format($c['total'],2)}}
                </div>
            </div>
         @endif
   @endif
@endforeach
<div class="row">
    <div class="col-md-6">
        <span style="font-size:13px;">Total</span>
    </div>
    <div class="col-md-6" style="font-family:sans-serif;">
       {!! $main_data['currency'] !!} {{number_format($main_data['data']['totalPrice'],2)}}
    </div>
</div>
@foreach($main_data['data']['components'] as $c)
    @if($c['isIncludedInTotalPrice']==0)
        @if($c['name']!="baseRate")
		   <div class="row">
                <div class="col-md-6">
                    <span style="font-size:13px;">{{$c['title']}}</span>
                </div>
                <div class="col-md-6" style="font-family:sans-serif;">
                   {!! $main_data['currency'] !!} {{number_format($c['total'],2)}}
                </div>
            </div>
         @endif
   @endif
@endforeach