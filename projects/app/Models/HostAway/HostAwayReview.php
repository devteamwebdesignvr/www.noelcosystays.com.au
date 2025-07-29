<?php

namespace App\Models\HostAway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostAwayReview extends Model
{
    use HasFactory;

    public $fillable=[

            "host_away_id",
            "accountId",
            "listingMapId",
            "reservationId",
            "reviewerName",
            "channelId",
            "type",
            "status",
            "rating",
            "title",
            "publicReview",
            "privateFeedback",
            "revieweeResponse",
            "submittedAt",
            "insertedOn",
            "updatedOn",
            "reviewCategory",
            "listingName",
            "departureDate",
            "arrivalDate",
            "internalListingName",
            "externalListingName",
            "guestName",
    ];
}
