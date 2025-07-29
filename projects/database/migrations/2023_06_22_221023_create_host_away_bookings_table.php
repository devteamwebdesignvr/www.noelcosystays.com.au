<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('host_away_bookings', function (Blueprint $table) {
            $table->id();

            $table->string("listingMapId",50)->nullable();
            $table->string("listingName",100)->nullable();
            $table->string("channelId",50)->nullable();
            $table->string("source",100)->nullable();
            $table->string("channelName",100)->nullable();
            $table->string("reservationId",50)->nullable();
            $table->string("hostawayReservationId",50)->nullable();
            $table->string("channelReservationId",50)->nullable();
            $table->string("externalPropertyId",50)->nullable();
            $table->string("externalUnitId",50)->nullable();
            $table->string("assigneeUserId",50)->nullable();
            $table->string("customerIcalId",50)->nullable();
            $table->string("customerIcalName",100)->nullable();

            $table->string("guestPortalRevampUrl",100)->nullable();
            $table->double("isProcessed")->nullable();
            $table->double("isInitial")->nullable();
            $table->double("isManuallyChecked")->nullable();
            $table->double("isInstantBooked")->nullable();
            $table->string("reservationDate",100)->nullable();
            $table->string("pendingExpireDate",100)->nullable();
            $table->string("guestName",100)->nullable();
            $table->string("guestFirstName",100)->nullable();
            $table->string("guestLastName",100)->nullable();
            $table->string("guestExternalAccountId",50)->nullable();
            $table->string("guestZipCode",100)->nullable();
            $table->string("guestAddress",100)->nullable();
            $table->string("guestCity",100)->nullable();
            $table->string("guestCountry",100)->nullable();
            $table->string("guestEmail",100)->nullable();
            
            $table->string("guestRecommendations",100)->nullable();
            $table->string("guestTrips",100)->nullable();
            $table->string("guestWork",100)->nullable();
            $table->double("isGuestIdentityVerified")->nullable();
            $table->double("isGuestVerifiedByEmail")->nullable();
            $table->double("isGuestVerifiedByWorkEmail")->nullable();
            $table->double("isGuestVerifiedByFacebook")->nullable();
            $table->double("originalChannel")->nullable();
            $table->double("isGuestVerifiedByGovernmentId",50)->nullable();
            $table->double("isGuestVerifiedByPhone")->nullable();
            $table->double("isGuestVerifiedByReviews")->nullable();
            $table->double("numberOfGuests")->nullable();
            $table->double("adults")->nullable();
            $table->double("children")->nullable();
            $table->double("infants")->nullable();
            $table->double("pets")->nullable();
            $table->date("arrivalDate")->nullable();
            $table->date("departureDate")->nullable();
            $table->string("isDatesUnspecified")->nullable();
            $table->date("previousArrivalDate")->nullable();
            $table->date("previousDepartureDate")->nullable();
            $table->string("checkInTime")->nullable();
            $table->string("checkOutTime")->nullable();
            $table->string("nights")->nullable();
            $table->string("phone")->nullable();
            $table->string("totalPrice")->nullable();
            $table->string("remainingBalance")->nullable();
            $table->string("taxAmount")->nullable();
            $table->string("channelCommissionAmount")->nullable();
            $table->string("hostawayCommissionAmount")->nullable();
            $table->string("cleaningFee")->nullable();
            $table->string("securityDepositFee")->nullable();
            $table->string("isPaid",50)->nullable();
            $table->string("ccName")->nullable();
            $table->string("ccNumber")->nullable();
            $table->string("ccNumberEndingDigits")->nullable();
            $table->string("ccExpirationYear")->nullable();
            $table->string("ccExpirationMonth")->nullable();
            $table->string("cvc")->nullable();
            $table->string("stripeGuestId",50)->nullable();
            $table->string("stripeMessage")->nullable();
            $table->string("braintreeGuestId",50)->nullable();
            $table->string("braintreeMessage")->nullable();
            $table->string("currency")->nullable();
            $table->string("status")->nullable();
            $table->string("paymentStatus")->nullable();
            $table->string("cancellationDate")->nullable();
            $table->string("cancelledBy")->nullable();
            $table->text("hostNote")->nullable();
            $table->text("guestNote")->nullable();
            $table->string("doorCode")->nullable();
            $table->string("doorCodeVendor")->nullable();
            $table->string("doorCodeInstruction")->nullable();
            $table->string("comment")->nullable();
            $table->string("confirmationCode")->nullable();
            $table->string("airbnbExpectedPayoutAmount")->nullable();
            $table->string("airbnbListingBasePrice")->nullable();
            $table->string("airbnbListingCancellationHostFee")->nullable();
            $table->string("airbnbListingCancellationPayout")->nullable();
            $table->string("airbnbListingCleaningFee")->nullable();
            $table->string("airbnbListingHostFee")->nullable();
            $table->string("airbnbListingSecurityPrice")->nullable();
            $table->string("airbnbOccupancyTaxAmountPaidToHost")->nullable();
            $table->string("airbnbTotalPaidAmount")->nullable();
            $table->string("airbnbTransientOccupancyTaxPaidAmount")->nullable();
            $table->string("airbnbCancellationPolicy")->nullable();
            $table->string("isStarred")->nullable();
            $table->string("isArchived")->nullable();
            $table->string("isPinned")->nullable();
            $table->string("reservationCouponId",50)->nullable();
          
            $table->string("insertedOn")->nullable();
            $table->string("updatedOn")->nullable();
            $table->string("latestActivityOn")->nullable();
            $table->string("customerUserId",50)->nullable();
            $table->text("guestLocale")->nullable();
            $table->text("localeForMessaging")->nullable();
            $table->text("localeForMessagingSource")->nullable();
            $table->text("listingCustomFields")->nullable();
            $table->text("rentalAgreementFileUrl")->nullable();
            $table->text("reservationAgreement")->nullable();
           

            $table->string("host_away_id",50)->nullable();


            $table->longText("financeField")->nullable();
            $table->longText("customFieldValues")->nullable();
            $table->longText("reservationFees")->nullable();
            $table->longText("reservationUnit")->nullable();

             $table->text("guestAuthHash")->nullable();
            $table->text("guestPortalUrl")->nullable();
            $table->text("guestPicture")->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('host_away_bookings');
    }
};
