<?php

namespace App\Model\Schedule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleItem extends Model
{
    //
    use SoftDeletes;
    protected $table = "kk_schecule_item";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
