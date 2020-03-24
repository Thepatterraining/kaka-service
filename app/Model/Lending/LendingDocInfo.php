<?php

namespace App\Model\Lending;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LendingDocInfo extends Model
{
    //
    use SoftDeletes;
    protected $table = "lending_docinfo";
    protected $dates = ["created_at","updated_at","deleted_at"];
}