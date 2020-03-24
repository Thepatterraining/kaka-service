<?php
namespace App\Data\Realty;

use App\Data\Region\DistrictData as RegionDistrictData;
use App\Data\IDataFactory;

    /**
     * 小区管理
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class DistrictData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\District';

    /**
     * 插入小区
     *
     * @param  $districtName 小区名称
     * @param  $districtRegionid 市区id
     * @author zhoutao
     * @date   2017.9.19
     */
    public function add($districtName, $districtRegionid)
    {
        //查询市区名称
        $districtData = new RegionDistrictData;
        $district = $districtData->get($districtRegionid);
        $districtRegionName = '';
        if (!empty($district)) {
            $districtRegionName = $district->district_name;
        }

        $model = $this->newitem();
        $model->district_name = $districtName;
        $model->district_region_id = $districtRegionid;
        $model->district_region_name = $districtRegionName;
        $this->save($model);
        return $model;
    }

}
