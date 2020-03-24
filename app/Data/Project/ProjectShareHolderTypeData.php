<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 股东类型
     *
     * @author zhoutao
     * @date   2017.10.14
     */
class ProjectShareHolderTypeData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectShareHolderType';

    /**
     * 创建股东类型
     *
     * @param  $name 名称
     * @param  $shareBonus 是否参加分红
     * @author zhoutao
     * @date   2017.10.21
     */
    public function add($name, $shareBonus)
    {
        $model = $this->newitem();
        $model->holder_typename = $name;
        $model->holder_sharebonus = $shareBonus;
        $this->create($model);
    }

}
