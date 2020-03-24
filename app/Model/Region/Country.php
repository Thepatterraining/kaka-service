<?php

namespace App\Model\Region;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    //
    use SoftDeletes;
    protected $table = "region_country";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
