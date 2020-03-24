<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashJournalDoc extends Model
{
    //
    use SoftDeletes;
    protected $table = "syscash_journaldoc";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
