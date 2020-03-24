<?php

namespace Tests\Feature\Activity;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use App\Data\NotifyRun\Voucher\VoucherStorageData;
use App\Data\Lending\LendingDocInfoData;

class VoucherTest extends TestCase
{
    public function testAddActivity()
    {
        $lendingDocInfoData=new LendingDocInfoData();
        $voucherStorageData=new VoucherStorageData();
        $data=$lendingDocInfoData->newitem()->where('id',15)->first();
        $data=$data->toArray();
        $data['params']=json_decode('{"voucherNo":"VCN2017111115042590278"}',true);
        $voucherStorageData->notifyrun($data);
    }
}
