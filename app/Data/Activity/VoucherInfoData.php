<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Project\ProjectInfoData;

class VoucherInfoData extends IDatafactory
{
    protected $no = 'vaucher_no';

    protected $modelclass = 'App\Model\Activity\VoucherInfo';
    const FULL_CUT = "VC01";

    /**
     * 添加现金券
     *  
     * @param   $no 现金券编号
     * @param   $name 名称
     * @param   $type 类型
     * @param   $val1
     * @param   $val2
     * @param   $val3
     * @param   $val4
     * @param   $vmodel 绑定模型
     * @param   $event 绑定事件
     * @param   $filter 使用条件
     * @param   $timespan 超时时长 以秒为单位
     * @param   $count 发放数量
     * @param   $usercount 使用数量
     * @param   $timeout 过期数量
     * @param   $locktime 锁定时间 使用后的资产锁定时长，以秒为单位
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addInfo($no, $name, $type, $val1, $val2, $val3, $val4, $vmodel, $event, $filter, $timespan, $count, $usercount, $timeout, $locktime)
    {
        $model = $this->newitem();
        $model->vaucher_no = $no;
        $model->vaucher_name = $name;
        $model->vaucher_type = $type;
        $model->voucher_val1 = $val1;
        $model->voucher_val2 = $val2;
        $model->voucher_val3 = $val3;
        $model->voucher_val4 = $val4;
        $model->voucher_model = $vmodel;
        $model->voucher_event = $event;
        $model->voucher_filter = $filter;
        $model->voucher_timespan = $timespan;
        $model->voucher_count = $count;
        $model->voucher_usecount = $usercount;
        $model->voucher_timeoutcount = $timeout;
        $model->voucher_locktime = $locktime;
        return $model->save();
    }

    public function addFullOff($full, $off, $days)
    {
        $doc = new DocNoMaker();
        $no = $doc->Generate('VCN');
        $model = $this->newitem();
        $model->vaucher_no = $no;
        $model->vaucher_name =  "满${full}减$off";
        $model->vaucher_type = VoucherInfoData::FULL_CUT;
        $model->voucher_val1 = $full;
        $model->voucher_val2 = $off;
        $model->voucher_val3 = 0;
        $model->voucher_val4 =  0;
        $model->voucher_model = "";
        $model->voucher_event = "";
        $model->voucher_filter = "";
        $model->voucher_timespan =  $days * 24*3600;

        $model->voucher_count = 0;
        $model->voucher_usecount =0;
        $model->voucher_timeoutcount = 0;
        $model->voucher_locktime = $days *24*3600;
        $this->create($model);
        return $no;
    }
    /**
     * 添加活动时候 查找现金券
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getVoucher()
    {
        $model = $this->modelclass;
        return $model::get();
    }

    /**
     * 更新发放数量
     *
     * @param   $info model
     * @param   $count 数量
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveVoucherCount($info, $count)
    {
        $info->voucher_count = $info->voucher_count + $count;
        return $info->save();
    }

    /**
     * 更新使用数量
     *
     * @param   $no 代金券号
     * @param   $count 数量
     * @return  mixed
     * @author  zhoutao
     * @date    2017.9.7
     * @version 0.1
     */
    public function saveUseCount($no, $count = 1)
    {
        $info = $this->getByNo($no);
        $info->voucher_count += $count;
        return $this->save($info);
    }

    /**
     * 查找代金券 满多少减多少
     *
     * @param   $no 单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getInfo($no)
    {
        if ($no == null) {
            return '未使用';
        }
        $info = $this->getByNo($no);
        if ($info == null) {
            return null;
        }
        $res['val1'] = intval($info->voucher_val1);
        $res['val2'] = intval($info->voucher_val2);
        return $res;
    }

    public function getByNo($vaucherNo)
    {
        $item=$this->newitem();
        $result=$item->where('vaucher_no', $vaucherNo)->first();
        return $result;
    }

    /**
     * 查询优惠券使用说明
     *
     * @param  $voucherNo 优惠券号
     * @author zhoutao
     * @date   2017.9.14
     * 
     * 改成返回项目名称
     * @author zhoutao
     * @date   2017.11.15
     */
    public function getNote($voucherNo)
    {
        $voucher = $this->getByNo($voucherNo);
        if (empty($voucher)) {
            return '';
        }
        $coinType = $voucher->voucher_note;
        $projectInfoData = new ProjectInfoData;
        $project = $projectInfoData->getByNo($coinType);
        if (empty($project)) {
            return '';
        }
        return $project->project_name;
    }
}
