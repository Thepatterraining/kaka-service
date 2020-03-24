<?php

namespace App\Model\Bonus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjBonusPlan extends Model
{
    use SoftDeletes;
    protected $table = "proj_bonus_plan";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
