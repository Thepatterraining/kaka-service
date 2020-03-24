<?php

namespace App\Model\Notify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventLog extends Model
{
    //
    use SoftDeletes;
    protected $table = "event_evts";
    protected $dates = ["created_at","updated_at","deleted_at"];
}