<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class CreateHouseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetCurves()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/require', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];

        dump($token);

        //开始查询项目坐标
        dump('开始查询项目坐标');
        $districtName = '啦啦啦';
        $districtRegionid = 1;
        $rsdName = '啦1';
        $rsdShortname = '啦2';
        $rsdStartyear = '1979';
        $rsdEndyear = '1989';
        $districtName = '';
        $districtRegionid = '';
        $houseName = '';
        $houseTradedate = '';
        $houseSize = '';
        $houseUnitprice = '';
        $housePrice = '';
        $houseBuildingYear = '';
        $houseOrientation = '';
        $houseBuildingHeight = '';
        $houseWithlift = '';
        $houseFlow = '';
        $houseListprice = '';
        $houseTransactionCycle = '';
        $houseBuildingType = '';
        $houseInnersize = '';
        $houseUse = '';
        $houseHomelinkNo = '';
        $houseHomelineAddress = '';
        $houseTypeid = '';
        $houseTypeName = '';
        $houseSubwaystation = '';
        $houseSubwaydistance = '';
        $response = $this->createHouse($token, $districtName, $districtRegionid, $houseName, $houseTradedate, $houseSize, $houseUnitprice, $housePrice, $houseBuildingYear, $houseOrientation, $houseBuildingHeight, $houseWithlift, $houseFlow, $houseListprice, $houseTransactionCycle, $houseBuildingType, $houseInnersize, $houseUse, $houseHomelinkNo, $houseHomelineAddress, $houseTypeid, $houseTypeName, $houseSubwaystation, $houseSubwaydistance);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function createHouse($token, $districtName, $districtRegionid, $houseName, $houseTradedate, $houseSize, $houseUnitprice, $housePrice, $houseBuildingYear, $houseOrientation, $houseBuildingHeight, $houseWithlift, $houseFlow, $houseListprice, $houseTransactionCycle, $houseBuildingType, $houseInnersize, $houseUse, $houseHomelinkNo, $houseHomelineAddress, $houseTypeid, $houseTypeName, $houseSubwaystation, $houseSubwaydistance)
    {
        $response = $this->json(
            'POST', '/api/token/project/createhouse', array(
            "accessToken"=>$token,
            "districtName"=>$districtName,
            "districtRegionid"=>$districtRegionid,
            "houseName"=>$houseName,
            "houseTradedate"=>$houseTradedate,
            "houseSize"=>$houseSize,
            "houseUnitprice"=>$houseUnitprice,
            "housePrice"=>$housePrice,
            "houseBuildingYear"=>$houseBuildingYear,
            "houseOrientation"=>$houseOrientation,
            "houseBuildingHeight"=>$houseBuildingHeight,
            "houseWithlift"=>$houseWithlift,
            "houseFlow"=>$houseFlow,
            "houseListprice"=>$houseListprice,
            "houseTransactionCycle"=>$houseTransactionCycle,
            "houseBuildingType"=>$houseBuildingType,
            "houseInnersize"=>$houseInnersize,
            "houseUse"=>$houseUse,
            "houseHomelinkNo"=>$houseHomelinkNo,
            "houseHomelineAddress"=>$houseHomelineAddress,
            "houseTypeid"=>$houseTypeid,
            "houseTypeName"=>$houseTypeName,
            "houseSubwaystation"=>$houseSubwaystation,
            "houseSubwaydistance"=>$houseSubwaydistance,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
