<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingEnquiryHome extends Model
{
    public $table = "booking_enquiry_home";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'name',
		'email',
		'mobile',
		'message',
      	'how_did_you_hear_about_us',
        'guests',
        'start_date',
        'end_date',
        'property_id'
    ];

    public static $rules = [
        // create rules
    ];

    // Cm 
}

