<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends Model
{
    //
    use SoftDeletes;
    protected $table = "product_info";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
