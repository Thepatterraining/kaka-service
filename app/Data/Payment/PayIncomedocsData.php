<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class PayIncomedocsData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Payment\PayIncomedocs';

    protected $no = 'income_no';

    const NO_PREFIX = 'IN';
    
    const TYPE_DEFUALT = 'INT00';
    const STATUS_APPLY = 'INS00';
    const STATUS_ARRIVAL = 'INS02';
    const STATUS_REFUSE = 'INS03';

    /**
     * 查询支付业务入帐表详细
     *
     * @param   $channelid 通道id
     * @author  zhoutao
     * @version 0.1
     */
    public function getInfo($channelid)
    {
        $model = $this->modelclass;

        $where['income_3rdchannel'] = $channelid;
        $info = $model::where($where)->first();
        return $info;      
    }

    /**
     * 添加入帐
     *
     * @param   $payid 平台id
     * @param   $channelid 通道id
     * @param   $accountid = 入帐账号
     * @param   $provisionsBankid 备付金账号
     * @param   $cash 入帐金额
     * @param   $feeRate 手续费率
     * @param   $fee 手续费
     * @param   $type 入帐类型
     * @param   $status 状态
     * @author  zhoutao
     * @version 0.1
     */
    public function add(
        $payid,
        $channelid,
        $accountid,
        $provisionsBankid,
        $cash,
        $feeRate,
        $fee,
        $type,
        $status,
        $startTime,
        $endTime
    ) {
    
        $docNo = new DocNoMaker();
        $no = $docNo->Generate(PayIncomedocsData::NO_PREFIX);

        $model = $this->newitem();
        $model->income_no = $no;
        $model->income_3rdpay = $payid;
        $model->income_3rdchannel = $channelid;
        $model->income_account = $accountid;
        $model->income_provisions = $provisionsBankid;
        $model->income_cash = $cash;
        $model->income_feerate = $feeRate;
        $model->income_fee = $fee;
        $model->income_type = $type;
        $model->income_status = $status;
        $model->income_starttime = $startTime;
        $model->income_endtime = $endTime;
        $this->create($model);
        return $model;
    }

     
    /**
     * 修改状态
     *
     * @param   $incomeNo 入帐单号
     * @param   $status 状态
     * @param   $date 时间
     * @param   $userid 审核人
     * @author  zhoutao
     * @version 0.1
     */
    public function saveStatus($incomeNo, $status, $userid, $date)
    {
        $incomeInfo = $this->getByNo($incomeNo);
        $incomeInfo->income_status = $status;
        $incomeInfo->income_checkuser = $userid;
        $incomeInfo->income_checktime = $date;
        $this->save($incomeInfo);
    }

    /**
     * 查找三方入账
     *
     * @param   $incomeNo 入帐单号
     * @param   $status 状态
     * @param   $date 时间
     * @param   $userid 审核人
     * @author  zhoutao
     * @version 0.1
     */
    public function getStatus($start,$end)
    {
        $incomeInfo = $this->getByNo($incomeNo);
        $incomeInfo->income_status = $status;
        $incomeInfo->income_checkuser = $userid;
        $incomeInfo->income_checktime = $date;
        $this->save($incomeInfo);
    }
}
