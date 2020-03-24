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

class CityData extends IDatafactory
{
    protected $modelclass = 'App\Model\Region\City';

    /**
     * 删除省的城市和区
     */
    public function dels($provinceid)
    {
        $model = $this->modelclass;
        $districtData = new DistrictData;

        $where['city_provinceid'] = $provinceid;
        $citis = $model::where($where)->get();

        foreach ($citis as $city) {
            $districtData->dels($city->id);
            $this->delete($city->id);
        }
    }
}
