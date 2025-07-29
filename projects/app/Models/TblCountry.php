<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCountry extends Model
{
    public $table = "tbl_country";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'Country_Name',
		'ISO2',
		'Phone_Code',
		'E164'
    ];
}
