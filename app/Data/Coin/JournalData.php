<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class JournalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $no = 'coin_journal_no';

    protected $modelclass = 'App\Model\Coin\Journal';

    const RECHARGE_TYPE = 'CJ02';

    const APPLY_STATUS = 'CJT01';
    const SUCCESS_STATUS = 'CJT02';

    /**
     * 添加系统代币流水
     *
     * @param   $no 单据号
     * @param   $coinId sys_coin id
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @param   $jobno 关联单据号
     * @param   $accountRes 代币账户
     * @param   $type 类型
     * @param   string                  $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addJournal($no, $coinType, $amount, $jobno, $accountRes, $type, $status = 'CJT01', $in = 0, $out = 0, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('OCJ');
        $doc = new DocMD5Maker();
        $model = $this->newitem();
        $model->coin_journal_no = $no;
        $model->coin_journal_cointtype = $coinType;
        $model->coin_journal_pending = $amount;
        $model->coin_journal_in = $in;
        $model->coin_journal_out = $out;
        $model->coin_journal_status = $status;
        $model->coin_journal_jobno = $jobno;
        $model->coin_journal_datetime = $date;
        $model->coin_account_id = $accountRes['id'];
        $model->coin_journal_type = $type;
        $model->coin_result_pending = $accountRes['accountPending'];
        $model->coin_result_cash = $accountRes['accountCash'];
        return $doc->AddHash($model);
    }
}
