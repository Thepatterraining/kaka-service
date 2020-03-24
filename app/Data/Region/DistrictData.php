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

class DistrictData extends IDatafactory
{
    protected $modelclass = 'App\Model\Region\District';

    /**
     * 删除这个城市的区
     *
     * @author zhoutao
     */
    public function dels($cityid)
    {
        $model = $this->modelclass;

        $where['district_cityid'] = $cityid;
        $model::where($where)->delete();
    }

    /**
     * 查询市区id
     *
     * @param  $districtName 市区名称
     * @author zhoutao
     * @date   2017.9.26
     */
    public function getId($districtName)
    {
        $model = $this->modelclass;

        $where['district_name'] = $districtName;
        $district = $model::where($where)->first();
        if (!empty($district)) {
            return $district->id;
        }
        return 0;
    }
}
