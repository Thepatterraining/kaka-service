<?php

namespace App\Model\Region;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    //
    use SoftDeletes;
    protected $table = "region_city";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
