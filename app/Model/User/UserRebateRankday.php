<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRebateRankday extends Model
{
    use SoftDeletes;
    //
    protected $table = "user_rebate_rankday";
    protected $dates=["created_at","updated_at",'deleted_at'];
}
