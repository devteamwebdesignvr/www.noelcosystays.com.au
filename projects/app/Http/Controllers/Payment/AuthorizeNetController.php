<?php
namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingRequest;
use App\Models\Property;
use App\Models\Payment;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Session;
use ModelHelper;
use MailHelper;

class AuthorizeNetController extends Controller{
  
    public function index(Request $request,$id){
        if(ModelHelper::getDataFromSetting('which_payment_gateway')=="stripe"){return redirect()->route("stripe_payment",$id);}
        if(ModelHelper::getDataFromSetting('which_payment_gateway')=="paypal"){return redirect()->route("paypal_payment",$id);}
        $booking=BookingRequest::find($id);
        if($booking){
            $property=Property::find($booking->property_id);
            if($property){
                $data = new \stdClass();
                $data->name=" Payment Request ";
                $data->meta_title=" Payment Request ";
                $data->meta_keywords=" Payment Request ";
                $data->meta_description=" Payment Request ";
                $booking=$booking->toArray();
                return view("front.booking.payment.authorize",compact("booking","data","property"));
            }
        }
        return abort(404);
    }

    public function indexPost(Request $request,$id){
        $booking=BookingRequest::find($id);
        if($booking){
            $property=Property::find($booking->property_id);
            if($property){
              try{
                   $input = $request->input();

                  /* Create a merchantAuthenticationType object with authentication details
                    retrieved from the constants file */
                  $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                  $merchantAuthentication->setName(ModelHelper::getDataFromSetting('AUTHORIZED_MERCHANT_LOGIN_ID'));
                  $merchantAuthentication->setTransactionKey(ModelHelper::getDataFromSetting('AUTHORIZED_MERCHANT_TRANSACTION_KEY'));

                  // Set the transaction's refId
                  $refId = 'ref' . time();
                  $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);

                  // Create the payment data for a credit card
                  $creditCard = new AnetAPI\CreditCardType();
                  $creditCard->setCardNumber($cardNumber);
                  $creditCard->setExpirationDate($input['expiration-year'] . "-" .$input['expiration-month']);
                  $creditCard->setCardCode($input['cvv']);

                  // Add the payment data to a paymentType object
                  $paymentOne = new AnetAPI\PaymentType();
                  $paymentOne->setCreditCard($creditCard);

                  // Create a TransactionRequestType object and add the previous objects to it
                  $transactionRequestType = new AnetAPI\TransactionRequestType();
                  $transactionRequestType->setTransactionType("authCaptureTransaction");
                  $transactionRequestType->setAmount($input['amount']);
                  $transactionRequestType->setPayment($paymentOne);

                  // Assemble the complete transaction request
                  $requests = new AnetAPI\CreateTransactionRequest();
                  $requests->setMerchantAuthentication($merchantAuthentication);
                  $requests->setRefId($refId);
                  $requests->setTransactionRequest($transactionRequestType);

                  // Create the controller and get the response
                  $controller = new AnetController\CreateTransactionController($requests);
                  if(ModelHelper::getDataFromSetting('environment_stage')=="SANDBOX"){
                      $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                  }else{
                      $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                  }
                  if ($response != null) {
                      // Check to see if the API request was successfully received and acted upon
                      if ($response->getMessages()->getResultCode() == "Ok") {
                          // Since the API request was successful, look for a transaction response
                          // and parse it to display the results of authorizing the card
                          $tresponse = $response->getTransactionResponse();
                          if ($tresponse != null && $tresponse->getMessages() != null) {
                              $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                              $msg_type = "success_msg";    
                              $payment=Payment::create(['booking_id'=>$booking->id,'receipt_url'=>'' ,'customer_id'=>'' ,'amount'=>$input['amount'],'tran_id'=>$tresponse->getTransId(),'description'=>json_encode($request->all()),'type'=>"authorize",'status'=>"complete"]);
                              ModelHelper::finalEmailAndUpdateBookingPayment($id,$booking,$payment,$property);
                              return redirect('payment/success/'.$payment->id)->with("success","successfully Payment");
                          } else {
                              $message_text = 'There were some issue with the payment. Please try again later.';
                              $msg_type = "error_msg";                                    
                              if ($tresponse->getErrors() != null) {
                                  $message_text = $tresponse->getErrors()[0]->getErrorText();
                                  $msg_type = "error_msg";                                    
                              }
                          }
                          // Or, print errors if the API request wasn't successful
                      } else {
                          $message_text = 'There were some issue with the payment. Please try again later.';
                          $msg_type = "error_msg";                                    
                          $tresponse = $response->getTransactionResponse();
                          if ($tresponse != null && $tresponse->getErrors() != null) {
                              $message_text = $tresponse->getErrors()[0]->getErrorText();
                              $msg_type = "error_msg";                    
                          } else {
                              $message_text = $response->getMessages()->getMessage()[0]->getText();
                              $msg_type = "error_msg";
                          }                
                      }
                  } else {
                      $message_text = "No response returned";
                      $msg_type = "error_msg";
                  }
                  return back()->with($msg_type, $message_text);
              }catch(Exception $e){
                  $message =$e->getError()->message ;
              }
           }else{
              $message="property is not longer";
           }
        }else{
            $message="Booking is invalid";
        }
        return redirect()->back()->with("danger",$message);
    }
}
