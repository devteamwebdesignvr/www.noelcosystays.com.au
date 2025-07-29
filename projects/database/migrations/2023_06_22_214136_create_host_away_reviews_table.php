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
        Schema::create('host_away_reviews', function (Blueprint $table) {
            $table->id();
            $table->string("host_away_id")->nullable();
            $table->string("accountId")->nullable();
            $table->string("listingMapId")->nullable();
            $table->string("reservationId")->nullable();
            $table->text("reviewerName")->nullable();
            $table->string("channelId")->nullable();
            $table->string("type")->nullable();
            $table->string("status")->nullable();
            $table->string("rating")->nullable();
            $table->text("title")->nullable();
            $table->LongText("publicReview")->nullable();
            $table->LongText("privateFeedback")->nullable();
            $table->LongText("revieweeResponse")->nullable();
            $table->string("submittedAt")->nullable();
            $table->string("insertedOn")->nullable();
            $table->string("updatedOn")->nullable();
            $table->longText("reviewCategory")->nullable();
            $table->string("listingName")->nullable();
            $table->string("departureDate")->nullable();
            $table->string("arrivalDate")->nullable();
            $table->text("internalListingName")->nullable();
            $table->text("externalListingName")->nullable();
            $table->string("guestName")->nullable();
      

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
        Schema::dropIfExists('host_away_reviews');
    }
};
