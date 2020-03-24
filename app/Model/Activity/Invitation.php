<?php

namespace App\Model\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes;
    protected $table = "activity_invitation";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
