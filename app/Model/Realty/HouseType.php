<?php

namespace App\Model\Realty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseType extends Model
{
    //
    use SoftDeletes;
    protected $table = "realty_house_type";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
