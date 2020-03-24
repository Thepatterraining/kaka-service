<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;

    /**
     * 小区和学区管理
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class DistrictSchoolDistrictItemData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\DistrictSchoolDistrictItem';

    /**
     * 关联小区和学区
     *
     * @param  $districtid 小区id
     * @param  $schoolDistrictid 学区id
     * @author zhoutao
     * @date   2017.9.19
     */
    public function add($districtid, $schoolDistrictid)
    {
        $model = $this->newitem();
        $model->district_id = $districtid;
        $model->school_districtid = $schoolDistrictid;
        $this->save($model);
    }

}
