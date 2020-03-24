<?php

namespace App\Model\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class JpgUpload extends Eloquent
{
    //
    // use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'jpg';
}
