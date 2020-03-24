<?php

namespace App\Model\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formula extends Model
{
    use SoftDeletes;
    protected $table = "item_formula";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
