<?php

namespace App\Model\Region;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subwayline extends Model
{
    //
    use SoftDeletes;
    protected $table = "region_subwayline";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
