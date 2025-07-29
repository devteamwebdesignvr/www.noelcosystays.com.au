<?php

namespace App\Models\HostAway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostAwayDate extends Model
{
    use HasFactory;
public $table = "host_away_dates";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'single_date',
		'isAvailable',
		'status',
		'hostaway_id',
		'price','minimumStay'
	
    ];
}
