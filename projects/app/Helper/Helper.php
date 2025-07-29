<?php 
namespace App\Helper;
use App\Models\Agent;
use Auth;
use DB;
use File;
use ModelHelper;
use LiveCart;
use App\Models\BasicSetting;
use App\Models\PropertyRate;
use App\Models\Property;
use Session;

class Helper{
  
  	public function GetHowDidYouHearABoutUs(){
     	return ["Google"=>"Google", "Facebook"=>"Facebook", "Instagram"=>"Instagram", "Airbnb"=>"Airbnb", "VRBO"=>"VRBO","Other"=>"Other"]; 
    }
    
    public function getReviewName($name){
        $ar=explode(" ",$name);
        if(count($ar)>0){
            $s=$ar[0];
            if(count($ar)>1){
                $s.=" ".substr($ar[1],0,1).'.';
            }
            return $s;
        }
        return $name;
    }
    
    public function deleteFile($file){}

	public function getDateFormatData($data){
		return $data;
	}
    
	public function calculateDays($start_date,$end_date){
		$now = strtotime($start_date); $your_date = strtotime($end_date);$datediff =  $your_date-$now;$day= ceil($datediff / (60 * 60 * 24));return $day;
	}

	public function getBookingStatus($item,$id){
		if($item=="booked"){
			$s='<a href="javascript:;" class="btn btn-xs btn-primary">Accept Booking</a>';
		}
		if($item=="rental-aggrement-success"){
			$s='<a href="javascript:;" class="btn btn-xs btn-warning">Booking Accepted</a>';
		}
		if($item=="rental-aggrement"){
			$s='<a href="javascript:;" class="btn btn-xs btn-warning">Booking Accepted</a>';
		}
		if($item=="booking-confirmed"){
			$s='<a href="javascript:;" class="btn btn-xs btn-success">Booking Confirmed</a>';
		}
		if($item=="booking-cancel"){
			$s='<a href="javascript:;" class="btn btn-xs btn-danger">Booking Cancelled</a>';
		}
		return $s;
	}

	public function checkStatus($item){
		if($item=="true"){
			return '<i class="fa fa-check"></i>';
		}else{
			return '<i class="fa fa-times"></i>';
		}
	}

	public function getDayBetweenTwoDates($start_date,$end_date){
		$now = strtotime($start_date);  $your_date = strtotime($end_date); $datediff =  $your_date-$now; $day= ceil($datediff / (60 * 60 * 24)); return $day;
	}

	public function getFeeAmountAndName($c,$gross_amount){
		$name=$c->fee_name;
        if($c->fee_type=="Percentage"):
            $name.='('.$c->fee_rate.'%)';
            $amount=round(($gross_amount*$c->fee_rate)/100,2);
        else:
            $amount=$c->fee_rate; 
        endif;
        return ["status"=>true,"name"=>$name,"amount"=>$amount];
	}

	public function getPropertyRates($id){
		$ar=PropertyRate::where(["property_id"=>$id])->orderBy("id","desc")->get();
		$ar_checkin_checkout=LiveCart::iCalDataCheckInCheckOut($id);
		$new_dates=[];
		$payment_currency=ModelHelper::getDataFromSetting('payment_currency');
		$property=Property::find($id);
		$price='';
		if($property){
		    $price=$property->standard_rate;
		}
		for($i=0;$i<=365;$i++){
		    $title=$payment_currency.''.$price;
		    $class="available-date-full-calendar";
		    $date_single=date('Y-m-d',strtotime("+ ".$i."days",strtotime(date('Y-m-d'))));
		    $a=PropertyRate::where(["property_id"=>$id])->where("single_date",$date_single)->orderBy("id","desc")->first();
		    if($a){
		        $title=$payment_currency.''.$a->price;
		    }
			if(in_array($date_single, $ar_checkin_checkout['checkin'])){
				$title=''; 	$class="booked-date-full-calendar";
			}
			if(in_array($date_single, $ar_checkin_checkout['checkout'])){
				$title=''; 	$class="booked-date-full-calendar";
			}
		    $new_dates[]=["title"=>$title,"start"=>$date_single,"end"=>$date_single,"className"=>$class];
		}
		return json_encode($new_dates);
	}

	public function getGrossAmountData($property,$start_date,$end_date){
		$status=false; $gross_amount=0; $message=''; $stay_flag=0;
		$day_gaurav=$this->getWeekNameSelect();
		$now = strtotime($start_date);  $your_date = strtotime($end_date); $datediff =  $your_date-$now; $day= ceil($datediff / (60 * 60 * 24)); $total_night=$day;
        if($day>0){
	         for($i=0;$i<$day;$i++){
	         	$date = strtotime($start_date);$date = strtotime("+".$i." day", $date);$date= date('Y-m-d', $date);
	            $rate=PropertyRate::where(["property_id"=>$property->id,"single_date"=>$date])->first();
	            if($rate){
	            	$stay_flag=1;
	            	if($rate->min_stay<=$day){
	            	    if($i==0){
	            	        if(in_array($rate->checkin_day,['0','1','2','3','4','5','6'])){
	            	            $new_day=(date('w', strtotime($date)));
	            	            if($new_day==$rate->checkin_day){   }else{
	            	                $status='checkin-checkout-day';
	            	                $message="Please select checkin  day is ".$day_gaurav[$rate->checkin_day];
	            	                break;
	            	            }
	            	        }
	            	    }
	            	    if($i==($day-1)){
	            	        if(in_array($rate->checkout_day,['0','1','2','3','4','5','6'])){
	            	            $new_day=(date('w', strtotime("+1 day",strtotime($date))));
	            	            if($new_day==$rate->checkout_day){    }else{
	            	                $status='checkin-checkout-day';
	            	                $message="Please select checkout  day is ".$day_gaurav[$rate->checkout_day];
	            	                break;
	            	            }
	            	        }
	            	    }
	            		if($rate->price){
		            		$gross_amount+=$rate->price;
		            		$status=true;
		            	}
	            	}else{
	            		$status='min-stay-day';
	            		break;
	            	}
	            }else{
	            	if($property->standard_rate){
	            	     if($i==0){
	            	        if(in_array($property->checkin_day,['0','1','2','3','4','5','6'])){
	            	            $new_day=(date('w', strtotime($date)));
	            	            if($new_day==$property->checkin_day){    }else{
	            	                $status='checkin-checkout-day';
	            	                $message="Please select checkin  day is ".$day_gaurav[$property->checkin_day];
	            	                break;
	            	            }
	            	        }
	            	    }
	            	    if($i==($day-1)){
	            	        if(in_array($property->checkout_day,['0','1','2','3','4','5','6'])){
	            	            $new_day=(date('w', strtotime("+1 day",strtotime($date))));
	            	            if($new_day==$property->checkout_day){     }else{
	            	                $status='checkin-checkout-day';
	            	                $message="Please select checkout  day is ".$day_gaurav[$property->checkout_day];
	            	                break;
	            	            }
	            	        }
	            	    }
	            		$gross_amount+=$property->standard_rate;
	            		$status=true;
	            	}else{
	            		$status='date-price';
	            		break;
	            	}
	            }
	        }
	        if($stay_flag==0){
	         	if($property->min_stay){
	         		if($property->min_stay<=$day){ 	}else{
	         			$status='min-stay-day';
	         		}
	         	}else{
	         		$status='min-stay-day';
	         	}
	        }
	        $ar=[];
	        $checkinCheckout=LiveCart::iCalDataCheckInCheckOut($property->id);
	        for($i=0;$i<$day;$i++){
	         	$date = strtotime($start_date);
	            $date = strtotime("+".$i." day", $date);
	            $date= date('Y-m-d', $date);
	            $ar[]=$date;
	            if(in_array($date, $checkinCheckout['checkin'])){
	            	$status="already-booked";
	            	break;
	            }
	        }
	    }else{
	     	$status='min-stay-day';
	    }
		return ["status"=>$status,"gross_amount"=>$gross_amount,"total_night"=>$total_night,"message"=>$message];
	}
	
	public function getPropertyList($start_date,$end_date){
	    $now = strtotime($start_date);  $your_date = strtotime($end_date); $datediff =  $your_date-$now; $day= ceil($datediff / (60 * 60 * 24));
	    $data=Property::where("status","true")->get();
	    $prop_ids=[];
	    foreach($data as $property){
    	    $checkinCheckout=LiveCart::iCalDataCheckInCheckOut($property->id);
            for($i=0;$i<$day;$i++){
              	$date = strtotime($start_date); $date = strtotime("+".$i." day", $date); $date= date('Y-m-d', $date);
              	$ar[]=$date;
              	if(in_array($date, $checkinCheckout['checkin'])){
	                $prop_ids[]=$property->id;
	                break;
              	}
            }
	    }
	    return $prop_ids;
	}

	public function languageChanger($lan){
		Session::put("current_language",$lan);
	}

	public function getPropertyStatus(){
		return ["Villas"=>"Villas","Private Rooms"=>"Private Rooms"];
	}
    
	public function getSeoUrlGet($title){
		return strtolower(str_replace( array('/', '\\','\'', '"', ',' , ';', '<', '>','&',' ','*','!','@','#','$','%','+',',','.','`','~',':','[',']','{','}','(',')','?'), '-', $title));
	}
	
	public function getTypeOfField(){
		return ["select"=>"select","text"=>"text","color"=>"color","date"=>"date","time"=>"time","number"=>"number","textarea"=>"textarea",];
	}
	
	public function getGenderData(){
		return["male"=>"male","female"=>"female",'unisex'=>"unisex",'kids'=>"kids"];
	}

	public function getLoginTypeData(){
		return["normal"=>"normal","google"=>"google",'facebook'=>"facebook"];
	}

	public function getDeviceTypeData(){
		return ["ios"=>"ios","A"=>"android"];
	}

	public  function getBooleanData(){
		return ['0'=>"false","1"=>"true"];
	}

	public  function getBooleanDataActual(){
		return ['false'=>"false","true"=>"true"];
	}

	public  function getfirstTrueBooleanData(){
		return ["1"=>"true","0"=>"false"];
	}

	public function getCoupanCodeList(){
		return ["exact"=>"Exact","percentage"=>"Percentage"];
	}

	public  function getTempletes(){
		return ["home"=>"Home","private-rooms"=>"private-rooms","about"=>"about","services"=>"services","service-detail"=>"service-detail","about-owner"=>"about-owner","common"=>"Common","contact"=>"Contact","blogs"=>"blogs","map"=>"map","reviews"=>"reviews","gallery"=>"gallery","property-list"=>"property-list","attractions"=>"attractions","get-quote"=>"get-quote","faq"=>"FAQ"];
	}

	public function getImage($image){
	    if($image!=""){
	        if(is_file(public_path($image))){
	            return $image;
	        }
	    }
	    return 'uploads/no-image.jpg';
	}
    
    public function getWeekNameSelect(){
        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        return $days;
    }
}