<?php

namespace App\Model\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quarters extends Model
{
    use SoftDeletes;
    protected $table = "item_quarters";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
