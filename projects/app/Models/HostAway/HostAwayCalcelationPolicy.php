<?php

namespace App\Models\HostAway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostAwayCalcelationPolicy extends Model
{
    use HasFactory;

    public $fillable=[
        "host_away_id",
        "accountId",
        "name",
        "cancellationPolicyItem",

    ];
}
