<?php

namespace App\Model\Realty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    //
    use SoftDeletes;
    protected $table = "realty_house";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
