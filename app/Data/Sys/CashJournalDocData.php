<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Cash\BankAccountData;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;

class CashJournalDocData extends IDatafactory
{
    protected $modelclass = 'App\Model\Sys\CashJournalDoc';

    protected $no = 'syscash_journaldoc_no';

    const INSIDE_TYPE = 'SCJDT01';

    const APPLY_STATUS = 'SCJDS01';
    const SUCCESS_STATUS = 'SCJDS02';
    const FAIL_STATUS = 'SCJDS03';

    /**
     * 插入数据
     *
     * @param $notes 说明
     * @param $fromBankCard 出账卡
     * @param $fromBankCardType 出账卡类型
     * @param $toBankCard 入帐卡
     * @param $toBankCard 入帐卡类型
     * @param $amount 金额
     * @param $type 类型
     * @param $status 状态
     */
    public function add($notes, $fromBankCard, $fromBankCardType, $toBankCard, $toBankCardType, $amount, $type, $status)
    {
        $model = $this->newitem();
        $docNo = new DocNoMaker;
        $no = $docNo->Generate('SCJD');
        
        $model->syscash_journaldoc_no = $no;
        $model->syscash_journaldoc_notes = $notes;
        $model->syscash_journaldoc_frombankcard = $fromBankCard;
        $model->syscash_journaldoc_frombankcardtype = $fromBankCardType;
        $model->syscash_journaldoc_tobankcard = $toBankCard;
        $model->syscash_journaldoc_tobankcardtype = $toBankCardType;
        $model->syscash_journaldoc_amount = $amount;
        $model->syscash_journaldoc_type = $type;
        $model->syscash_journaldoc_status =  $status;
        $this->create($model);
        return $no;
    }

    /**
     * 申请
     */
    public function createJournalDoc($notes, $fromBankCard, $toBankCard, $amount, $fromBankCardType, $toBankCardType)
    {
        DB::beginTransaction();
        $date = date('Y-m-d H:i:s');
        $no = $this->add($notes, $fromBankCard, $fromBankCardType, $toBankCard, $toBankCardType, $amount, self::INSIDE_TYPE, self::APPLY_STATUS);

        $bankAccountData = new BankAccountData;
        $bankAccountData->increasePending($toBankCardType, $no, $amount, CashJournalData::SYS_CASH_JOURNAL_DOC_TYPE, CashJournalData::SYS_CASH_JOURNAL_DOC_STATUS, $date, $toBankCard);

        $bankAccountData->reduceCashIncreasePending($fromBankCardType, $no, $amount, $amount, CashJournalData::SYS_CASH_JOURNAL_DOC_TYPE, CashJournalData::SYS_CASH_JOURNAL_DOC_STATUS, $date, $fromBankCard);

        DB::commit();
        return $no;
    }

    /**
     * 成功
     * 
     * 增加锁
     *
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改redis key
     * @author zhoutao
     * @date   2017.10.10
     */
    public function trueJournalDoc($no)
    {
        $lk = new LockData();
        $key = 'confirmJournalDoc' . $no;
        $lk->lock($key);
        DB::beginTransaction();
        $info = $this->getByNo($no);
        $date = date('Y-m-d H:i:s');
        if (!empty($info)) {
            $toBankCardType = $info->syscash_journaldoc_tobankcardtype;
            $fromBankCardType = $info->syscash_journaldoc_frombankcardtype;
            $amount = $info->syscash_journaldoc_amount;
            $fromBankCard = $info->syscash_journaldoc_frombankcard;
            $toBankCard = $info->syscash_journaldoc_tobankcard;
            $status = $info->syscash_journaldoc_status;

            if ($status == self::APPLY_STATUS) {
                $bankAccountData = new BankAccountData;
                $bankAccountData->reducePending($fromBankCardType, $no, $amount, CashJournalData::SYS_CASH_JOURNAL_DOC_TYPE, CashJournalData::SYS_CASH_JOURNAL_DOC_STATUS, $date, $fromBankCard);

                $bankAccountData->increaseCashReducePending($toBankCardType, $no, $amount, $amount, CashJournalData::SYS_CASH_JOURNAL_DOC_TYPE, CashJournalData::SYS_CASH_JOURNAL_DOC_STATUS, $date, $toBankCard);
                $this->success($no, $date);
            }
            
        }
        
        
        DB::commit();
        $lk->unlock($key);
        return $no;
    }

    /**
     * 失败
     * 
     * 增加锁
     *
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改redis key
     * @author zhoutao
     * @date   2017.10.10
     */
    public function falseJournalDoc($no)
    {
        $lk = new LockData();
        $key = 'confirmJournalDoc' . $no;
        $lk->lock($key);
        DB::beginTransaction();
        $info = $this->getByNo($no);
        $date = date('Y-m-d H:i:s');
        if (!empty($info)) {
            $toBankCardType = $info->syscash_journaldoc_tobankcardtype;
            $fromBankCardType = $info->syscash_journaldoc_frombankcardtype;
            $amount = $info->syscash_journaldoc_amount;
            $fromBankCard = $info->syscash_journaldoc_frombankcard;
            $toBankCard = $info->syscash_journaldoc_tobankcard;
            $status = $info->syscash_journaldoc_status;

            if ($status == self::APPLY_STATUS) {
                $bankAccountData = new BankAccountData;
                $bankAccountData->reducePending($toBankCardType, $no, $amount, CashJournalData::SYS_CASH_JOURNAL_DOC_TYPE, CashJournalData::SYS_CASH_JOURNAL_DOC_STATUS, $date, $toBankCard);

                $bankAccountData->increaseCashReducePending($fromBankCardType, $no, $amount, $amount, CashJournalData::SYS_CASH_JOURNAL_DOC_TYPE, CashJournalData::SYS_CASH_JOURNAL_DOC_STATUS, $date, $fromBankCard);
                $this->fail($no, $date);
            }

            
        }

        
        
        DB::commit();
        $lk->unlock($key);
        return $no;
    }

    /**
     * 更新成功
     *
     * @param $no 单号
     * @param $date 时间
     */
    protected function success($no, $date)
    {
        $info = $this->getByNo($no);
        if (!empty($info)) {
            $info->syscash_journaldoc_success = 1;
            $info->syscash_journaldoc_checkuser = $this->session->userid;
            $info->syscash_journaldoc_checktime = $date;
            $info->syscash_journaldoc_status = self::SUCCESS_STATUS;
            $this->save($info);
        }
    }

    /**
     * 更新失败
     *
     * @param $no 单号
     * @param $date 时间
     */
    protected function fail($no, $date)
    {
        $info = $this->getByNo($no);
        if (!empty($info)) {
            $info->syscash_journaldoc_checkuser = $this->session->userid;
            $info->syscash_journaldoc_checktime = $date;
            $info->syscash_journaldoc_status = self::FAIL_STATUS;
            $this->save($info);
        }
    }
   
}
