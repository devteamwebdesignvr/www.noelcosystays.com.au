<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactusRequest extends Model
{
    public $table = "contactus_requests";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'name',
		'email',
		'mobile',
		'message',
      	'how_did_you_hear_about_us'
		

    ];

    public static $rules = [
        // create rules
    ];

    // Cm 
}

