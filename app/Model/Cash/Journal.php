<?php

namespace App\Model\Cash;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    //

    protected $table = "cash_journal";
    public $timestamps = false;
}
