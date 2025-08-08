<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\NewsLetter; 
use App\Models\Cms; 
use Mail;
use App\Helper\Upload;
use ModelHelper;
use Helper;
use DB;
use MailHelper;
use LiveCart;
use Session;
use Response;
use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogCategory;
use App\Models\ContactusRequest;
use App\Models\HostAway\HostAwayDate;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Property;
use App\Models\Location;
use App\Models\Attraction;
use App\Models\BookingRequest;
use App\Models\AttractionCategory;
use App\Models\HostAway\HostAwayProperty;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Image;
use Validator;
use HostAwayAPI;
use App\Models\Payment;
use Stripe;
use Braintree\Gateway;
use App\Models\Category;
use App\Models\BookingEnquiryHome;
  

class PageController extends Controller{
  
    public function getCheckinCheckoutData(Request $request){
        $new_data_blocked=LiveCart::iCalDataCheckInCheckOut($request->id);
        $checkin=$new_data_blocked['checkin'];
        $checkout=$new_data_blocked['checkout'];
        return response()->json($new_data_blocked);
    }

    public function getPropertiesList(){
        HostAwayAPI::getPropertiesList();
        return redirect()->back();
    }
  
     function propertyCategory($seo_url){
        $data=Category::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.property.category",compact("data","seo_url"));
        }
        return abort(404);
    }

    
    public function getReviewList(){
        HostAwayAPI::getReviewList();
        return redirect()->back();
    }

    public function getPropertyList(){
        HostAwayAPI::getPropertyList();
        return redirect()->back();
    }

    public function getBookingList(){
        HostAwayAPI::getAllBooking();
        return redirect()->back();
    }

    public function getCalendarList(){
        HostAwayAPI::getCalendarList();
        return redirect()->back();
    }
    
    public function attractionCategory($seo_url){
        $data=AttractionCategory::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.attractions.category",compact("data"));
        }
        return abort(404);
    }

    public function servicesSingle($seo_url){
        $data=Service::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.service.single",compact("data"));
        }
        return abort(404);
    }
    
    public function propertyDetail($seo_url){
        $data=HostAwayProperty::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.property.singleHostAway",compact("data"));
        }
        return abort(404);
    }
    
    public function attractionSingle($seo_url){
        $data=Attraction::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.attractions.single",compact("data"));
        }
        return abort(404);
    }
    
    public function attractionLocation($seo_url){
        $data=Location::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.attractions.location",compact("data"));
        }
        return abort(404);
    }

    public function propertyLocation($seo_url){
        $data=Location::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.property.location",compact("data"));
        }
        return abort(404);
    }

    public function reviewSubmit(Request $request){
        $validator = Validator::make($request->all(), ['email' => 'required|email','name'=>"required","message"=>"required"]);   
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        Testimonial::create($request->all());
        return redirect()->back()->with("success","Thank you for submitting your review");
    }
    
    public function reloadCaptcha(){
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function contactPost(Request $request){
      
         $request['name'] = $request->f_name.' '.$request->l_name;
         $validator = Validator::make($request->all(), ['email' => 'required|email','name'=>"required","message"=>"required"]);   
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        if(ModelHelper::getDataFromSetting('g_captcha_enabled')):
            if(ModelHelper::getDataFromSetting('g_captcha_enabled')=="yes"):
                if(ModelHelper::getDataFromSetting('google_captcha_site_key')!="" && ModelHelper::getDataFromSetting('google_captcha_secret_key')!=""):
                    if($request->get('g-recaptcha-response')):
                        $secretKey = ModelHelper::getDataFromSetting('google_captcha_secret_key');
                        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$request->get('g-recaptcha-response'));
                        $responseData = json_decode($verifyResponse);
                        if($responseData->success){}else{
                             return redirect()->back()->withInput()->with("danger","Robot verification failed, please try again.");
                         }
                    else:
                        return redirect()->back()->withInput()->with("danger","Please check on the reCAPTCHA box.");
                    endif;
                endif;
            endif;
        endif;
        ContactusRequest::create($request->all());
        $mailData=["type"=>"thank_you_for_feedback_user",'username'=>$request->name,"to"=>$request->email];
        MailHelper::emailSender($mailData);
        $mailData=["type"=>"feedback_admin",'username'=>$request->name,'useremail'=>$request->email,'usermobile'=>$request->mobile,'usermessage'=>$request->message,"to"=>ModelHelper::getDataFromSetting('contact_us_receiving_mail')];
        MailHelper::emailSender($mailData);
        return redirect()->back()->with("success","Thank you for submitting your query, we will get in touch shortly");
    }

    public function newsletterPost(Request $request){
        $validator = Validator::make($request->all(), ['email' => 'required|email|unique:newsletters,email']);   
        if($validator->fails()){
            return  response()->json(["status"=>400,"message"=>$validator->errors()->first()]);
        }
        $data=NewsLetter::where("email",$request->email)->first();
        if($data){
            return  response()->json(["status"=>400,"message"=>'Already subscribe']);
        }else{
            NewsLetter::create(["email"=>$request->email]);
            $mailData=["type"=>"newsletter",'useremail'=>$request->email,"to"=>ModelHelper::getDataFromSetting('contact_us_receiving_mail')];
            MailHelper::emailSender($mailData);
            return  response()->json(["status"=>200,"message"=>'Thank you for subscribe']);
        }
    }

    public function categoryData($seo){
        $data=BlogCategory::where("seo_url",$seo)->first();
        if($data){
            $blogs=Blog::where("blog_category_id",$data->id)->orderBy("id","desc")->paginate(12);
            return view("front.group.category",compact("data","blogs"));
        }
        return abort(404);
    }

    public function blogSingle($seo_url){
        $data=Blog::where("seo_url",$seo_url)->first();
        if($data){
            $category=BlogCategory::find($data->blog_category_id);
            return view("front.group.single",compact("data","category"));
        }
        return abort(404);
    }

    public function index(){
        $data=Cms::where("seo_url",'home')->first();
        if($data){
            if($data->templete=="home"){
                $templete="front.static.".$data->templete;
                return view($templete,compact("data"));
            }
        }
        return abort(404);
    }
  
    public function getCheckinCheckoutDataOfBooking(Request $request){
        $new_data_blocked=LiveCart::iCalDataCheckInCheckOut($request->id);
        $checkin=$new_data_blocked['checkin'];
        $checkout=$new_data_blocked['checkout'];
        return response()->json($new_data_blocked);
    }
  
    public function bookingContactEnquiryPost(Request $request){
       $validator = Validator::make($request->all(), ['email' => 'required|email','name'=>"required"]);   
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        // if(ModelHelper::getDataFromSetting('g_captcha_enabled')):
        //     if(ModelHelper::getDataFromSetting('g_captcha_enabled')=="yes"):
        //         if(ModelHelper::getDataFromSetting('google_captcha_site_key')!="" && ModelHelper::getDataFromSetting('google_captcha_secret_key')!=""):
        //             if($request->get('g-recaptcha-response')):
        //                 $secretKey = ModelHelper::getDataFromSetting('google_captcha_secret_key');
        //                 $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$request->get('g-recaptcha-response'));
        //                 $responseData = json_decode($verifyResponse);
        //                 if($responseData->success){}else{
        //                      return redirect()->back()->withInput()->with("danger","Robot verification failed, please try again.");
        //                  }
        //             else:
        //                 return redirect()->back()->withInput()->with("danger","Please check on the reCAPTCHA box.");
        //             endif;
        //         endif;
        //     endif;
        // endif;
        $data = $request->all(); 
        $property = HostAwayProperty::find($request->property_id)->name;
        //dd($property);       
        //BookingEnquiryHome::create($request->all());
        
        $mailData=["type"=>"thank_you_for_feedback_user",'username'=>$request->name,"to"=>$request->email];
        MailHelper::emailSender($mailData);
        $mailData=["type"=>"home_booking_enquiry",'username'=>$request->name,'useremail'=>$request->email,'usermobile'=>$request->mobile,'property'=>$property, "start_date"=>$request->start_date, "end_date"=>$request->end_date, "guests"=>$request->guests, "how_did_you_hear_about_us"=>$request->how_did_you_hear_about_us, "to"=>ModelHelper::getDataFromSetting('home_booking_enquiry')];
        MailHelper::emailSender($mailData);
        return redirect()->back()->with("success","Thank you for submitting your query, we will get in touch shortly");
    }
  
    public function adminCheckAjaxGetQuoteData(Request $request){}

    public function adminCheckAjaxGetQuoteDataEdit(Request $request){}

    public function checkAjaxGetQuoteData(Request $request){
        if($request->property_id){
            $property=HostAwayProperty::find($request->property_id);
            if($request->start_date){
                if($request->end_date){
                    $total_guest=$request->adults+$request->childs;
                  	$minimum_stay=0;
                    $now = strtotime($request->get("start_date")); 
                    $your_date = strtotime($request->get("end_date"));
                    $datediff =  $your_date-$now;
                    $day= ceil($datediff / (60 * 60 * 24));
                    $total_night=$day;
                    $date = strtotime(($request->get("start_date")));
                    $date= date('Y-m-d', $date);
                	foreach(HostAwayDate::where(["hostaway_id"=>$property->host_away_id,"single_date"=>$date])->get() as $c){
                      	if($minimum_stay<$c->minimumStay){
                            $minimum_stay=$c->minimumStay;
                        }
                    }
                  	if($minimum_stay<=$total_night){}else{
                       return response()->json(["message"=>"Minimum stay not matched","status"=>400]);
                    }
                    $start_date=Helper::getDateFormatData($request->start_date);
                    $end_date=Helper::getDateFormatData($request->end_date);
                    $days=Helper::calculateDays($start_date,$end_date);
                    if($days>29){
                        $partnersListingMarkup=$property->monthlyDiscount;
                    }elseif($days>6){
                        $partnersListingMarkup=$property->weeklyDiscount;
                    }else{
                        $partnersListingMarkup=$property->bookingEngineMarkup;
                    }
                    $partnersListingMarkup=1;
                    $main_data=HostAwayAPI::getCalculateReservationPrice($property->host_away_id,$partnersListingMarkup,$start_date,$end_date,$total_guest);
                    if($main_data['status']=="200"){
                        $main_data['start_date']=$request->get("start_date");
                        $main_data['end_date']=$request->get("end_date");
                        $main_data['adults']=$request->get("adults");
                        $main_data['childs']=$request->get("childs");
                        $currency=ModelHelper::getDataFromSetting('payment_currency');
                        if($property->currencyCode == 'INR'){
                            $currency= '₹';
                        }
                        $main_data['currency'] = $currency;
                        $data_view=view("front.property.ajax-gaurav-data-get-quote",compact("property","main_data"))->render();
                        $modal_day_view='';
                        $modal_service_view='';
                        $base_price='';
                        $price=$property->price;
                        $now = strtotime($request->get("start_date")); 
                        $your_date = strtotime($request->get("end_date"));
                        $datediff =  $your_date-$now;
                        $day= ceil($datediff / (60 * 60 * 24));
                        $total_night=$day;
                        foreach($main_data['data']['components'] as $c):
                            if($c['isIncludedInTotalPrice']==1):
                                if($c['name']=="baseRate"):
                                    $base_price=$c['total']; break;
                                endif;
                            endif;
                        endforeach;
                        if($base_price!=""){
                            $price=round($base_price/$total_night,2);
                        }
                        $price="<p> $currency   $price</p><span>/ night</span>";
                        return response()->json(["price"=>$price,"message"=>"success","status"=>200,"modal_day_view"=>$modal_day_view,"modal_service_view"=>$modal_service_view,"data_view"=>$data_view]);
                        return view($templete,compact("data","main_data","property"));
                    }else{
                          return response()->json(["message"=>"Invalid Checkout","status"=>400]);
                    }
                }else{
                    return response()->json(["message"=>"Invalid Checkout1","status"=>400]);
                }
            }else{
                return response()->json(["message"=>"Invalid Checkin","status"=>400]);
            }
        }else{
            return response()->json(["message"=>"Property Not select","status"=>400]);
        }
    }

    public function dynamicDataCategory(Request $request,$seo_url){
        if($seo_url=="home"){ return redirect("/"); }
        $data=Cms::where("seo_url",$seo_url)->first();
        if($data){
            $templete="front.static.".$data->templete;
            if($data->templete=="blogs"){
                $blogs=Blog::orderBy("id","desc")->paginate(12);
                return view($templete,compact("data","blogs"));
            }else if($data->templete=="get-quote"){
                $start_date=Helper::getDateFormatData($request->start_date);
                $end_date=Helper::getDateFormatData($request->end_date);
                $total_guest=$request->adults+$request->child;
                $property=HostAwayProperty::find($request->property_id);
                if($property){
                    $minimum_stay=0;
                    $now = strtotime(Helper::getDateFormatData($request->get("start_date"))); 
                    $your_date = strtotime(Helper::getDateFormatData($request->get("end_date")));
                    $datediff =  $your_date-$now;
                    $day= ceil($datediff / (60 * 60 * 24));
                    $total_night=$day;
                    $date = strtotime(Helper::getDateFormatData($request->get("start_date")));
                    $date= date('Y-m-d', $date);
                    foreach(HostAwayDate::where(["hostaway_id"=>$property->host_away_id,"single_date"=>$date])->get() as $c){
                        if($minimum_stay<$c->minimumStay){
                          $minimum_stay=$c->minimumStay;
                        }
                    }
                    if($minimum_stay<=$total_night){}else{
                        return redirect()->back()->with("danger",'Minimum stay not matched');
                    }
                    $coupon_id='';
                    if($request->coupon){
                        $listingid=$property->host_away_id;
                        $start_date=Helper::getDateFormatData($request->start_date);
                        $end_date=Helper::getDateFormatData($request->end_date);
                        $coupon_name=$request->coupon;
                        $coupon_object=(HostAwayAPI::createCouponReservation($coupon_name,$listingid,$start_date,$end_date));
                        if($coupon_object['status']==200){
                            $coupon_id=$coupon_object['data'];
                        }else{
                            return redirect()->back()->with("danger",$coupon_object['message']);
                        }
                    }
                    $days=Helper::calculateDays($start_date,$end_date);
                    if($days>29){
                        $partnersListingMarkup=$property->monthlyDiscount;
                    }elseif($days>6){
                        $partnersListingMarkup=$property->weeklyDiscount;
                    }else{
                        $partnersListingMarkup=$property->bookingEngineMarkup;
                    }
                    $partnersListingMarkup=1;
                    $main_data=HostAwayAPI::getCalculateReservationPrice($property->host_away_id,$partnersListingMarkup,$start_date,$end_date,$total_guest,$coupon_id);
                    if($main_data['status']=="200"){
                        $main_data['coupon']='';
                        $main_data['coupon_id']=$coupon_id;
                        if($request->coupon){
                            $main_data['coupon']=$request->coupon;
                            $main_data['coupon_id']=$coupon_id;
                        }
                        $token = '';
                        return view($templete,compact("data","main_data","property","token"));
                    }else{
                        return redirect()->back()->with("danger",$main_data['message']);
                    }
                }else{
                    return redirect()->back()->with("danger","Property Not listed");
                }       
            }else if($data->templete=="get-quote11"){
                $total_guest=$request->adults+$request->child;
                $property=HostAwayProperty::find($request->property_id);
                if($property){
                  	$minimum_stay=0;
                    $now = strtotime($request->get("start_date")); 
                    $your_date = strtotime($request->get("end_date"));
                    $datediff =  $your_date-$now;
                    $day= ceil($datediff / (60 * 60 * 24));
                    $total_night=$day;
                    $date = strtotime(($request->get("start_date")));
                    $date= date('Y-m-d', $date);
                	foreach(HostAwayDate::where(["hostaway_id"=>$property->host_away_id,"single_date"=>$date])->get() as $c){
                      	if($minimum_stay<$c->minimumStay){
                            $minimum_stay=$c->minimumStay;
                        }
                    }
                  	if($minimum_stay<=$total_night){}else{
                      	return redirect()->back()->with("danger",'Minimum stay not matched');
                    }
                    $main_data=HostAwayAPI::getCalculateReservationPrice($property->host_away_id,$request->start_date,$request->end_date,$total_guest);
                    if($main_data['status']=="200"){
                        $gateway = new Gateway([ 'environment' => env("BRAINTREE_ENV"), 'merchantId' => env("BRAINTREE_MERCHANT_ID"), 'publicKey' => env("BRAINTREE_PUBLIC_KEY"), 'privateKey' => env("BRAINTREE_PRIVATE_KEY"), ]);
                        $token = $gateway->clientToken()->generate();
                        return view($templete,compact("data","main_data","property","token"));
                    }else{
                        return redirect()->back()->with("danger",$main_data['message']);
                    }
                }else{
                    return redirect()->back()->with("danger","Property Not listed");
                }       
            }else{
                return view($templete,compact("data"));
           }
        }
        $data=HostAwayProperty::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.property.singleHostAway",compact("data"));
        }
        return abort(404);
    }

    public function saveBookingData(Request $request){
        if($request->property_id){
            $property=HostAwayProperty::find($request->property_id);
            if($property){
                if($request->checkin){
                    if($request->checkout){
                        $currency = $property->currencyCode;
                       // dd($currency);
                        $financeField=[];
                        $amount_data=json_decode($request->amount_data,true);
                        foreach($amount_data['data']['components'] as $c){
                            $financeField[]=[
                                "id"=> $c['id'],
                                "listingFeeSettingId"=> $c['listingFeeSettingId'],
                                "type"=> $c["type"],
                                "name"=> $c["name"],
                                "title"=> $c["title"],
                                "alias"=> $c["alias"],
                                "quantity"=> $c["quantity"],
                                "value"=> $c['value'],
                                "total"=> $c['total'],
                                "isIncludedInTotalPrice"=> $c['isIncludedInTotalPrice'],
                                "isOverriddenByUser"=> $c['isOverriddenByUser'],
                                "isQuantitySelectable"=> $c['isQuantitySelectable'],
                                "isMandatory"=> $c['isMandatory'],
                                "isDeleted"=> $c['isDeleted'],
                                "units"=> $c['units']
                            ];
                        }                        
                        $data=$request->except(["_token"]);
                        $data['name']=$data['firstname']." ".$data['lastname'];
                        $data['total_amount']=$data['amount'];
                        $total_main_amount=$data['total_amount'];
                        if($request->additional_new_data){
                            $additional=json_decode($request->additional,true);
                            $data['additional_new_data']=json_encode($data['additional_new_data']);
                            foreach($request->additional_new_data as $id=>$value){
                                if($value=="yes"){
                                    if($additional['status']==200){
                                        if(isset($additional['data'])){
                                            if(isset($additional['data']['result'])){
                                                if(is_array($additional['data']['result'])){
                                                    foreach($additional['data']['result'] as $a){
                                                        if($a['isMandatory']==1){}else{
                                                            if($a['id']==$id){
                                                                $total=$a['amount'];
                                                                if($a['amountType']=="flat"){
                                                                    if($a['feeAppliedPer']=="reservation"){
                                                                         $total=$a['amount'];
                                                                    }elseif($a['feeAppliedPer']=="night"){
                                                                        $total=$total*$request->total_night;
                                                                    }
                                                                }else{
                                                                    if($a['feeAppliedPer']=="reservation"){
                                                                         $total=round(($total_main_amount*$a['amount'])/100,2);
                                                                    }elseif($a['feeAppliedPer']=="night"){
                                                                        $total=round(($total_main_amount*$a['amount']*$request->total_night)/100,2);
                                                                    }
                                                                }
                                                                $data['total_amount']+=($total);
                                                                $financeField[]=[
                                                                    "id"=> null,
                                                                    "listingFeeSettingId"=> $a['id'],
                                                                    "type"=> 'fee',
                                                                    "name"=> $a["feeType"],
                                                                    "title"=> $a["feeTitle"],
                                                                    "alias"=> $a["feeTitle"],
                                                                    "quantity"=> null,
                                                                    "value"=> $total,
                                                                    "total"=> $total,
                                                                    "isIncludedInTotalPrice"=> 1,
                                                                    "isOverriddenByUser"=> 0,
                                                                    "isQuantitySelectable"=> $a['isQuantitySelectable'],
                                                                    "isMandatory"=> $c['isMandatory'],
                                                                    "isDeleted"=> 0,
                                                                    "units"=> 1
                                                                ];
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
               
                        $data['financeField']=json_encode($financeField);

                        $ar_gaurav_data=BookingRequest::where("request_id",$request->request_id)->first();
                        if($ar_gaurav_data){
                            $id=$ar_gaurav_data->id;
                            BookingRequest::where("request_id",$request->request_id)->delete();
                            $booking=BookingRequest::create($data);
                            $id=$booking->id;
                        }else{
                            $booking=BookingRequest::create($data);
                            $id=$booking->id;
                        }
                        $booking=BookingRequest::find($id);
                        $data=$booking;
                        $new_data=['booking_status'=>"rental-aggrement"];
                        BookingRequest::find($booking->id)->update($new_data);
                        $amount=$request->amount;
                        $listing_id=$property->host_away_id;
                        $start_date=$booking->checkin;
                        $end_date=$booking->checkout;
                        $name=$booking->name;
                        $email=$booking->email;
                        $mobile=$booking->mobile;
                        $adult=$booking->adults;
                        $child=$booking->child;
                        $listingMapId=$listing_id;
                        $name=$name;
                        $first_name=$request->firstname;
                        $last_name=$request->lastname;
                        $email=$email;
                        $mobile='+1'.$mobile;
                        $numberOfGuests=$adult+$child;
                        $adults=$adult;
                        $children=$child;
                        $arrivalDate=$start_date;
                        $departureDate=$end_date;
                        $totalPrice=$data['total_amount'];
                        $financeField=json_encode($financeField);
                        $data_host=HostAwayAPI::createBookingCustom($listingMapId,$name,$first_name,$last_name,$email,$mobile,$numberOfGuests,$adults,$children,$arrivalDate,$departureDate,$totalPrice,$financeField,$booking->discount_coupon,$currency);
                        if($data_host['status']=="success"){
                            $new_data121=['listingMapId'=>$data_host['result']['listingMapId'],'channelId'=>$data_host['result']['channelId'],'reservationId'=>$data_host['result']['reservationId'],'hostawayReservationId'=>$data_host['result']['hostawayReservationId'],'channelReservationId'=>$data_host['result']['channelReservationId'],'guestAuthHash'=>$data_host['result']['guestAuthHash'],'guestPortalUrl'=>$data_host['result']['guestPortalUrl'],'checkInTime'=>$data_host['result']['checkInTime'],'checkOutTime'=>$data_host['result']['checkOutTime'],'reg_id'=>$data_host['result']['id']];
                            $card_name=$request->name_on_card;
                            $card_number=$request->card_number;
                            $card_expiry_year=$request->card_year;
                            $card_expiry_month=$request->card_exp_month;
                            $card_cvv=$request->card_cvv;
                            $booking_id=$data_host['result']['hostawayReservationId'];
                            HostAwayAPI::addCreditCardForBooking($booking_id,$card_name,$card_number,$card_expiry_year,$card_expiry_month,$card_cvv);
                            BookingRequest::find($id)->update($new_data121);
                            $ijh=0;
                        }
                        $booking=BookingRequest::find($id);
                        $payment=Payment::create(['booking_id'=>$booking->id,'receipt_url'=>1 ,'customer_id'=>1 ,'balance_transaction'=>1 ,'tran_id'=>1 ,'description'=>1,'status'=>"complete",'type'=>"stripe",'amount'=>$amount]);
                      
                      
                        $html= view("mail.booking-first-admin-hostaway",compact("property","booking"))->with("data",$booking->toArray())->with("payment_currency","$")->render();  
                        $to=ModelHelper::getDataFromSetting('payment_receiving_mail');
                        $subject="Booking Confirmation  for ".$property->name;
                        MailHelper::emailSenderByController($html,$to,$subject);
                        $html= view("mail.booking-first-customer-hostaway",compact("property","booking"))->with("data",$booking->toArray())->with("payment_currency","$")->render();   
                        $to=$booking->email;
                        $subject="Booking Confirmation for ".$property->name;
                        MailHelper::emailSenderByController($html,$to,$subject);
                      
                        ModelHelper::finalEmailAndUpdateBookingPayment($id,$booking,$payment,$property);
                        HostAwayAPI::getAllCalendarAPIRun($listing_id);
                        return redirect('payment/success/'.$payment->id)->with("success","Payment Successful. We will be in contact with more details shortly.");
                    }else{
                        return redirect()->back()->with("danger","Invalid Checkout");
                    }
                }else{
                    return redirect()->back()->with("danger","Invalid Checkin");
                }
            }else{
                return redirect()->back()->with("danger","Invalid Property");
            }
        }else{
            return redirect()->back()->with("danger","Invalid Property");
        }
    }

    public function saveBookingData124(Request $request){
        if($request->property_id){
            $property=HostAwayProperty::find($request->property_id);
            if($property){
                if($request->checkin){
                    if($request->checkout){
                        $data=$request->except(["_token"]);
                        $data['name']=$data['firstname']." ".$data['lastname'];
                        $ar_gaurav_data=BookingRequest::where("request_id",$request->request_id)->first();
                        if($ar_gaurav_data){
                            $id=$ar_gaurav_data->id;
                            BookingRequest::where("request_id",$request->request_id)->delete();
                            $booking=BookingRequest::create($data);
                            $id=$booking->id;
                        }else{
                            $booking=BookingRequest::create($data);
                            $id=$booking->id;
                        }
                        $booking=BookingRequest::find($id);
                        $data=$booking;
                        $new_data=['booking_status'=>"rental-aggrement"];
                        BookingRequest::find($booking->id)->update($new_data);
                        $key=['stripe_publish_key'=>ModelHelper::getDataFromSetting('stripe_publish_key'),'stripe_secret_key'=>ModelHelper::getDataFromSetting('stripe_secret_key'),];
                        if($property){
                            if($property->stripe_publish_key){
                                if($property->stripe_secret_key){
                                     $key=[ 'stripe_publish_key'=>$property->stripe_publish_key, 'stripe_secret_key'=>$property->stripe_secret_key, ];
                                }
                            }
                        }
                        try{
                            Stripe\Stripe::setApiKey($key['stripe_secret_key']);
                            $customer = Stripe\Customer::create(array("email" => $booking->email,"source" => $request->stripeToken));
                            $amount=$request->amount;
                            $charge=Stripe\Charge::create (['customer' => $customer->id,"amount" => $amount * 100,"currency" => "usd","description" => "Payment for ".$property->name]);
                            $chargeJson=$charge->jsonSerialize();
                            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
                                $listing_id=$property->host_away_id;
                                $start_date=$booking->checkin;
                                $end_date=$booking->checkout;
                                $name=$booking->name;
                                $email=$booking->email;
                                $mobile=$booking->mobile;
                                $adult=$booking->adults;
                                $child=$booking->child;
                                $data_host=HostAwayAPI::createbooking($listing_id,$start_date,$end_date,$amount,$name,$email,$adult,$child,$mobile);
                                if($data_host['status']=="success"){
                                    $new_data121=['listingMapId'=>$data_host['result']['listingMapId'],'channelId'=>$data_host['result']['channelId'],'reservationId'=>$data_host['result']['reservationId'],'hostawayReservationId'=>$data_host['result']['hostawayReservationId'],'channelReservationId'=>$data_host['result']['channelReservationId'],'guestAuthHash'=>$data_host['result']['guestAuthHash'],'guestPortalUrl'=>$data_host['result']['guestPortalUrl'],'checkInTime'=>$data_host['result']['checkInTime'],'checkOutTime'=>$data_host['result']['checkOutTime'],'reg_id'=>$data_host['result']['id'],];
                                    BookingRequest::find($id)->update($new_data121);
                                }
                                $booking=BookingRequest::find($id);
                                $payment=Payment::create(['booking_id'=>$booking->id,'receipt_url'=>$chargeJson['receipt_url'] ,'customer_id'=>$chargeJson['customer'] ,'balance_transaction'=>$chargeJson['balance_transaction'] ,'tran_id'=>$chargeJson['id'] ,'description'=>json_encode($chargeJson),'status'=>"complete",'type'=>"stripe",'amount'=>$amount]);
                                ModelHelper::finalEmailAndUpdateBookingPayment($id,$booking,$payment,$property);
                                HostAwayAPI::getAllCalendarAPIRun($listing_id);
                                return redirect('payment/success/'.$payment->id)->with("success","Payment Successful. We will be in contact with more details shortly.");
                            }else{
                                $message="something happen";
                            }
                        }catch(Stripe\Exception\CardException $e){
                          $message =$e->getError()->message ;
                        }catch(Stripe\Exception\RateLimitException $e){
                            $message =$e->getError()->message ;
                        }catch(Stripe\Exception\InvalidRequestException $e){
                            $message =$e->getError()->message ;
                        }catch(Stripe\Exception\AuthenticationException $e){
                            $message ='error' ;
                        }catch(Stripe\Exception\ApiConnectionException $e){
                            $message =$e->getError()->message ;
                        }catch(Stripe\Exception\ApiErrorException $e){
                            $message =$e->getError()->message ;
                        }catch(Exception $e){
                            $message =$e->getError()->message ;
                        }
                        return redirect()->back()->with("danger",$message);
                    }else{
                        return redirect()->back()->with("danger","Invalid Checkout");
                    }
                }else{
                    return redirect()->back()->with("danger","Invalid Checkin");
                }
            }else{
                return redirect()->back()->with("danger","Invalid Property");
            }
        }else{
            return redirect()->back()->with("danger","Invalid Property");
        }
    }

    public function previewBooking(Request $request , $id){
        $booking=BookingRequest::find($id);
        if($booking){
            $property=HostAwayProperty::find($booking->property_id);
            if($property){
                $data = new \stdClass();
                $data->name="Booking Request";
                $data->meta_title="Booking Request";
                $data->meta_keywords="Booking Request";
                $data->meta_description="Booking Request";
                $booking=$booking->toArray();
                return view("front.booking.preview",compact("booking","data","property"));
            }
        }
        return abort(404);
    }

    public function rentalAggrementBooking(Request $request , $id){
        $booking=BookingRequest::find($id);
        if($booking){
            if($booking->rental_aggrement_status!="true"){
                $property=HostAwayProperty::find($booking->property_id);
                if($property){
                    $data = new \stdClass();
                    $data->name="Rental Agreement  ";
                    $data->meta_title="Rental Agreement  ";
                    $data->meta_keywords="Rental Agreement  ";
                    $data->meta_description="Rental Agreement  ";
                    $booking=$booking->toArray();
                    return view("front.booking.rentalAggrementBooking",compact("booking","data","property"));
                }
            }else{
                return redirect()->to('booking/payment/paypal/'.$booking->id)->with("danger","Rental Agreement already submitted");
            }
        }
        return abort(404);
    }

    public function rentalAggrementDataSave(Request $request){
        if($request->booking_id){
            $booking=BookingRequest::find($request->booking_id);
            if($booking){
                if($booking->rental_aggrement_status!="true"){
                    $property=HostAwayProperty::find($booking->property_id);
                    if($property){
                        $png_url = "signature-".time().".png";
                        $path = public_path().'/uploads/signature/' . $png_url;
                        Image::make(file_get_contents($request->signature))->save($path); 
                        $data=$request->all();
                        $booking->rental_aggrement_status="true";
                        if ($request->hasFile("image")) {
                            $booking->rental_aggrement_images = Upload::fileUpload($request->file("image"),"cms");
                        }
                        $booking->rental_agreement_link =$property->rental_aggrement_attachment;
                        $booking->rental_aggrement_signature='uploads/signature/' . $png_url;
                        $booking->booking_status="rental-aggrement-success";
                        $booking->save();
                        $data=BookingRequest::find($request->booking_id)->toArray();
                        $html= view("mail.rental-aggrement-admin",compact("data","property"))->render();
                        $to=ModelHelper::getDataFromSetting('rental_aggrement_receiving_mail');
                        $admin_subject="Rental Agreement in ".$property->name;
                        MailHelper::emailSenderByController($html,$to,$admin_subject);
                        return redirect()->to('booking/payment/paypal/'.$booking->id);
                    }
                }else{
                    return redirect()->to('booking/payment/paypal/'.$booking->id)->with("danger","Rental Agreement already submitted");
                }
            }
        }
        return abort(404);
    }

    public function notfound(){
        return view("errors.404");
    }
    
    public function sitemap(){
        $cms=Cms::all(); $blogs=Blog::all(); $blogcategories=BlogCategory::all();
        return response()->view("front.sitemap",compact("cms","blogs","blogcategories"))->header('Content-Type', 'text/xml');
    }
}