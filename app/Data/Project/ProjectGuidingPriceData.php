<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目指导价
     *
     * @author zhoutao
     * @date   2017.10.20
     */
class ProjectGuidingPriceData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectGuidingPrice';

    protected $no = 'project_no';

    /**
     * 创建项目指导价
     *
     * @param  $coinType 代币类型
     * @param  $guidingPrice 项目指导价
     * @author zhoutao
     * @date   2017.10.20
     */
    public function add($coinType, $guidingPrice)
    {
        $model = $this->newitem();
        $model->project_no = $coinType;
        $model->project_guidingprice = $guidingPrice;
        $this->create($model);
    }

    /**
     * 查询项目指导价
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.20
     * 
     * 增加审核
     * @author zhoutao
     * @date   2017.11.2
     */
    public function getGuidingPrice($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        $where['project_price_ischeck'] = 1;
        return $model::where($where)->orderBy('project_pricedate', 'desc')->first();
    }

    /**
     * 审核指导价
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.11.13
     */
    public function guidingPriceConfirm($coinType)
    {
        $model = $this->getGuidingPrice($coinType);
        if (!empty($model)) {
            $model->project_price_ischeck = 1;
            $this->save($model);
        }
    }
}
