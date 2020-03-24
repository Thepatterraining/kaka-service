<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;

    /**
     * 关联学校和学区
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class SchoolDistrictItemsData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\SchoolDistrictItems';

    /**
     * 关联学校和学区
     *
     * @param  $schoolDistrictid 学区id
     * @param  $schoolid 学校id
     * @author zhoutao
     * @date   2017.9.19
     */
    public function add($schoolDistrictid, $schoolid)
    {
        $model = $this->newitem();
        $model->school_district_id = $schoolDistrictid;
        $model->school_id = $schoolid;
        $this->save($model);
    }

}
