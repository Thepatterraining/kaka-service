<?php

namespace App\Model\Bonus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjDynamic extends Model
{
    use SoftDeletes;
    protected $table = "proj_dynamic";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
