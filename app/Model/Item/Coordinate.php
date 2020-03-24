<?php

namespace App\Model\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coordinate extends Model
{
    use SoftDeletes;
    protected $table = "item_coordinate";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
