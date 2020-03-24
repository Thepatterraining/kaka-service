<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;
use App\Data\Sys\CashJournalData;

class ProjDynamicData extends IDatafactory
{

    protected $modelclass = 'App\Model\Bonus\ProjDynamic';

    protected $no = 'proj_no';

    const RIGHT_TYPE = 'PDY05';
    const BONUS_TYPE = 'PDY06';
    const OTHER_TYPE = 'PDY07';

    /**
     * 写入项目动态
     *
     * @param  $coinType 代币类型
     * @param  $dynamicType 动态类型
     * @param  $newsNo 公告单号
     * @author zhoutao
     */
    public function add($coinType, $dynamicType, $newsNo)
    {
        $model = $this->newitem();
        $model->proj_no = $coinType;
        $model->proj_dynamictype = $dynamicType;
        $model->proj_newsno = $newsNo;
        $this->create($model);
    }

}
