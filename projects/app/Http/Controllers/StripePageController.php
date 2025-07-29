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
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Property;
use App\Models\Location;
use App\Models\Attraction;
use App\Models\BookingRequest;
use App\Models\HostAway\HostAwayProperty;
use Image;
use Validator;
use HostAwayAPI;
use App\Models\Payment;
use Stripe;

class StripePageController extends Controller
{
    function getPropertiesList(){
        HostAwayAPI::getPropertiesList();
        return redirect()->back();
    }
    
    function propertyDetail($seo_url){
        $data=HostAwayProperty::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.property.singleHostAway",compact("data"));
        }
        return abort(404);
    }
    
    function attractionSingle($seo_url){
        $data=Attraction::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.attractions.single",compact("data"));
        }
        return abort(404);
    }
    
    function attractionLocation($seo_url){
        $data=Location::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.attractions.location",compact("data"));
        }
        return abort(404);
    }

    function propertyLocation($seo_url){
        $data=Location::where("seo_url",$seo_url)->first();
        if($data){
            return view("front.property.location",compact("data"));
        }
        return abort(404);
    }

    function reviewSubmit(Request $request){
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

    function contactPost(Request $request){
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

    function newsletterPost(Request $request){
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

    function categoryData($seo){
        $data=BlogCategory::where("seo_url",$seo)->first();
        if($data){
            $blogs=Blog::where("blog_category_id",$data->id)->orderBy("id","desc")->paginate(12);
            return view("front.group.category",compact("data","blogs"));
        }
        return abort(404);
    }

    function blogSingle($seo_url){
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

    function adminCheckAjaxGetQuoteData(Request $request){
        if($request->property_id){
            $property=Property::find($request->property_id);
            if($request->start_date){
                if($request->end_date){
                    $main_data=Helper::getGrossAmountData($property,$request->start_date,$request->end_date);
                    if($main_data['status']=="true"){
                        $main_data['start_date']=$request->get("start_date");
                        $main_data['end_date']=$request->get("end_date");
                        $main_data['adults']=$request->get("adults");
                        $main_data['childs']=$request->get("childs");
                        $main_data['pet_fee_data_guarav']=$request->get("pet_fee_data_guarav");
                        $main_data['total_guests']=$request->get("adults")+$request->get("childs");
                        $main_data['adults']=$request->get("adults");
                        $main_data['child']=$request->get("childs");
                        $main_data['start_date']=$request->get("start_date");
                        $main_data['end_date']=$request->get("end_date");
                        $main_data['adults']=$request->get("adults");
                        $main_data['childs']=$request->get("childs");
                        $main_data['pet_fee_data_guarav']=$request->get("pet_fee_data_guarav");
                        $main_data['extra_discount']=$request->get('extra_discount');
                        $data_view= view('admin.common.get-quote',compact("main_data","property"))->render();
                        return response()->json(["message"=>"success","status"=>200,"data_view"=>$data_view]);
                    }else if($main_data['status']=="already-booked"){
                        return response()->json(["message"=>"Already booked some date","status"=>400]);
                    }else if($main_data['status']=="checkin-checkout-day"){
                        return response()->json(["message"=>$main_data['message'],"status"=>400]);
                    }else if($main_data['status']=="min-stay-day"){
                        return response()->json(["message"=>"Minimum stay is not statisfy","status"=>400]);
                    }else if($main_data['status']=="date-price"){
                        return response()->json(["message"=>"Price is not defined","status"=>400]);
                    }else{
                        return response()->json(["message"=>"Invalid Calling","status"=>400,"message1"=>$main_data['status']]);
                    }
                }else{
                    return response()->json(["message"=>"Invalid Checkout","status"=>400]);
                }
            }else{
                return response()->json(["message"=>"Invalid Checkin","status"=>400]);
            }
        }else{
            return response()->json(["message"=>"Property Not select","status"=>400]);
        }
    }

    function adminCheckAjaxGetQuoteDataEdit(Request $request){
        if($request->property_id){
            $property=Property::find($request->property_id);
            if($request->start_date){
                if($request->end_date){
                    $main_data=Helper::getGrossAmountData($property,$request->start_date,$request->end_date);
                    if($main_data['status']=="true"){
                        $main_data['start_date']=$request->get("start_date");
                        $main_data['end_date']=$request->get("end_date");
                        $main_data['adults']=$request->get("adults");
                        $main_data['childs']=$request->get("childs");
                        $main_data['pet_fee_data_guarav']=$request->get("pet_fee_data_guarav");
                        $main_data['total_guests']=$request->get("adults")+$request->get("childs");
                        $main_data['adults']=$request->get("adults");
                        $main_data['child']=$request->get("childs");
                        $main_data['start_date']=$request->get("start_date");
                        $main_data['end_date']=$request->get("end_date");
                        $main_data['adults']=$request->get("adults");
                        $main_data['childs']=$request->get("childs");
                        $main_data['pet_fee_data_guarav']=$request->get("pet_fee_data_guarav");
                        $main_data['extra_discount']=$request->get('extra_discount');
                        $main_data['coupon_discount']=$request->get('coupon_discount');
                        $main_data['coupon_discount_code']=$request->get('coupon_discount_code');
                        $data_view= view('admin.common.get-quote-edit',compact("main_data","property"))->render();
                        return response()->json(["message"=>"success","status"=>200,"data_view"=>$data_view]);
                    }else if($main_data['status']=="already-booked"){
                        return response()->json(["message"=>"Already booked some date","status"=>400]);
                    }else if($main_data['status']=="min-stay-day"){
                        return response()->json(["message"=>"Minimum stay is not statisfy","status"=>400]);
                    }else if($main_data['status']=="date-price"){
                        return response()->json(["message"=>"Price is not defined","status"=>400]);
                    }else if($main_data['status']=="checkin-checkout-day"){
                        return response()->json(["message"=>$main_data['message'],"status"=>400]);
                    }else{
                        return response()->json(["message"=>"Invalid Calling","status"=>400]);
                    }
                }else{
                    return response()->json(["message"=>"Invalid Checkout","status"=>400]);
                }
            }else{
                return response()->json(["message"=>"Invalid Checkin","status"=>400]);
            }
        }else{
            return response()->json(["message"=>"Property Not select","status"=>400]);
        }
    }

    function checkAjaxGetQuoteData(Request $request){
        if($request->property_id){
            $property=Property::find($request->property_id);
            if($request->start_date){
                if($request->end_date){
                    $main_data=Helper::getGrossAmountData($property,$request->start_date,$request->end_date);
                    if($main_data['status']=="true"){
                        $main_data['start_date']=$request->get("start_date");
                        $main_data['end_date']=$request->get("end_date");
                        $main_data['adults']=$request->get("adults");
                        $main_data['childs']=$request->get("childs");
                        $main_data['pet_fee_data_guarav']=$request->get("pet_fee_data_guarav");
                        $data_view=view("front.property.ajax-gaurav-data-get-quote",compact("property","main_data"))->render();
                        $modal_day_view=view("front.property.ajax-gaurav-modal-day-get-quote",compact("property","main_data"))->render();
                        $modal_service_view=view("front.property.ajax-gaurav-modal-service-get-quote",compact("property","main_data"))->render();
                        return response()->json(["message"=>"success","status"=>200,"modal_day_view"=>$modal_day_view,"modal_service_view"=>$modal_service_view,"data_view"=>$data_view]);
                    }else if($main_data['status']=="already-booked"){
                        return response()->json(["message"=>"Already booked some date","status"=>400]);
                    }else if($main_data['status']=="min-stay-day"){
                        return response()->json(["message"=>"Minimum stay is not statisfy","status"=>400]);
                    }else if($main_data['status']=="checkin-checkout-day"){
                        return response()->json(["message"=>$main_data['message'],"status"=>400]);
                    }else if($main_data['status']=="date-price"){
                        return response()->json(["message"=>"Price is not defined","status"=>400]);
                    }else{
                        return response()->json(["message"=>"Invalid Calling","status"=>400]);
                    }
                }else{
                    return response()->json(["message"=>"Invalid Checkout","status"=>400]);
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
                $total_guest=$request->adults+$request->child;
                $property=HostAwayProperty::find($request->property_id);
                if($property){
                    $main_data=HostAwayAPI::getCalculateReservationPrice($property->host_away_id,$request->start_date,$request->end_date,$total_guest);
                    if($main_data['status']=="200"){
                        return view($templete,compact("data","main_data","property"));
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

    function saveBookingData(Request $request){
        if($request->property_id){
            $property=HostAwayProperty::find($request->property_id);
            if($property){
                if($request->checkin){
                    if($request->checkout){
                        $data=$request->all();
                        $data['name']=$data['firstname']." ".$data['lastname'];
                        $ar_gaurav_data=BookingRequest::where("request_id",$request->request_id)->first();
                        if($ar_gaurav_data){
                            $id=$ar_gaurav_data->id;
                            BookingRequest::where("request_id",$request->request_id)->update($data);
                            $booking=BookingRequest::where("request_id",$request->request_id)->first();
                        }else{
                            $booking=BookingRequest::create($data);
                            $id=$booking->id;
                        }
                        $data=$booking;
                        $new_data=['booking_status'=>"rental-aggrement"];
                        BookingRequest::find($booking->id)->update($new_data);
                        $key=[ 'stripe_publish_key'=>ModelHelper::getDataFromSetting('stripe_publish_key'), 'stripe_secret_key'=>ModelHelper::getDataFromSetting('stripe_secret_key'), ];
                        if($property){
                            if($property->stripe_publish_key){
                                if($property->stripe_secret_key){
                                     $key=[ 'stripe_publish_key'=>$property->stripe_publish_key, 'stripe_secret_key'=>$property->stripe_secret_key, ];
                                }
                            }
                        }
                        try {
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
                                $payment=Payment::create([ 'booking_id'=>$booking->id, 'receipt_url'=>$chargeJson['receipt_url'] , 'customer_id'=>$chargeJson['customer'] , 'balance_transaction'=>$chargeJson['balance_transaction'] , 'tran_id'=>$chargeJson['id'] , 'description'=>json_encode($chargeJson), 'status'=>"complete", 'type'=>"stripe", 'amount'=>$amount ]);
                                ModelHelper::finalEmailAndUpdateBookingPayment($id,$booking,$payment,$property);
                                HostAwayAPI::getAllCalendarAPIRun($listing_id);
                                return redirect('payment/success/'.$payment->id)->with("success","Payment Successful. We will be in contact with more details shortly.");
                            }else{
                                $message="something happen";
                            }
                        } catch(Stripe\Exception\CardException $e) {
                          $message =$e->getError()->message ;
                        } catch (Stripe\Exception\RateLimitException $e) {
                            $message =$e->getError()->message ;
                        } catch (Stripe\Exception\InvalidRequestException $e) {
                            $message =$e->getError()->message ;
                        } catch (Stripe\Exception\AuthenticationException $e) {
                            $message =$e->getError()->message ;
                        } catch (Stripe\Exception\ApiConnectionException $e) {
                            $message =$e->getError()->message ;
                        } catch (Stripe\Exception\ApiErrorException $e) {
                            $message =$e->getError()->message ;
                        } catch (Exception $e) {
                            $message =$e->getError()->message ;
                        }
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

    function previewBooking(Request $request , $id){
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

    function rentalAggrementBooking(Request $request , $id){
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

    function rentalAggrementDataSave(Request $request){
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
    
    function sitemap(){
        $cms=Cms::all(); $blogs=Blog::all(); $blogcategories=BlogCategory::all();
        return response()->view("front.sitemap",compact("cms","blogs","blogcategories"))->header('Content-Type', 'text/xml');
    }
}