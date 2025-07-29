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
        Schema::create('host_away_properties', function (Blueprint $table) {
            $table->id();

            $table->string("propertyTypeId",10)->nullable();
            $table->string("name")->nullable();
            $table->string("externalListingName")->nullable();
            $table->string("internalListingName")->nullable();
            $table->longText("description")->nullable();
            $table->longText("thumbnailUrl")->nullable();
            $table->string("houseRules")->nullable();
            $table->string("keyPickup")->nullable();
            $table->string("specialInstruction")->nullable();
            $table->string("doorSecurityCode")->nullable();
            $table->string("country",50)->nullable();
            $table->string("countryCode",50)->nullable();
            $table->string("state",100)->nullable();
            $table->string("city",100)->nullable();
            $table->string("street",100)->nullable();
            $table->string("address",100)->nullable();
            $table->string("publicAddress",100)->nullable();
            $table->string("zipcode",100)->nullable();
            $table->double("price")->nullable();
            $table->string("starRating")->nullable();
            $table->string("weeklyDiscount")->nullable();
            $table->string("monthlyDiscount")->nullable();
            $table->double("propertyRentTax")->nullable();
            $table->double("guestPerPersonPerNightTax")->nullable();
            $table->double("guestStayTax")->nullable();
            $table->double("guestNightlyTax")->nullable();
            $table->double("refundableDamageDeposit")->nullable();
            $table->double("isDepositStayCollected")->nullable();
            $table->double("personCapacity")->nullable();
            $table->string("maxChildrenAllowed")->nullable();
            $table->string("maxInfantsAllowed")->nullable();
            $table->string("maxPetsAllowed")->nullable();
            $table->double("lat")->nullable();
            $table->double("lng")->nullable();
            $table->double("checkInTimeStart")->nullable();
            $table->double("checkInTimeEnd")->nullable();
            $table->double("checkOutTime")->nullable();
            $table->string("cancellationPolicy",50)->nullable();
            $table->double("squareMeters")->nullable();
            $table->string("roomType",50)->nullable();
            $table->string("bathroomType",50)->nullable();
            $table->double("bedroomsNumber")->nullable();
            $table->double("bedsNumber")->nullable();
            $table->double("bathroomsNumber")->nullable();
            $table->double("minNights")->nullable();
            $table->double("maxNights")->nullable();
            $table->double("guestsIncluded")->nullable();
            $table->double("cleaningFee")->nullable();
            $table->double("checkinFee")->nullable();
            $table->double("priceForExtraPerson")->nullable();
            $table->double("instantBookable")->nullable();
            $table->string("instantBookableLeadTime")->nullable();
            $table->double("airbnbBookingLeadTime")->nullable();
            $table->double("airbnbBookingLeadTimeAllowRequestToBook")->nullable();
            $table->double("allowSameDayBooking")->nullable();
            $table->double("sameDayBookingLeadTime")->nullable();
            $table->string("contactName")->nullable();
            $table->string("contactSurName")->nullable();
            $table->string("contactPhone1")->nullable();
            $table->string("contactPhone2")->nullable();
            $table->string("contactLanguage")->nullable();
            $table->string("contactEmail")->nullable();
            $table->string("contactAddress")->nullable();
            $table->string("language")->nullable();
            $table->string("currencyCode")->nullable();
            $table->string("timeZoneName")->nullable();
            $table->string("wifiUsername")->nullable();
            $table->string("wifiPassword")->nullable();
            $table->string("cleannessStatus")->nullable();
            $table->string("cleaningInstruction")->nullable();
            $table->string("cleannessStatusUpdatedOn")->nullable();
            $table->string("homeawayPropertyName")->nullable();
            $table->string("homeawayPropertyHeadline")->nullable();
            $table->longText("homeawayPropertyDescription")->nullable();
            $table->string("bookingcomPropertyName")->nullable();
            $table->string("bookingcomPropertyRoomName")->nullable();
            $table->longText("bookingcomPropertyDescription")->nullable();
            $table->string("invoicingContactName")->nullable();
            $table->string("invoicingContactSurName")->nullable();
            $table->string("invoicingContactPhone1")->nullable();
            $table->string("invoicingContactPhone2")->nullable();
            $table->string("invoicingContactLanguage")->nullable();
            $table->string("invoicingContactEmail")->nullable();
            $table->string("invoicingContactAddress")->nullable();
            $table->string("invoicingContactCity")->nullable();
            $table->string("invoicingContactZipcode")->nullable();
            $table->string("invoicingContactCountry")->nullable();
            $table->longText("attachment")->nullable();
            
            
            
            
            
            $table->string("propertyLicenseNumber")->nullable();
            $table->string("propertyLicenseType")->nullable();
            $table->string("propertyLicenseIssueDate")->nullable();
            $table->string("propertyLicenseExpirationDate")->nullable();
            
            $table->string("applyPropertyRentTaxToFees")->nullable();
            $table->string("bookingEngineLeadTime")->nullable();
            $table->double("cancellationPolicyId")->nullable();
            $table->double("partnersListingMarkup")->nullable();
            
            $table->string("isRentalAgreementActive")->nullable();
            $table->string("averageNightlyPrice")->nullable();
            $table->string("bookingcomPropertyRegisteredInVcs")->nullable();
            $table->string("bookingcomPropertyHasVat")->nullable();
            $table->string("bookingcomPropertyDeclaresRevenue")->nullable();
            $table->string("listingSettings")->nullable();
            $table->string("host_away_id",50)->nullable();


            $table->longText("listingAmenities")->nullable();
            $table->longText("listingBedTypes")->nullable();
            $table->longText("listingImages")->nullable();
            $table->longText("listingTags")->nullable();
            $table->longText("listingUnits")->nullable();
            $table->longText("customFieldValues")->nullable();
            $table->longText("listingFeeSetting")->nullable();


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
        Schema::dropIfExists('host_away_properties');
    }
};
