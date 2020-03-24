<?php

namespace App\Model\Cash;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalDoc extends Model
{
    //
    use SoftDeletes;
    protected $table = "cash_journaldoc";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
