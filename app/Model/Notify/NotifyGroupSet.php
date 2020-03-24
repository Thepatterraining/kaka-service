<?php

namespace App\Model\Notify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifyGroupSet extends Model
{
    //
    use SoftDeletes;
    protected $table = "event_notifygroupset";
    protected $dates = ["created_at","updated_at","deleted_at"];
}