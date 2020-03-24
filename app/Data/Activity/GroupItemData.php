<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Activity\ItemData;
use App\Data\User\UserTypeData;

class GroupItemData extends IDatafactory
{
    protected $no = 'group_itemno';

    protected $modelclass = 'App\Model\Activity\GroupItem';

    /**
     * 根据活动编号查询分组详细
     *
     * @param   $activityNo 活动编号
     * @author  zhoutao
     * @version 0.1
     */
    public function getGroupItem($activityNo)
    {
        $where['group_activity'] = $activityNo;
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        return $info;
    }

    /**
     * 给活动分配默认分组
     *
     * @param   $activityNo 活动编号
     * @author  zhoutao
     * @version 0.1
     */
    public function addActivityGroup($activityNo)
    {
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $groupNo = $sysConfigs[UserTypeData::$ACTIVITY_DEFULT_GROUP];
        $this->add($groupNo, $activityNo);
    }

    /**
     * 添加
     *
     * @param   $groupNo 分组编号
     * @param   $activityNo 活动编号
     * @author  zhoutao
     * @version 0.1
     */
    public function add($groupNo, $activityNo)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('GI');
        $model = $this->newitem();
        $model->group_itemno = $no;
        $model->group_no = $groupNo;
        $model->group_activity = $activityNo;
        $this->create($model);
        return $no;
    }
}
