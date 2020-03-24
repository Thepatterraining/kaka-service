<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class PayJournalData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Payment\PayJournal';

    protected $no = 'pay3rd_journal_no';

    public static $NO_PREFIX = 'PAY';

    /**
     * 添加流水
     *
     * @param   $payid 平台id
     * @param   $channelid 账号id
     * @param   $in 收入
     * @param   $out 支出
     * @param   $pending 在途
     * @param   $jobNo 关联单据号
     * @param   $type 类型
     * @param   $status 状态
     * @author  zhoutao
     * @version 0.1
     */
    public function add($payid, $channelid, $in, $out, $pending, $jobNo, $type, $status)
    {

        $docMd5 = new DocMD5Maker();

        $docNo = new DocNoMaker();
        $no = $docNo->Generate($this::$NO_PREFIX);

        $model = $this->newitem();
        $model->pay3rd_journal_no = $no;
        $model->pay3rd_journal_datetime = $date;
        $model->pay3rd_journal_payid = $payid;
        $model->pay3rd_journal_channelid = $channelid;
        $model->pay3rd_journal_in = $in;
        $model->pay3rd_journal_out = $out;
        $model->pay3rd_journal_pending = $pending;
        $model->pay3rd_journal_type = $type;
        $model->pay3rd_journal_jobno = $jobNo;
        $model->pay3rd_journal_status = $status;
        $model->pay3rd_journal_resultpending = $resultPending;
        $model->pay3rd_jounral_resultcash = $resultCash;
        $docMd5->AddHash($model);
        return $model;
    }
}
