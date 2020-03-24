<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目状态
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectStatusData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectStatus';

    /**
     * 创建项目状态
     *
     * @param  $coinType 代币类型
     * @param  $status statusDefine.id
     * @param  $start 开始时间
     * @author zhoutao
     * @date   2017.10.16
     */
    public function add($coinType, $status, $start)
    {
        $statusDefineData = new ProjectStatusDefineData;
        $statusDefine = $statusDefineData->get($status);

        $statusid = 0;
        $statusName = '';
        $statusDisplay = 0;
        $statusIndex = 0;
        if (!empty($statusDefine)) {
            $statusid = $statusDefine->id;
            $statusName = $statusDefine->status_name;
            $statusDisplay = $statusDefine->status_display;
            $statusIndex = $statusDefine->status_index;
        }
            $end = date("Y-m-d H:i:s", strtotime($start . "+1 month"));
            $model = $this->newitem();
            $model->project_no = $coinType;
            $model->project_status = $statusid;
            $model->status_name = $statusName;
            $model->status_index = $statusIndex;
            $model->status_display = $statusDisplay;
            $model->status_start = $start;
            $model->status_end = $end;
            $this->create($model);
    }

    /**
     * 查询这个代币在开始时间内的状态
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getStartStatusByNo($coinType)
    {
        $date = date('Y-m-d H:i:s');
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        $where['status_display'] = 1;
        return $model::where($where)
                    ->where('status_start', '<=', $date)
                    ->where('status_end', '>=', $date)
                    ->orderBy('status_index', 'asc')->first();
    }

}
