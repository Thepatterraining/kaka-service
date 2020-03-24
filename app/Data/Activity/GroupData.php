<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Activity\ItemData;

class GroupData extends IDatafactory
{
    protected $no = 'group_no';

    protected $modelclass = 'App\Model\Activity\Group';

    /**
     * 添加活动分组
     *
     * @param   $name 分组名称
     * @param   $type 分组类型
     * @author  zhoutao
     * @version 0.1
     */
    public function addGroup($name, $type)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('AG');

        $model = $this->newitem();
        $model->group_no = $no;
        $model->group_name = $name;
        $model->group_type = $type;
        $this->create($model);
        return $model;
    }
}
