<?php

namespace App\Model\Resource;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceBannerpic extends Model
{
    //
    use SoftDeletes;
    protected $table = "resource_bannerpic";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
