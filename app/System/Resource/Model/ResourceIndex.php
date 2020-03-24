<?php

namespace App\System\Resource\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceIndex extends Model
{
    use SoftDeletes;
    protected $table = "resource_index";
    protected $dates = ["created_at","updated_at","deleted_at"];
}