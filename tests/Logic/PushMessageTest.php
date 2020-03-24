<?php
namespace Tests\Logic;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Tests\Unit\TestModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Mail\Report;

use App\Data\NotifyRun\Bonus\ProjBonusItemData as Notify;
use App\Http\Utils\RaiseEvent;
use App\Data\Bonus\ProjBonusItemData;
class PushMessageTest extends TestCase
{

    use RaiseEvent;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $bonusData = new ProjBonusItemData;
        $item = $bonusData->get(4021);

        $notify = new Notify; 
        $notify->notifyrun($item);

        $evt = ProjBonusItemData::EVENT_TYPE;
        $this->AddEvent($evt,3,4021);
        $this->RaisEvent();
        $this->assertTrue(true);
    }
}
