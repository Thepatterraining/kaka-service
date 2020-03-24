<?php

namespace App\Model\Monitor;


use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MongoDebugInfo extends Eloquent
{
    //
    // use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'sys_debug';
}
