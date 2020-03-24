<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;

    /**
     * 户型管理
     *
     * @author zhoutao
     * @date   2017.9.21
     */
class HouseTypeData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\HouseType';

    /**
     * 插入户型信息
     *
     * @param  $housetypeName 名称
     * @param  $housetypeBedroom 卧室数量
     * @param  $housetypeParlor 厅
     * @param  $housetypeBathroom 卫
     * @param  $housetypeFloor 层
     * @param  $housetypeRemark 备注
     * @author zhoutao
     * @date   2017.9.21
     */
    public function add($housetypeName, $housetypeBedroom, $housetypeParlor, $housetypeBathroom, $housetypeFloor, $housetypeRemark)
    {
        $model = $this->newitem();
        $model->housetype_name = $housetypeName;
        $model->housetype_bedroom = intval($housetypeBedroom);
        $model->housetype_parlor = intval($housetypeParlor);
        $model->housetype_bathroom = intval($housetypeBathroom);
        $model->housetype_floor = intval($housetypeFloor);
        $model->housetype_remark = $housetypeRemark;
        $this->save($model);
        return $model;
    }

}
