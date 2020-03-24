<?php

namespace App\Model\Realty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistrictSchoolDistrictItem extends Model
{
    //
    use SoftDeletes;
    protected $table = "realty_district_schooldistrict_item";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
