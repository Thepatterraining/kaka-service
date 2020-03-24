<?php

namespace App\Model\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    protected $table = "3rd_user_info";
    protected $dates = ["created_at","updated_at"];


    public function __construct()
    {
       
        //$this->string("nickname",191);
    }
}
