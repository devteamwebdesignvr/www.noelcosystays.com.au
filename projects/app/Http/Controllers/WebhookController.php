<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Models\HostAway\HostAwayBooking;
use App\Models\HostAway\HostAway2Booking;


class WebhookController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth'); // later enable it when needed user login
    }

    public function setWebhooks(Request $request){
                      
        Log::channel('hostaway_webhooks')->info('Hostaway Webhook Received', [           
            'payload' => $request->all(),
        ]); 
        
         /**if(! $this->verifyHostawaySignature($request)) {
            Log::channel('hostaway_webhooks')->warning('Hostaway Webhook: Invalid Signature', [
                'ip' => $request->ip(),
                'payload' => $request->all(),
            ]);
            return response()->json(['error' => 'Invalid signature'], Response::HTTP_UNAUTHORIZED);
        } **/
        
        $eventType = $request->header('X-Hostaway-Event');
          
        $payload = $request->all();
      
        if (isset($payload['event']) && is_string($payload['event'])) {
             $eventType = $payload['event'];
        } else {
             $eventType = 'unknown_event_type';
        }

        Log::channel('hostaway_webhooks')->info("Hostaway Webhook Event Type: {$eventType}");
      
        try {             
            switch ($eventType) {
                case 'reservation.created':
                    $this->handleReservationCreate($payload);
                    break;
                case 'reservation.updated':
                    $this->handleReservationUpdated($payload);
                    break;
              
                default:
                    Log::info('Hostaway Webhook: Unhandled Event Type', ['event_type' => $eventType]);
                    break;
            }
          
            return response()->json(['message' => 'Webhook received successfully'], Response::HTTP_OK);

        } catch (\Exception $e) {
           Log::channel('hostaway_webhooks')->error('Hostaway Webhook Processing Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload,
            ]);          
            return response()->json(['error' => 'Internal server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }  
    
   public function handleReservationCreate($payload){
        Log::channel('hostaway_webhooks')->info("Insert Function", $payload);

        if (!isset($payload['data'])) return;

        $result = $payload['data'];
        Log::channel('hostaway_webhooks')->info("POST_VALUE", $result);

        // Fields that need to be stored as JSON strings
        $jsonFields = [
            'financeField',
            'customFieldValues',
            'reservationFees',
            'reservationUnit',
            'listingCustomFields',
        ];

        foreach ($jsonFields as $field) {
            if (isset($result[$field]) && is_array($result[$field])) {
                $result[$field] = json_encode($result[$field]);
            }
        }

        // Move `id` to `host_away_id` if it exists
        if (isset($result['id'])) {
            $result['host_away_id'] = $result['id'];
            unset($result['id']);
        }

        // Allowed fields in DB
        $fillable=["listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",];
        // Filter allowed keys only
        $new_array = array_intersect_key($result, array_flip($fillable));
        Log::channel('hostaway_webhooks')->info("Insert_value", $new_array);
     
        foreach ($new_array as $key => $val) {
            if (is_array($val)) {
                Log::channel('hostaway_webhooks')->error("Field '{$key}' is still an array!", ['value' => $val]);
            }
        }

        try {
            $existing = HostAwayBooking::where("host_away_id", $new_array['host_away_id'])->first();
            if ($existing) {
                $existing->update($new_array);
            } else {
                HostAwayBooking::create($new_array);
            }
            Log::channel('hostaway_webhooks')->info("INSERT Result", 'OK');
        } catch (\Exception $e) {
            Log::channel('hostaway_webhooks')->error("Hostaway Webhook Processing Error insert function", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

     public function handleReservationUpdated($payload){
        Log::channel('hostaway_webhooks')->info("Update Function", $payload);

        if (!isset($payload['data'])) return;

        $result = $payload['data'];
        Log::channel('hostaway_webhooks')->info("POST_VALUE", $result);

        // Fields that need to be stored as JSON strings
        $jsonFields = [
            'financeField',
            'customFieldValues',
            'reservationFees',
            'reservationUnit',
            'listingCustomFields',
        ];

        foreach ($jsonFields as $field) {
            if (isset($result[$field]) && is_array($result[$field])) {
                $result[$field] = json_encode($result[$field]);
            }
        }

        // Move `id` to `host_away_id` if it exists
        if (isset($result['id'])) {
            $result['host_away_id'] = $result['id'];
            unset($result['id']);
        }

        // Allowed fields in DB
        $fillable=["listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",];
        // Filter allowed keys only
        $new_array = array_intersect_key($result, array_flip($fillable));
        Log::channel('hostaway_webhooks')->info("Insert_value", $new_array);

        try {
            $existing = HostAwayBooking::where("host_away_id", $new_array['host_away_id'])->first();
            if ($existing) {
                $existing->update($new_array);
            } else {
                HostAwayBooking::create($new_array);
            }
            Log::channel('hostaway_webhooks')->info("Update Result", 'OK');
        } catch (\Exception $e) {
            Log::channel('hostaway_webhooks')->error("Hostaway Webhook Processing Error while update function", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

  
   public function handleReservationCreateOld($payload){
       Log::channel('hostaway_webhooks')->info("Insert Function", $payload); 
       if(isset($payload['data'])){
           Log::channel('hostaway_webhooks')->info("POST_VALUE", $payload['data']); 
           $fillable=["listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",];
       	   $result = $payload['data'];
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

           $new_array=[];
           foreach($result as $key=>$r){
             if(in_array($key, $fillable)){
               $new_array[$key]=$r;
             }
           }
           Log::channel('hostaway_webhooks')->info("Insert_value", $new_array); 
           $review=HostAway2Booking::where("host_away_id",$result['host_away_id'])->first();
           if($review){
               HostAway2Booking::where("host_away_id",$result['host_away_id'])->update($new_array);
           }else{
               HostAway2Booking::create($new_array);
           }
            Log::channel('hostaway_webhooks')->info("INSERT Result", 'OK'); 
       }
   }
  
   public function handleReservationUpdatedOld($payload){
       Log::channel('hostaway_webhooks')->info("Update Function", $payload);
        $reservationId = '';
        if(isset($payload['data'])){
              Log::channel('hostaway_webhooks')->info("POST_VALUE_UPDATE", $payload['data']); 
              if(isset($payload['data']['reservationId'])){
                 $reservationId = $payload['data']['reservationId'];

                 $fillable=["listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",];
                 $result = $payload['data'];
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

                 $new_array=[];
                 foreach($result as $key=>$r){
                   if(in_array($key, $fillable)){
                     $new_array[$key]=$r;
                   }
                 }
                 Log::channel('hostaway_webhooks')->info("UPDATE_RESERVATION", $new_array); 
                 $review=HostAway2Booking::where("host_away_id",$result['host_away_id'])->first();
                 if($review){
                     HostAway2Booking::where("host_away_id",$result['host_away_id'])->update($new_array);
                 }else{
                     HostAway2Booking::create($new_array);
                 }
                 Log::channel('hostaway_webhooks')->info("Update Result", 'OK'); 
             }
        }
   }

  
   protected function verifyHostawaySignature(Request $request): bool
    {
        $expectedSignature = $request->header('X-Hostaway-Signature'); // Or whatever header Hostaway uses
        $secret = '8e025d422b0a327f0cbdc7e2a7428ce236df165dd64db3f0caafb0ac1b672a01';
        if (!$expectedSignature || !$secret) {
            return false; // No signature or secret configured
        }
       
        $payload = $request->getContent();
        $calculatedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expectedSignature, $calculatedSignature);
    } 
  
      
   public function handleReservationCancelled($payload){
  
   }
   
   public function handlePaymentCreateds($payload){
  
   } 
  
  
   public function test(){
      $payload = file_get_contents(storage_path('app/hostaway_demo.json'));
      $data = json_decode($payload, true);
      
      $result = $data['payload']['data'];
      dd($result);
     
      $jsonFields = [
        'financeField',
        'customFieldValues',
        'reservationFees',
        'reservationUnit',
        'listingCustomFields',
     ];

      // Encode arrays
      foreach ($jsonFields as $field) {
          if (isset($result[$field]) && is_array($result[$field])) {
              $result[$field] = json_encode($result[$field]);
          }
      }

      // Map ID to host_away_id
      if (isset($result['id'])) {
          $result['host_away_id'] = $result['id'];
          unset($result['id']);
      }

      // Fillable fields list (copy yours exactly)
      $fillable=["listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",];
       	   
      // Keep only allowed fields
      $new_array = array_intersect_key($result, array_flip($fillable));

      // Failsafe: auto-encode any remaining arrays
      foreach ($new_array as $key => &$val) {
          if (is_array($val)) {
              Log::info("Auto-encoding field: $key");
              $val = json_encode($val);
          }
      }
      unset($val); // clear reference

      // Insert or update
      try {
          $existing = HostAway2Booking::where("host_away_id", $new_array['host_away_id'])->first();
          if ($existing) {
              $existing->update($new_array);
          } else {
              HostAway2Booking::create($new_array);
          }
          return response()->json(['status' => 'success']);
      } catch (\Exception $e) {
          Log::error("Demo Insert Failed", [
              'error' => $e->getMessage(),
              'trace' => $e->getTraceAsString(),
          ]);
          return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
      }
   }
   
}