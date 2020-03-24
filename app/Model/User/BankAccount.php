<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    //
    use SoftDeletes;
    protected $table = "user_bank_account";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
