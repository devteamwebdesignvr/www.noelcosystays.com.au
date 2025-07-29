<?php 
namespace App\Helper;
use App\Models\Agent;
use App\Models\BasicSetting;
use Auth;
use DB;
use File;
use ModelHelper;
use LiveCart;
use Helper;
use MailHelper;
use App\Models\HostAway\HostAwayReview;
use App\Models\HostAway\HostAwayCalcelationPolicy;
use App\Models\HostAway\HostAwayBooking;
use App\Models\HostAway\HostAwayProperty;
use App\Models\HostAway\HostAwayDate;
use Session;

class HostAwayAPI{

    public function getguestAutopaymentId(){
        $guestAutopaymentId='54380';
        return $guestAutopaymentId;
    }

    public function createBookingCustom($listingMapId,$name,$first_name,$last_name,$email,$mobile,$numberOfGuests,$adults,$children,$arrivalDate,$departureDate,$totalPrice,$financeField,$couponName,$currency ="AUD"){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        $post_field='{"channelId": 2000,"listingMapId": '.$listingMapId.',"guestName": "'.$name.'","guestFirstName": "'.$first_name.'","guestLastName": "'.$last_name.'","guestEmail": "'.$email.'","numberOfGuests": '.$numberOfGuests.',"adults": '.$adults.',"children": '.$children.',    "arrivalDate": "'.$arrivalDate.'","departureDate": "'.$departureDate.'","phone": "'.$mobile.'","totalPrice": '.$totalPrice.',"currency": "AUD","financeField": '.$financeField.'}';
        if($couponName){
            $post_field='{"channelId": 2000,"listingMapId": '.$listingMapId.',"guestName": "'.$name.'","guestFirstName": "'.$first_name.'","guestLastName": "'.$last_name.'","guestEmail": "'.$email.'","numberOfGuests": '.$numberOfGuests.',"adults": '.$adults.',"children": '.$children.',    "arrivalDate": "'.$arrivalDate.'","departureDate": "'.$departureDate.'","phone": "'.$mobile.'","totalPrice": '.$totalPrice.',"currency": "AUD","financeField": '.$financeField.',"couponName":"'.$couponName.'"}';
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.hostaway.com/v1/reservations?forceOverbooking=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$post_field,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer  ".$token_data['token'],  "Cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err){
           return ["status"=>"400","message"=> $err];
        }else{
            $data= json_decode($response,true);
            return $data;
        }
    }
    

    public function getlistingFeeSettings($listing_id){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/listingFeeSettings/".$listing_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer  ".$token_data['token'],  "Cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        } else {
            $data= json_decode($response,true);
            return ["status"=>"200","message"=> "Success","data"=>$data];
        }
    }
     
    public function getAUtopayment(){
        $curl = curl_init();
        $token_data=$this->getBearerToken();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/guestPayments/autoPayment",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer ".$token_data['token'],"Cache-control: no-cache","Content-type: application/json")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            return ["status"=>"200","message"=> "Success","token"=>$response];
        }
    }

    public function getBearerToken(){
        $token='';
        $setting=BasicSetting::where("name","HostAwayToken")->first();
        if($setting){
            if($setting->value){
                $token=$setting->value;
            }
        }
        if($token){
            return ["status"=>"200","message"=> "Success","token"=>$token];
        }else{
            $client_id=134736;
            $secret_code='2bdf536eff1a16e292edcbb5f71ada3cc23a096627aa2fb875659a447ab0e55a';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.hostaway.com/v1/accessTokens",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=".$client_id."&client_secret=".$secret_code."&scope=general",
                CURLOPT_HTTPHEADER => array("cache-control: no-cache","content-type: application/x-www-form-urlencoded")
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              return ["status"=>"400","message"=> $err];
            } else {
                $response=json_decode($response,true);
                if(isset($response['error'])){
                    return ["status"=>"400","message"=> $response['message']];
                }else{
                    if(isset($response['token_type'])){
                        if(isset($response['access_token'])){
                            $setting=BasicSetting::where("name","HostAwayToken")->get();
                            if($setting){
                                BasicSetting::where(["name"=>"HostAwayToken"])->update(["value"=>$response['access_token']]);
                            }else{
                                BasicSetting::create(["name"=>"HostAwayToken","value"=>$response['access_token']]);
                            }
                            return ["status"=>"200","message"=> "Success","token"=>$response['access_token']];
                        }
                    }
                    return ["status"=>"400","message"=> "something happen"];
                }
            }
        }
    }
    
  	public function cancellationPolicy($id){
        $token_data=$this->getBearerToken();
   		$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/cancellationPolicies/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer ".$token_data['token'],"Cache-control: no-cache","Content-type: application/json")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err){
            return ["status"=>"400","message"=> $err];
        }else{
            $data= json_decode($response,true);
            return $data;
        }
  	}

    public function cancelBooking($reg_id){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/reservations/".$reg_id."/statuses/cancelled",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n\t\"cancelledBy\": \"host\"\n}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer ".$token_data['token'],"Cache-control: no-cache","Content-type: application/json")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else{
            $data= json_decode($response,true);
            return $data;
        }
    }

    function createbooking($listing_id,$start_date,$end_date,$amount,$name,$email,$adult,$child,$mobile){
        $token_data=$this->getBearerToken();
        $json=("{\n    \"channelId\": 2020,\n    \"listingMapId\": ".$listing_id.",\n    \"isManuallyChecked\": 0,\n    \"isInitial\": 0,\n    \"guestName\": \"".$name."\",\n    \"guestEmail\": \"".$email."\",\n    \"numberOfGuests\": ".($adult+$child).",\n    \"adults\": ".$adult.",\n    \"children\": ".$child.",\n    \"infants\": null,\n    \"pets\": null,\n    \"arrivalDate\": \"".$start_date."\",\n    \"departureDate\": \"".$end_date."\",\n    \"checkInTime\": null,\n    \"checkOutTime\": null,\n    \"phone\": \"".$mobile."\",\n    \"totalPrice\": ".$amount.",\n    \"taxAmount\": null,\n    \"channelCommissionAmount\": null,\n    \"cleaningFee\": null,\n    \"securityDepositFee\": null,\n    \"isPaid\": true ,\n    \"currency\": \"USD\"}");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.hostaway.com/v1/reservations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json,
            CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$token_data['token'],'Content-type: text/plain')
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else {
            $data= json_decode($response,true);
            return $data;
        }
    }

    public function getPropertiesList(){
        $token_data=$this->getBearerToken();
        if($token_data['status']=="200"){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.hostaway.com/v1/listings?limit=&offset=&sortOrder=&city=&match=&country=&contactName=&propertyTypeId=",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
            ));
            $response = curl_exec($curl); 
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return ["status"=>"400","message"=> $err];
            } else {
                $fillable=["propertyTypeId","name","externalListingName","internalListingName","description","thumbnailUrl","houseRules","keyPickup","specialInstruction","doorSecurityCode","country","countryCode","state","city","street","address","publicAddress","zipcode","price","starRating","weeklyDiscount","monthlyDiscount","propertyRentTax","guestPerPersonPerNightTax","guestStayTax","guestNightlyTax","refundableDamageDeposit","isDepositStayCollected","personCapacity","maxChildrenAllowed","maxInfantsAllowed","maxPetsAllowed","lat","lng","checkInTimeStart","checkInTimeEnd","checkOutTime","cancellationPolicy","squareMeters","roomType","bathroomType","bedroomsNumber","bedsNumber","bathroomsNumber","minNights","maxNights","guestsIncluded","cleaningFee","checkinFee","priceForExtraPerson","instantBookable","instantBookableLeadTime","airbnbBookingLeadTime","airbnbBookingLeadTimeAllowRequestToBook","allowSameDayBooking","sameDayBookingLeadTime","contactName","contactSurName","contactPhone1","contactPhone2","contactLanguage","contactEmail","contactAddress","language","currencyCode","timeZoneName","wifiUsername","wifiPassword","cleannessStatus","cleaningInstruction","cleannessStatusUpdatedOn","homeawayPropertyName","homeawayPropertyHeadline","homeawayPropertyDescription","bookingcomPropertyName","bookingcomPropertyRoomName","bookingcomPropertyDescription","invoicingContactName","invoicingContactSurName","invoicingContactPhone1","invoicingContactPhone2","invoicingContactLanguage","invoicingContactEmail","invoicingContactAddress","invoicingContactCity","invoicingContactZipcode","invoicingContactCountry","attachment","listingAmenities","listingBedTypes","listingImages","listingTags","listingUnits","propertyLicenseNumber","propertyLicenseType","propertyLicenseIssueDate","propertyLicenseExpirationDate","customFieldValues","applyPropertyRentTaxToFees","bookingEngineLeadTime","cancellationPolicyId","partnersListingMarkup","listingFeeSetting","isRentalAgreementActive","averageNightlyPrice","bookingcomPropertyRegisteredInVcs","bookingcomPropertyHasVat","bookingcomPropertyDeclaresRevenue","listingSettings","host_away_id"];
                $data= json_decode($response,true);
                $ids = [];
                if(isset($data['status'])){
                    if($data['status']=="success"){
                        if(isset($data['result'])){
                            $resultData=$data['result'];
                            foreach($resultData as $result){
                                if(isset($result['listingAmenities'])){
                                    $result['listingAmenities']=json_encode($result['listingAmenities']);
                                }
                                if(isset($result['listingBedTypes'])){
                                    $result['listingBedTypes']=json_encode($result['listingBedTypes']);
                                }
                                if(isset($result['listingImages'])){
                                    $result['listingImages']=json_encode($result['listingImages']);
                                }
                                if(isset($result['listingTags'])){
                                    $result['listingTags']=json_encode($result['listingTags']);
                                }
                                if(isset($result['listingUnits'])){
                                    $result['listingUnits']=json_encode($result['listingUnits']);
                                }
                                if(isset($result['customFieldValues'])){
                                    $result['customFieldValues']=json_encode($result['customFieldValues']);
                                }
                                if(isset($result['listingFeeSetting'])){
                                    $result['listingFeeSetting']=json_encode($result['listingFeeSetting']);
                                }
                                if(isset($result['listingSettings'])){
                                    $result['listingSettings']=json_encode($result['listingSettings']);
                                }
                                 $result['title']=$result['name'];
                                if(isset($result['homeawayPropertyName'])){
                                    $result['title']=($result['homeawayPropertyName']);
                                }
                                if(isset($result['id'])){
                                    $result['host_away_id']=($result['id']);
                                    $ids[] = $result['id'];
                                    unset($result['id']);
                                }
                                $new_array=[];
                                foreach($result as $key=>$r){
                                    if(in_array($key, $fillable)){
                                        $new_array[$key]=$r;
                                    }
                                }
                                $review=HostAwayProperty::where("host_away_id",$result['host_away_id'])->first();
                                if($review){
                                    HostAwayProperty::where("host_away_id",$result['host_away_id'])->update($new_array);
                                }else{
                                    $seo_url=Helper::getSeoUrlGet(strtolower(str_replace(" ","-",$result['title'])).'-'.$result['host_away_id']);
                                    $new_array['seo_url']=$seo_url;
                                    $new_array['meta_title']=substr($result['title'],0,60);
                                    $new_array['meta_keywords']=$result['title'];
                                    $new_array['meta_description']=substr($result['description'],0,160);
                                    HostAwayProperty::create($new_array);
                                }
                                //$this->getAllCalendarAPIRun($result['host_away_id']);
                            }
                             HostAwayProperty::whereIn("host_away_id",$ids)->update(["is_active" =>"true"]);
                             HostAwayProperty::whereNotIn("host_away_id",$ids)->update(["is_active" =>"false"]);                             
                            //$this->getReviewList();
                            //$this->getAllBooking();
                        }
                    }
                }
            }
        }
    }

    
    public function getCalendarList(){
        foreach(HostAwayProperty::all() as $result){
            $this->getAllCalendarAPIRun($result['host_away_id']);
        }
    }
  

    public function getPropertyList(){
          $token_data=$this->getBearerToken();
        if($token_data['status']=="200"){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.hostaway.com/v1/listings?limit=&offset=&sortOrder=&city=&match=&country=&contactName=&propertyTypeId=",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return ["status"=>"400","message"=> $err];
            }else{
                $fillable=["propertyTypeId","name","externalListingName","internalListingName","description","thumbnailUrl","houseRules","keyPickup","specialInstruction","doorSecurityCode","country","countryCode","state","city","street","address","publicAddress","zipcode","price","starRating","weeklyDiscount","monthlyDiscount","propertyRentTax","guestPerPersonPerNightTax","guestStayTax","guestNightlyTax","refundableDamageDeposit","isDepositStayCollected","personCapacity","maxChildrenAllowed","maxInfantsAllowed","maxPetsAllowed","lat","lng","checkInTimeStart","checkInTimeEnd","checkOutTime","cancellationPolicy","squareMeters","roomType","bathroomType","bedroomsNumber","bedsNumber","bathroomsNumber","minNights","maxNights","guestsIncluded","cleaningFee","checkinFee","priceForExtraPerson","instantBookable","instantBookableLeadTime","airbnbBookingLeadTime","airbnbBookingLeadTimeAllowRequestToBook","allowSameDayBooking","sameDayBookingLeadTime","contactName","contactSurName","contactPhone1","contactPhone2","contactLanguage","contactEmail","contactAddress","language","currencyCode","timeZoneName","wifiUsername","wifiPassword","cleannessStatus","cleaningInstruction","cleannessStatusUpdatedOn","homeawayPropertyName","homeawayPropertyHeadline","homeawayPropertyDescription","bookingcomPropertyName","bookingcomPropertyRoomName","bookingcomPropertyDescription","invoicingContactName","invoicingContactSurName","invoicingContactPhone1","invoicingContactPhone2","invoicingContactLanguage","invoicingContactEmail","invoicingContactAddress","invoicingContactCity","invoicingContactZipcode","invoicingContactCountry","attachment","listingAmenities","listingBedTypes","listingImages","listingTags","listingUnits","propertyLicenseNumber","propertyLicenseType","propertyLicenseIssueDate","propertyLicenseExpirationDate","customFieldValues","applyPropertyRentTaxToFees","bookingEngineLeadTime","cancellationPolicyId","partnersListingMarkup","listingFeeSetting","isRentalAgreementActive","averageNightlyPrice","bookingcomPropertyRegisteredInVcs","bookingcomPropertyHasVat","bookingcomPropertyDeclaresRevenue","listingSettings","host_away_id"];
                $data= json_decode($response,true);
                if(isset($data['status'])){
                    if($data['status']=="success"){
                        if(isset($data['result'])){
                            $resultData=$data['result'];
                            foreach($resultData as $result){
                                if(isset($result['listingAmenities'])){
                                    $result['listingAmenities']=json_encode($result['listingAmenities']);
                                }
                                if(isset($result['listingBedTypes'])){
                                    $result['listingBedTypes']=json_encode($result['listingBedTypes']);
                                }
                                if(isset($result['listingImages'])){
                                    $result['listingImages']=json_encode($result['listingImages']);
                                }
                                if(isset($result['listingTags'])){
                                    $result['listingTags']=json_encode($result['listingTags']);
                                }
                                if(isset($result['listingUnits'])){
                                    $result['listingUnits']=json_encode($result['listingUnits']);
                                }
                                if(isset($result['customFieldValues'])){
                                    $result['customFieldValues']=json_encode($result['customFieldValues']);
                                }
                                if(isset($result['listingFeeSetting'])){
                                    $result['listingFeeSetting']=json_encode($result['listingFeeSetting']);
                                }
                                if(isset($result['listingSettings'])){
                                    $result['listingSettings']=json_encode($result['listingSettings']);
                                }
                                $result['title']=$result['name'];
                                if(isset($result['homeawayPropertyName'])){
                                    $result['title']=($result['homeawayPropertyName']);
                                }
                                if(isset($result['id'])){
                                    $result['host_away_id']=($result['id']);
                                    unset($result['id']);
                                }
                                $new_array=[];
                                foreach($result as $key=>$r){
                                    if(in_array($key, $fillable)){
                                        $new_array[$key]=$r;
                                    }
                                }
                                $review=HostAwayProperty::where("host_away_id",$result['host_away_id'])->first();
                                if($review){
                                    HostAwayProperty::where("host_away_id",$result['host_away_id'])->update($new_array);
                                }else{
                                    $seo_url=Helper::getSeoUrlGet(strtolower(str_replace(" ","-",$result['title'])).'-'.$result['host_away_id']);
                                    $new_array['seo_url']=$seo_url;
                                    HostAwayProperty::create($new_array);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
  
    public function getAllCalendarAPIRun($listingid){
        $curl = curl_init();
        $today=date('Y-m-01');
        $year=date('Y');
        $next=(date('Y-m-01',strtotime(($year+3).date('-m-')."01")));
        $token_data=$this->getBearerToken();
        $url=("https://api.hostaway.com/v1/listings/".$listingid."/calendar?startDate=".$today."&endDate=".$next."&includeResources=");
        if($token_data['status']=="200"){
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return ["status"=>"400","message"=> $err,"data"=>$new_array];
            } else {
                $fillable=["host_away_id"];
                $data= json_decode($response,true);
                if(isset($data['status'])){
                    if($data['status']=="success"){
                        if(isset($data['result'])){
                            foreach($data['result'] as $d){
                                $single_date=$d['date'];
                                $data_date=HostAwayDate::where("single_date",$single_date)->where("hostaway_id",$listingid)->first();
                                 $ar=['minimumStay'=>$d['minimumStay'],'single_date'=>$single_date,'isAvailable'=>$d['isAvailable'],'status'=>$d['status'],'price'=>$d['price'],'hostaway_id'=>$listingid,];
                                if($data_date){
                                    HostAwayDate::where("single_date",$single_date)->where("hostaway_id",$listingid)->update($ar);
                                }else{
                                    HostAwayDate::create($ar);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getSearchPropertiesList($start_date,$end_date,$guest){
        $new_array=[];
        $token_data=$this->getBearerToken();
        if($token_data['status']=="200"){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.hostaway.com/v1/listings?availabilityDateStart=".$start_date."&availabilityDateEnd=".$end_date."&availabilityGuestNumber=".$guest,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return ["status"=>"400","message"=> $err,"data"=>$new_array];
            }else {
                $fillable=["host_away_id"];
                $data= json_decode($response,true);
                if(isset($data['status'])){
                    if($data['status']=="success"){
                        if(isset($data['result'])){
                            $resultData=$data['result'];
                            foreach($resultData as $result){
                                $new_array[]=$result['id'];
                            }
                            return ["status"=>"200","message"=> "Success","data"=>$new_array];
                        }
                    }
                }
                return ["status"=>"400","message"=> "something happen","data"=>$new_array];
            }
        }
    }

    public function getSinglePropertyDetail($listing_id){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/listings/".$listing_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data= json_decode($response,true);
            dd($data);
        }
    }

    public function getAllBooking(){
        $fillable=["listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",];
        $data=$this->getBookingLimitData(0,10);
        if($data['status']==200){
            $data=$data['data'];
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['count'])){
                        $total=$data['count'];
                        for($i=0;$i<=$total;$i+=100){
                            $start=$i;
                            $limit=100;
                            $new_loop_data=$this->getBookingLimitData($start,$limit);;
                            if($new_loop_data['status']==200){
                                $data=$new_loop_data['data'];
                                 if(isset($data['status'])){
                                    if($data['status']=="success"){
                                        if(isset($data['result'])){
                                            $resultData=$data['result'];
                                            foreach($resultData as $result){
                                                if(isset($result['financeField'])){
                                                    $result['financeField']=json_encode($result['financeField']);
                                                }
                                                if(isset($result['customFieldValues'])){
                                                    $result['customFieldValues']=json_encode($result['customFieldValues']);
                                                }
                                                if(isset($result['reservationFees'])){
                                                    $result['reservationFees']=json_encode($result['reservationFees']);
                                                }
                                                if(isset($result['reservationUnit'])){
                                                    $result['reservationUnit']=json_encode($result['reservationUnit']);
                                                }
                                                if(isset($result['id'])){
                                                    $result['host_away_id']=($result['id']);
                                                    unset($result['id']);
                                                }
                                                HostAwayBooking::where("host_away_id",$result['host_away_id'])->delete();
                                                $new_array=[];
                                                foreach($result as $key=>$r){
                                                    if(in_array($key, $fillable)){
                                                        $new_array[$key]=$r;
                                                    }
                                                }
                                                $review=HostAwayBooking::where("host_away_id",$result['host_away_id'])->first();
                                                if($review){
                                                    HostAwayBooking::where("host_away_id",$result['host_away_id'])->update($new_array);
                                                }else{
                                                    HostAwayBooking::create($new_array);
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
        }
    }
    
    function getBookingLimitData($start,$limit){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/reservations?limit=".$limit."&offset=".$start."&order=&channelId=&listingId=&arrivalStartDate=&arrivalEndDate=&departureStartDate=&departureEndDate=&hasUnreadConversationMessages=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        } else {
            $data= json_decode($response,true);
            return ["status"=>200,"data"=>$data];
        }
    }

    public function getCalculateReservationPrice($listing_id,$partnersListingMarkup,$start_date,$end_date,$no_of_guests,$coupon_id=""){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        if($coupon_id!=""){
            $coupon_id=' ,"reservationCouponId": '.$coupon_id;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/listings/".$listing_id."/calendar/priceDetails",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"startingDate": "'.$start_date.'", "endingDate": "'.$end_date.'", "numberOfGuests": '.$no_of_guests.$coupon_id.', "markup": '.$partnersListingMarkup.', "version": 2}',
            CURLOPT_HTTPHEADER => array("Authorization: Bearer  ".$token_data['token'])
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        } else {
            $data= json_decode($response,true);
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['result'])){
                        $resultData=$data['result'];
                        return ["status"=>"200","message"=> "Success","data"=>$resultData];
                    }
                }
            }
            return ["status"=>"400","message"=> "something happen"];
        }
    }

    public function getCalculateReservationPrice124($listing_id,$start_date,$end_date,$no_of_guests){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/listings/".$listing_id."/calendar/priceDetails",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"startingDate": "'.$start_date.'", "endingDate": "'.$end_date.'", "numberOfGuests": '.$no_of_guests.', "markup": 1, "version": 2}',
            CURLOPT_HTTPHEADER => array("Authorization: Bearer  ".$token_data['token'])
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else {
            $data= json_decode($response,true);
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['result'])){
                        $resultData=$data['result'];
                        return ["status"=>"200","message"=> "Success","data"=>$resultData];
                    }
                }
            }
            return ["status"=>"400","message"=> "something happen"];
        }
    }

    public function getCancelationPolicyData(){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/cancellationPolicies",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else {
            $fillable=["host_away_id","accountId","name","cancellationPolicyItem",];
            $data= json_decode($response,true);
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['result'])){
                        $resultData=$data['result'];
                        foreach($resultData as $result){
                            if(isset($result['cancellationPolicyItem'])){
                                $result['cancellationPolicyItem']=json_encode($result['cancellationPolicyItem']);
                            }
                            if(isset($result['id'])){
                                $result['host_away_id']=($result['id']);
                                unset($result['id']);
                            }
                            $new_array=[];
                            foreach($result as $key=>$r){
                                if(in_array($key, $fillable)){
                                    $new_array[$key]=$r;
                                }
                            }
                            $review=HostAwayCalcelationPolicy::where("host_away_id",$result['host_away_id'])->first();
                            if($review){
                                HostAwayCalcelationPolicy::where("host_away_id",$result['host_away_id'])->update($new_array);
                            }else{
                                HostAwayCalcelationPolicy::create($new_array);
                            }
                        }
                        return ["status"=>"200","message"=> "Success"];
                    }
                }
            }
            return ["status"=>"400","message"=> "something happen"];
        }
    }

    public function getOwnerStatements(){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/ownerStatements",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data= json_decode($response,true);
        }
    }


   
    public function getReviewList(){
        $fillable=["host_away_id","accountId","listingMapId","reservationId","reviewerName","channelId","type","status","rating","title","publicReview","privateFeedback","revieweeResponse","submittedAt","insertedOn","updatedOn","reviewCategory","listingName","departureDate","arrivalDate","internalListingName","externalListingName","guestName"];
        $data=$this->getReviewLimitData(0,10);
        if($data['status']==200){
            $data=$data['data'];
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['count'])){
                        $total=$data['count'];
                        for($i=0;$i<=$total;$i+=400){
                            $start=$i;
                            $limit=400;
                            $new_loop_data=$this->getReviewLimitData($start,$limit);;
                            if($new_loop_data['status']==200){
                                $data=$new_loop_data['data'];
                                if(isset($data['status'])){
                                    if($data['status']=="success"){
                                        if(isset($data['result'])){
                                            $resultData=$data['result'];
                                            foreach($resultData as $result){
                                                if(isset($result['reviewCategory'])){
                                                    $result['reviewCategory']=json_encode($result['reviewCategory']);
                                                }
                                                if(isset($result['id'])){
                                                    $result['host_away_id']=($result['id']);
                                                    unset($result['id']);
                                                }
                                                HostAwayReview::where("host_away_id",$result['host_away_id'])->delete();
                                                $new_array=[];
                                                foreach($result as $key=>$r){
                                                    if(in_array($key, $fillable)){
                                                        $new_array[$key]=$r;
                                                    }
                                                }
                                                $review=HostAwayReview::where("host_away_id",$result['host_away_id'])->first();
                                                if($review){
                                                    HostAwayReview::where("host_away_id",$result['host_away_id'])->update($new_array);
                                                }else{
                                                    HostAwayReview::create($new_array);
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
        }
    }

    public function getReviewLimitData($start,$limit){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/reviews?limit=".$limit."&offset=".$start,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else{
            $data= json_decode($response,true);
            return ["status"=>200,"data"=>$data];
        }
    }

    public function getReviewList124(){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/reviews?limit=1000",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else {
            $fillable=["host_away_id","accountId","listingMapId","reservationId","reviewerName","channelId","type","status","rating","title","publicReview","privateFeedback","revieweeResponse","submittedAt","insertedOn","updatedOn","reviewCategory","listingName","departureDate","arrivalDate","internalListingName","externalListingName","guestName", ];
            $data= json_decode($response,true);
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['result'])){
                        $resultData=$data['result'];
                        foreach($resultData as $result){
                            if(isset($result['reviewCategory'])){
                                $result['reviewCategory']=json_encode($result['reviewCategory']);
                            }
                            if(isset($result['id'])){
                                $result['host_away_id']=($result['id']);
                                unset($result['id']);
                            }
                            HostAwayReview::where("host_away_id",$result['host_away_id'])->delete();
                            $new_array=[];
                            foreach($result as $key=>$r){
                                if(in_array($key, $fillable)){
                                    $new_array[$key]=$r;
                                }
                            }
                            $review=HostAwayReview::where("host_away_id",$result['host_away_id'])->first();
                            if($review){
                                HostAwayReview::where("host_away_id",$result['host_away_id'])->update($new_array);
                            }else{
                                HostAwayReview::create($new_array);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getCouponList(){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/coupons",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        } else {
            $fillable=["host_away_id","accountId","listingMapId","reservationId","reviewerName","channelId","type","status","rating","title","publicReview","privateFeedback","revieweeResponse","submittedAt","insertedOn","updatedOn","reviewCategory","listingName","departureDate","arrivalDate","internalListingName","externalListingName","guestName",];
            $data= json_decode($response,true);
            if(isset($data['status'])){
                if($data['status']=="success"){
                    if(isset($data['result'])){
                        return ["status"=>"200","message"=> "Success"];
                    }
                }
            }
            return ["status"=>"400","message"=> "something happen"];
        }
    }

    public function addCreditCardForBooking($booking_id,$card_name,$card_number,$card_expiry_year,$card_expiry_month,$card_cvv){
        $token_data=$this->getBearerToken();
        $data="{\n    \"ccName\": \"".$card_name."\",\n    \"ccNumber\": \"".$card_number."\",\n    \"ccExpirationYear\": \"".$card_expiry_year."\",\n    \"ccExpirationMonth\": \"".$card_expiry_month."\",\n    \"ccCvc\": \"".$card_cvv."\",\n    \"isDefault\": 1\n}";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.hostaway.com/v1/paymentCards/".$booking_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err) {
            return ["status"=>"400","message"=> $err];
        }else {
            $data= json_decode($response,true);
            return ["status"=>"200","message"=> "Success","data"=>$data];
        }
    }

    public function createCouponReservation($coupon_name,$listingid,$start_date,$end_date){
        $token_data=$this->getBearerToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.hostaway.com/v1/reservationCoupons',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"couponName": "'.$coupon_name.'","listingMapId": '.$listingid.', "startingDate": "'.$start_date.'","endingDate": "'.$end_date.'"}',
            CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token_data['token'],"cache-control: no-cache")
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ["status"=>"400","message"=> $err];
        }else {
            $data= json_decode($response,true);
            if($data['status']=="fail"){
                  return ["status"=>"400","message"=> $data['message']];
            }else{
                if(isset($data['result'])){
                    if(isset($data['result']['reservationCouponId'])){
                        return ["status"=>200,"data"=>$data['result']['reservationCouponId']];
                    }
                }
            }
            return ["status"=>400,"message"=>"Invalid Coupon"];
        }
    }
}