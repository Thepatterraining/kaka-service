<?php
namespace App\Data\Region;

use App\Data\IDataFactory;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;

class ProvinceData extends IDatafactory
{
    protected $modelclass = 'App\Model\Region\Province';

    /**
     * 删除国家的省，市，区
     */
    public function dels($countryid)
    {
        $model = $this->modelclass;
        $cityData = new CityData;

        $where['province_country'] = $countryid;
        $provinces = $model::where($where)->get();
        foreach ($provinces as $province) {
            $cityData->dels($province->id);
            $this->delete($province->id);
        }
    }
}
