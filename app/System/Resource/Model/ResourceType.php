<?php

namespace App\System\Resource\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceType extends Model
{
    use SoftDeletes;
    protected $table = "resource_type";
    protected $dates = ["created_at","updated_at","deleted_at"];
}