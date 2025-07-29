@extends("front.layouts.master")
@section("title",$data->meta_title)
@section("keywords",$data->meta_keywords)
@section("description",$data->meta_description)
@section("container")
@php
    $name=$data->name;
    $bannerImage=asset('front/images/internal-banner.webp');
    $payment_currency= $setting_data['payment_currency'];
@endphp
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
		<div class="row" style="margin-left: 0px;margin-right: 0px;">
			<div class="table-box" style='margin-bottom:20px; padding-left:0px; padding-right:0px;'>
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
			</div>
			<div class="table-box" style='padding-left:0px; padding-right:0px;'>
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
							<th align="center" style="padding: 10px;" valign="top"><strong>Gross Amount :</strong></th>
						</tr>
						<tr>
							<td align="left" style="padding: 10px;" valign="top">{{$booking['checkin'] }}</td>
							<td align="left" style="padding: 10px;" valign="top">{{$booking['checkout'] }}</td>
							<td align="left" style="padding: 10px;" valign="top">{{$booking['total_guests'] }} ({{$booking['adults']}} Adults, {{$booking['child']}} Child)</td>
							<td align="left" style="padding: 10px;" valign="top">{{$booking['total_night'] }}</td>
							<td align="center" style="padding: 10px;" valign="top">{!! $payment_currency !!}{{number_format($booking['gross_amount'],2) }}</td>
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
			</div>
			{!! Form::open(["route"=>"rental-aggrement-data-save","files"=>true,"onsubmit"=>"return checkSignature()"]) !!}
			<input type="hidden" name="booking_id" value="{{ $booking['id'] }}">
			@if($property->rental_aggrement_attachment)
			<p class="card-title text-center mb-5 rounded" style='margin-top:30px; background: var(--secondary-color);color: #fff;text-align: center;font-size: 15px;font-weight:bold;padding: 10px;'>Read Rental Agreement</p>
			@endif
			<fieldset>
				<div class="col-md-8-offset-2">
					@if($property->rental_aggrement_attachment)
					<iframe id="iframepdf" src="{{asset($property->rental_aggrement_attachment)}}" frameborder="1" scrolling="auto" height="500" width="100%" style="border:1px solid #666CCC"></iframe>
					@endif
				</div>
				<div class="col-md-8-offset-2">
					<div class="even-1 boxSpacingSet8" colspan="2" style="position: relative;margin-left: auto;padding: 0;padding-top: 15px;">
						<input type="checkbox" id="agree" name="agree" required >
						<strong>I have read and agree to the Terms & Conditions.*</strong> &emsp;
					</div>
				</div>
			</fieldset>
			<hr>
			<!-- Content -->
			<div class="container" style="padding: 0px;">
				<div class="row">
					<div class="col-md-12">
						<h1>E-Signature *</h1>
						<p>save your signature as an image!</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<canvas id="sig-canvas" width="400px" height="160">
							Get a better browser, bro.
						</canvas>
					</div>
					<div class="col-md-6">
						<h1>Please upload valid identity proof *</h1>
						<input type="file" name="image" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button class="main-btn" type="submit" id="sig-submitBtn"><span>Pay Now</span></button>
						<button class="main-btn" type="button" id="sig-clearBtn"><span>Clear Signature</span></button>
					</div>
				</div>
				<br/>
				<div class="row d-none">
					<div class="col-md-12">
						<textarea id="sig-dataUrl" name="signature" class="form-control" rows="5">Data URL for your signature will go here!</textarea>
					</div>
				</div>
				<br/>
				<div class="row d-none">
					<div class="col-md-12">
						<img id="sig-image" src="" alt="Your signature will go here!"/>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</section>
@stop
@section("js")
<script>
	function checkSignature(){
	    var canvas = document.getElementById('sig-canvas');
	        if (isCanvasEmpty(canvas)){
	            toastr.error('Please enter signature!');
	            return false;
	        } else {
	            
	            return true;
	        }
	}
	
	
	function isCanvasEmpty(canvas) {
	    const blankCanvas = document.createElement('canvas');
	    blankCanvas.width = canvas.width;
	    blankCanvas.height = canvas.height;
	    return canvas.toDataURL() === blankCanvas.toDataURL();
	}
	(function() {
    	window.requestAnimFrame = (function(callback) {
        	return window.requestAnimationFrame ||
        	  window.webkitRequestAnimationFrame ||
        	  window.mozRequestAnimationFrame ||
        	  window.oRequestAnimationFrame ||
        	  window.msRequestAnimaitonFrame ||
        	  function(callback) {
        	    window.setTimeout(callback, 1000 / 60);
        	  };
    	})();
    	
    	var canvas = document.getElementById("sig-canvas");
    	var ctx = canvas.getContext("2d");
    	ctx.strokeStyle = "#222222";
    	ctx.lineWidth = 4;
    	
    	var drawing = false;
    	var mousePos = {x: 0,y: 0};
    	var lastPos = mousePos;
    	
    	canvas.addEventListener("mousedown", function(e) {
        	drawing = true;
        	lastPos = getMousePos(canvas, e);
        }, false);
    	
    	canvas.addEventListener("mouseup", function(e) {
    	drawing = false;
    	}, false);
    	
    	canvas.addEventListener("mousemove", function(e) {
    	    mousePos = getMousePos(canvas, e);
    	}, false);
    	
    	// Add touch event support for mobile
    	canvas.addEventListener("touchstart", function(e) {
    	
    	}, false);
    	
    	canvas.addEventListener("touchmove", function(e) {
        	var touch = e.touches[0];
        	var me = new MouseEvent("mousemove", {
            	  clientX: touch.clientX,
            	  clientY: touch.clientY
        	});
        	canvas.dispatchEvent(me);
    	}, false);
    	
    	canvas.addEventListener("touchstart", function(e) {
        	mousePos = getTouchPos(canvas, e);
        	var touch = e.touches[0];
        	var me = new MouseEvent("mousedown", {
        	  clientX: touch.clientX,
        	  clientY: touch.clientY
        	});
        	canvas.dispatchEvent(me);
    	}, false);
    	
    	canvas.addEventListener("touchend", function(e) {
        	var me = new MouseEvent("mouseup", {});
        	canvas.dispatchEvent(me);
    	}, false);
    	
    	function getMousePos(canvasDom, mouseEvent) {
        	var rect = canvasDom.getBoundingClientRect();
        	return {
        	  x: mouseEvent.clientX - rect.left,
        	  y: mouseEvent.clientY - rect.top
        	}
    	}
    	
    	function getTouchPos(canvasDom, touchEvent) {
        	var rect = canvasDom.getBoundingClientRect();
        	return {
        	  x: touchEvent.touches[0].clientX - rect.left,
        	  y: touchEvent.touches[0].clientY - rect.top
        	}
    	}
    	
    	function renderCanvas() {
        	if (drawing) {
        	  ctx.moveTo(lastPos.x, lastPos.y);
        	  ctx.lineTo(mousePos.x, mousePos.y);
        	  ctx.stroke();
        	  lastPos = mousePos;
        	}
    	}
    	
    	// Prevent scrolling when touching the canvas
    	document.body.addEventListener("touchstart", function(e) {
        	if (e.target == canvas) {
        	  e.preventDefault();
        	}
    	}, false);
    	document.body.addEventListener("touchend", function(e) {
        	if (e.target == canvas) {
        	  e.preventDefault();
        	}
    	}, false);
    	document.body.addEventListener("touchmove", function(e) {
        	if (e.target == canvas) {
        	  e.preventDefault();
        	}
    	}, false);
    	
    	(function drawLoop() {
        	requestAnimFrame(drawLoop);
        	renderCanvas();
    	})();
    	
    	function clearCanvas() {
    	    canvas.width = canvas.width;
    	}
    	
    	// Set up the UI
    	var sigText = document.getElementById("sig-dataUrl");
    	var sigImage = document.getElementById("sig-image");
    	var clearBtn = document.getElementById("sig-clearBtn");
    	var submitBtn = document.getElementById("sig-submitBtn");
    	clearBtn.addEventListener("click", function(e) {
        	clearCanvas();
        	sigText.innerHTML = "Data URL for your signature will go here!";
        	sigImage.setAttribute("src", "");
    	}, false);
    	submitBtn.addEventListener("click", function(e) {
        	var dataUrl = canvas.toDataURL();
        	sigText.innerHTML = dataUrl;
        	sigImage.setAttribute("src", dataUrl);
    	}, false);
    	
	})();
</script>
@stop
@section("css")
<style>
	#sig-canvas {border: 2px dotted #CCCCCC;border-radius: 15px;cursor: crosshair;}
	h1{color:#000;font-size:20px;font-weight:bold;font-family:'Poppins', sans-serif;line-height: 1.25rem;margin-bottom: 10px;margin-top: 30px;}
</style>
@stop