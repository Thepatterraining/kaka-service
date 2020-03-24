<?php

namespace App\Model\Region;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subwaystation extends Model
{
    //
    use SoftDeletes;
    protected $table = "region_subwaystation";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
