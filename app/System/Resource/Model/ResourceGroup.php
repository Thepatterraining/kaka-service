<?php

namespace App\System\Resource\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceGroup extends Model
{
    use SoftDeletes;
    protected $table = "resource_group";
    protected $dates = ["created_at","updated_at","deleted_at"];
}