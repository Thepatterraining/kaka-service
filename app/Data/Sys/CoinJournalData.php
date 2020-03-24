<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class CoinJournalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\CoinJournal';

    const VOUCHER_TYPE = 'COJ03';
    const RECHARGE_TYPE = 'COJ04';
    const TO_USER_TYPE = 'COJ05'; //借给用户
    const USER_RETURN_TYPE = 'COJ06'; //用户归还

    const APPLY_STATUS = 'OJT01';
    const SUCCESS_STATUS = 'OJT02';
    const VOUCHER_STATUS = 'OJT07';

    /**
     * 提现代币手续费
     *
     * @param   $no 单据号
     * @param   $amount 数量
     * @param   $jobno 关联单据号
     * @param   $sysAccount 代币账户
     * @param   $coinType 代币类型
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                     $in  收入
     * @param   int                     $out 支出
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addJournal($no, $amount, $jobno, $sysAccount, $coinType, $type, $status, $in = 0, $out = 0, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('SOJ');
        $doc = new DocMD5Maker();
        $model = $this->newitem();
        $model->syscoin_journal_no = $no;
        $model->syscoin_journal_datetime = $date;
        $model->syscoin_journal_in = $in;
        $model->syscoin_journal_out = $out;
        $model->syscoin_journal_pending = $amount;
        $model->syscoin_journal_type = $type;
        $model->syscoin_journal_jobno = $jobno;
        $model->syscoin_journal_status = $status;
        $model->syscoin_result_pending = $sysAccount['accountPending'];
        $model->syscoin_result_cash = $sysAccount['accountCash'];
        $model->syscoin_coin_type = $coinType;
        return $doc->AddHash($model);
    }
}
