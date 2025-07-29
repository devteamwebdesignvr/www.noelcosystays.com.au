@extends("front.layouts.master")
@section("title",$data->meta_title)
@section("keywords",$data->meta_keywords)
@section("description",$data->meta_description)

@section("container")

   @php
        $name=$data->name;
        $bannerImage=asset('front/images/internal-banner.webp');
        $amount=$booking['gross_amount'];
  $payment_currency= $setting_data['payment_currency'];

    @endphp
    
    
                        @php $amount=$booking['gross_amount'];; @endphp
               
	<!-- start banner sec -->
   

    <section class="page-title" style="background-image: url({{$bannerImage}});">
        <div class="auto-container">
            <h1 data-aos="zoom-in" data-aos-duration="1500" class="aos-init aos-animate">{{$name}}</h1>
            <div class="checklist">
                <p>
                    <a href="{{url('/')}}" class="text"><span>Home</span></a>
                    <a class="g-transparent-a">{{$name}}</a>
                </p>
            </div>
        </div>
    </section>

	<!-- start about section -->
        
      <!-- About Section -->
 
      <section class="About-sec">

        <div class="container">

            <div class="row">

                <div class="table-box">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td align="left" valign="top" style="border:0px solid;">
                        
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th colspan="2" align="center" style="padding: 10px;" valign="top"><strong>Property Detail </strong></th>
                                    </tr>

                                    <tr>
                                        <td align="left" style="padding: 10px;" valign="top"><strong>Property Name :</strong></td>
                                        <td align="left" style="padding: 10px;" valign="top">{{$property->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th colspan="5" align="center" style="padding: 10px;" valign="top" class="book"><strong>Booking Detail </strong></th>
                                    </tr>

                                    <tr>
                                        <th align="left" style="padding: 10px;" valign="top"><strong>Checkin :</strong></th>
                                        <th align="left" style="padding: 10px;" valign="top"><strong>Checkout :</strong></th>
                                        <th align="left" style="padding: 10px;" valign="top"><strong>Total Guest :</strong></th>
                                        <th align="left" style="padding: 10px;" valign="top"><strong>Total Night :</strong></th>
                                        <th align="right" style="padding: 10px;" valign="top"><strong>Gross Amount :</strong></th>
                                        
                                    </tr>
                                    <tr>
                                        <td align="left" style="padding: 10px;" valign="top">{{$booking['checkin'] }}</td>
                                        <td align="left" style="padding: 10px;" valign="top">{{$booking['checkout'] }}</td>
                                        <td align="left" style="padding: 10px;" valign="top">{{$booking['total_guests'] }} ({{$booking['adults']}} Adults, {{$booking['child']}} Child)</td>
                                        <td align="left" style="padding: 10px;" valign="top">{{$booking['total_night'] }}</td>
                                        <td align="right" style="padding: 10px;" valign="top">{!! $payment_currency !!}{{number_format($booking['gross_amount'],2) }}</td>
                                    </tr>
                                          @php
                                        $main_data=(json_decode($booking['amount_data'],true));
                                    @endphp
                                            @foreach($main_data['data']['components'] as $c)
                                                @if($c['isIncludedInTotalPrice']==1)
                                                    @if($c['name']!="baseRate")
                                                    <tr>
                                                       <td colspan="4">{{$c['title']}}</td>
                                                       <td align="right">{!! $payment_currency !!}{{number_format($c['total'],2)}}</td>
                                                   </tr>
                                                   @endif
                                               @endif
                                           @endforeach
                                           <tr>
                                               <td colspan="4">Total Price</td>
                                               <td align="right">{!! $payment_currency !!}{{number_format($main_data['data']['totalPrice'],2)}}</td>
                                           </tr>

                                           @foreach($main_data['data']['components'] as $c)
                                                @if($c['isIncludedInTotalPrice']==0)
                                                <tr>
                                                   <td colspan="4">{{$c['title']}} <sub>(Not Include)</sub></td>
                                                   <td align="right">{!! $payment_currency !!}{{number_format($c['total'],2)}}</td>
                                               </tr>
                                               @endif
                                           @endforeach

                                </tbody>
                            </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
</div>
                
    <div class="row">
        <div class="col-md-12 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Card Details</h3>
                      
                    </div>                    
                </div>
                <div class="panel-body">
  

                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    <style>
                        .hide{
                            display:none;
                        }
                    </style>
                    <div class="error hide" >
                        <div class="alert alert-danger"></div>
                    </div>
  
                    <form role="form" action="{{ route('stripe.post',$booking['id']) }}" method="post" class="require-validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ $key['stripe_publish_key'] }}"
                                                    id="payment-form">
                        @csrf
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
  
                        <input type="hidden" name="amount" value="{{ round($amount,2) }}">
  
                        <div class="row mt-4">
                            <div class="col-xs-12">
                                <!--<label>&nbsp;<br></label>-->
                                <button class="btn btn-primary btn-lg btn-block main-btn" type="submit"><span>Pay Now ({!! $payment_currency !!}{{ $amount }})</span></button>
                            </div>
                        </div>
                          
                    </form>
                </div>
            </div>        
        </div>
    </div>

            </div>

        </div>

    </section>

    

@stop
@section("js")
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  

  
  function stripeResponseHandler(status, response) {
      console.log(status);
      console.log(response);
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var $form = $("#payment-form");
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            //$form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>
@stop
@section("css")

@stop