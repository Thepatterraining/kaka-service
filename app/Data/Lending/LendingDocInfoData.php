<?php
namespace App\Data\Lending;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Data\Project\ProjectInfoData;
use App\Data\Sys\CoinAccountData;
use App\Data\Notify\INotifyDefault;

class LendingDocInfoData extends IDatafactory
{

    protected $modelclass = 'App\Model\Lending\LendingDocInfo';

    protected $no = 'lending_docno';

    const PREFIX_NO = 'BLD';

    const NOVICE_TYPE = 'LDT01'; //新手体验标

    const BORROW_STATUS = 'LDS01'; //借入申请
    const BORROW_SUCCESS_STATUS = 'LDS02'; //借入审核
    const RETURN_STATUS = 'LDS03'; //还回申请
    const RETURN_SUCCESS_STATUS = 'LDS04'; //还回审核

    /**
     * 创建拆解
     *
     * @param  $coinType 代币类型
     * @param  $count 数量
     * @param  $price 价格
     * @param  $userid 用户id
     * @param  $type 类型
     * @param  $status 状态
     * @param  $planReturnTime 计划还款时间
     * @param  $date 申请时间
     * @param  $deposit 保证金 默认0
     * @param  $scale 杠杆 默认1
     * @author zhoutao
     * @date   2017.11.9
     * 
     * 增加项目名称
     * @author zhoutao
     * @date   2017.11.17
     */
    public function add($coinType, $count, $price, $userid, $type, $status, $planReturnTime, $date, $deposit = 0, $scale = 1)
    {
        $docNo = new DocNoMaker;
        $no = $docNo->Generate(self::PREFIX_NO);
        
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);

        $sysCoinAccountData = new CoinAccountData;
        $sysCoinAccount = $sysCoinAccountData->getByNo($coinType);

        $model = $this->newitem();
        $model->lending_docno = $no;
        $model->lending_coin_ammount = $count;
        $model->lending_coin_price = $price;
        $model->lending_deposit = $deposit;
        $model->lending_lendtime = $date;
        $model->lending_lenduser = $userid;
        $model->lending_scale = $scale;
        $model->lending_type = $type;
        $model->lending_status = $status;
        $model->lending_plan_returntime = $planReturnTime;
        $model->lending_sys_account = $sysCoinAccount->id;
        $model->lending_coin_type = $coinType;
        $model->lending_coin_scale = $projectInfo->project_scale;
        $model->project_name = $projectInfo->project_name;
        $this->create($model);
        return $no;
    }

    /**
     * 借入成功
     *
     * @param  $no 单号
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.9
     */
    public function saveBorrowSuccess($no, $date)
    {
        $info = $this->getByNo($no);
        $info->lending_checkuser = $this->session->userid;
        $info->lending_checktime = $date;
        $info->lending_status = self::BORROW_SUCCESS_STATUS;
        $this->save($info);
    }

    /**
     * 归还成功
     *
     * @param  $no 单号
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.9
     */
    public function saveReturnSuccess($no, $date)
    {
        $info = $this->getByNo($no);
        $info->lending_return_checkuser = $this->session->userid;
        $info->lending_return_checktime = $date;
        $info->lending_status = self::RETURN_SUCCESS_STATUS;
        $this->save($info);
    }

    public function getReturns()
    {
        $date = date('Y-m-d H:i:s');
        $model = $this->modelclass;
        return $model::where('lending_plan_returntime', '<=', $date)->where('lending_status', self::BORROW_SUCCESS_STATUS)->get();
    }

}
