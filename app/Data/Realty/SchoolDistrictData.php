<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;
use App\Data\Region\DistrictData as RegionDistrictData;

    /**
     * 学区管理
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class SchoolDistrictData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\SchoolDistrict';

    
    /**
     * 插入学区
     *
     * @param  $rsdName 学区名称
     * @param  $rsdShortname 学区简称
     * @param  $rsdDistrictid 市区id
     * @param  $rsdDistrictName 市区名称
     * @param  $rsdStartyear 设立年份
     * @param  $rsdEndyear 取消年份
     * @author zhoutao
     * @date   2017.9.19
     */
    public function add($rsdName, $rsdShortname, $rsdDistrictid, $rsdStartyear, $rsdEndyear)
    {
        //查询市区名称
        $districtData = new RegionDistrictData;
        $district = $districtData->get($rsdDistrictid);
        $rsdDistrictName = '';
        if (!empty($district)) {
            $rsdDistrictName = $district->district_name;
        }

        $model = $this->newitem();
        $model->rsd_name = $rsdName;
        $model->rsd_shortname = $rsdShortname;
        $model->rsd_district_id = $rsdDistrictid;
        $model->rsd_district_name = $rsdDistrictName;
        $model->rsd_startyear = $rsdStartyear;
        $model->rsd_endyear = $rsdEndyear;
        $this->save($model);
        return $model;
    }
}
