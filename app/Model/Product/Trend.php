<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trend extends Model
{
    use SoftDeletes;
    protected $table = "proj_trend";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
