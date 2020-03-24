<?php

namespace App\Model\Sys;


use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MongoLog extends Eloquent
{
    //
    // use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'sys_log';
}
