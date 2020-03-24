<?php
namespace Tests\Feature\Unit\Lending;

use Tests\TestCase;
use App\Data\Bonus\ProjBonusPlanData;
use App\Data\Bonus\BonusPlanData;
use App\Data\Utils\DocNoMaker;

class LendingDocInfoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testAddBonusPlan()
    {
        // $data['kkuserid'] = 42;
        // $data['binding_time'] = date('Y-m-d H:i:s');
        // $userInfoData = new \App\Data\App\UserInfoData;
        // $userInfoData->notifysaveddefaultrun($data);die;
        $date1 = "2017-11-11 20:09:00";
        $date2 = "2017-11-11 19:09:00";
        $str1 = strtotime($date1);
        $str2 = strtotime($date2);
        dump($str1);
        dump($str2);
        $str3 = $str1 - $str2;
        dump($str3);
        // $data['lending_lenduser'] = 3026;
        // $voucherStorageData = new \App\Data\Activity\VoucherStorageData;
        // $voucherStorageData->notifysaveddefaultrun($data);die;
        // $data = new \App\Data\Lending\LendingUserData;
        // $no = $data->sysToUser('KKC-BJ0001', 1, 3026, '2017-11-10', 1500);
        // $data->sysToUserTrue($no);
        // $frozenFac = new \App\Data\Frozen\FrozenFactory;
        // $frozenData = $frozenFac->CreateFrozen('FT03');
        // $frozenData->orderFrozen($no);
        // $no = 'BLD2017110921293956894';
        // $returnData = new \App\Data\Lending\ReturnUserData;
        // $returnData->userReturnSys($no);
        // $returnData->userReturnSysTrue($no);
    }
}
