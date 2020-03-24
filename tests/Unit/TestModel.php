<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{

    protected $table = "test_doc";
    public $timestamps = false;
}
