<?php

namespace App\Models\HostAway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostAwayBooking extends Model
{
    use HasFactory;

    public $fillable=[
"listingMapId","listingName","channelId","source","channelName","reservationId","hostawayReservationId","channelReservationId","externalPropertyId","externalUnitId","assigneeUserId","customerIcalId","customerIcalName","guestAuthHash","guestPortalUrl","guestPortalRevampUrl","isProcessed","isInitial","isManuallyChecked","isInstantBooked","reservationDate","pendingExpireDate","guestName","guestFirstName","guestLastName","guestExternalAccountId","guestZipCode","guestAddress","guestCity","guestCountry","guestEmail","guestPicture","guestRecommendations","guestTrips","guestWork","isGuestIdentityVerified","isGuestVerifiedByEmail","isGuestVerifiedByWorkEmail","isGuestVerifiedByFacebook","originalChannel","isGuestVerifiedByGovernmentId","isGuestVerifiedByPhone","isGuestVerifiedByReviews","numberOfGuests","adults","children","infants","pets","arrivalDate","departureDate","isDatesUnspecified","previousArrivalDate","previousDepartureDate","checkInTime","checkOutTime","nights","phone","totalPrice","remainingBalance","taxAmount","channelCommissionAmount","hostawayCommissionAmount","cleaningFee","securityDepositFee","isPaid","ccName","ccNumber","ccNumberEndingDigits","ccExpirationYear","ccExpirationMonth","cvc","stripeGuestId","stripeMessage","braintreeGuestId","braintreeMessage","currency","status","paymentStatus","cancellationDate","cancelledBy","hostNote","guestNote","doorCode","doorCodeVendor","doorCodeInstruction","comment","confirmationCode","airbnbExpectedPayoutAmount","airbnbListingBasePrice","airbnbListingCancellationHostFee","airbnbListingCancellationPayout","airbnbListingCleaningFee","airbnbListingHostFee","airbnbListingSecurityPrice","airbnbOccupancyTaxAmountPaidToHost","airbnbTotalPaidAmount","airbnbTransientOccupancyTaxPaidAmount","airbnbCancellationPolicy","isStarred","isArchived","isPinned","reservationCouponId","customFieldValues","reservationFees","reservationUnit","insertedOn","updatedOn","latestActivityOn","customerUserId","guestLocale","localeForMessaging","localeForMessagingSource","listingCustomFields","rentalAgreementFileUrl","reservationAgreement","financeField","host_away_id",



    ];
}
