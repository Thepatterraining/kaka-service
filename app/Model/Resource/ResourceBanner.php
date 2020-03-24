<?php

namespace App\Model\Resource;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceBanner extends Model
{
    //
    use SoftDeletes;
    protected $table = "resource_banner";
    protected $dates = ["created_at","updated_at","deleted_at"];
}