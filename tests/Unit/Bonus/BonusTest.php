<?php
namespace Tests\Feature\Unit\Bonus;

use Tests\TestCase;
use App\Data\Bonus\ProjBonusPlanData;
use App\Data\Bonus\BonusPlanData;
use App\Data\Utils\DocNoMaker;

class BonusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testAddBonusPlan()
    {
        
        $projBonusPlanData = new ProjBonusPlanData;
        $projBonusPlanData->add('KKC-BJ0006', 1000, 6000, 0.01, 1, 5, '2017-11-13 02:30:00', '2017-11-13 03:10:00', 3);
        die;
        // $BonusPlanData = new BonusPlanData;
        // // $BonusPlanData->executeBonusPlan('PBP2017110621162876271');
        // $data = new \App\Data\Auth\AccessToken;
        // $appid = $data->create_guid('appid');
        // dump($appid);
        // $appSe = DocNoMaker::getRandomString(16);
        // dump($appSe);
        // dump(md5($appid . md5($appid . $appSe)));
        // $applicationData = new \App\Data\Sys\ApplicationData;
        // dump($applicationData->add('微信', 0.01, '测试'));
    }
}
