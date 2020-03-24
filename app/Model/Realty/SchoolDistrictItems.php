<?php

namespace App\Model\Realty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDistrictItems extends Model
{
    //
    use SoftDeletes;
    protected $table = "realty_school_district_items";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
