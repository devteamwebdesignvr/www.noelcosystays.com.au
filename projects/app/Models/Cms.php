<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    public $table = "cms";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'name',
		'seo_url',
		'shortDescription',
		'mediumDescription',
		'longDescription',
		'description',
		'image',
		'image2',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'templete',
		'bannerImage',
		'publish',

		'header_section',
		'footer_section',


	'image_2',
		'image_3',
	"faq_title",
"faq_desction",
"faq_image",
"strip_title",
"strip_desction",
"strip_image",
"about_image1",
"about_image2",
"owner_image",
    ];

    public static $rules = [
        // create rules
    ];

    // Cm 
}

