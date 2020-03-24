<?php
namespace App\Data;

use App\Data\IDataFactory;
 
use App\Data\Sys\LockData;
use Illuminate\Support\Facades\Log;

class TestData extends IDatafactory
{


    protected $modelclass = 'App\Model\TestModel';


    public function Update()
    {
        $lk = new LockData();
 
        $item = $this->get(1);
        $item->counter ++;
        $i = $item ->counter;
        $item->save();
        $lk->unlock('test');
        return $i;
    }
}
