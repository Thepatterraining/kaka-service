<?php
namespace App\Data\Cash;

use App\Data\IDataFactory;
use App\Data\Cash\BankAccountData;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\CashJournalData;
use App\Data\Sys\CashData;
use App\Data\Sys\LockData;

class JournalDocData extends IDatafactory
{
    protected $modelclass = 'App\Model\Cash\JournalDoc';

    protected $no = 'cash_journaldoc_no';

    const IN_TYPE = 'CJDT01';
    const OUT_TYPE = 'CJDT02';

    const APPLY_STATUS = 'CJDS01';
    const SUCCESS_STATUS = 'CJDS02';
    const FAIL_STATUS = 'CJDS03';

    /**
     * 插入数据
     *
     * @param $notes 说明
     * @param $bankCard 银行卡
     * @param $bankCardType 银行卡类型
     * @param $amount 金额
     * @param $type 类型
     * @param $status 状态
     */
    public function add($notes, $bankCard, $bankCardType, $amount, $type, $status)
    {
        $model = $this->newitem();
        $docNo = new DocNoMaker;
        $no = $docNo->Generate('CJD');
        
        $model->cash_journaldoc_no = $no;
        $model->cash_journaldoc_notes = $notes;
        $model->cash_journaldoc_bankcard = $bankCard;
        $model->cash_journaldoc_bankcardtype = $bankCardType;
        $model->cash_journaldoc_amount = $amount;
        $model->cash_journaldoc_type = $type;
        $model->cash_journaldoc_status =  $status;
        $this->create($model);
        return $no;
    }

    /**
     * 申请外部转账
     *
     * @param  $notes 说明
     * @param  $bankCard 银行卡号
     * @param  $bankCardType 银行卡类型
     * @param  $amount 金额
     * @param  $type 类型
     * @author zhoutao
     * @date   2017.8.21
     */
    public function createJournalDoc($notes, $bankCard, $bankCardType, $amount, $type)
    {
        DB::beginTransaction();
        $date = date('Y-m-d H:i:s');
        $no = $this->add($notes, $bankCard, $bankCardType, $amount, $type, self::APPLY_STATUS);

        $bankAccountData = new BankAccountData;

        $cashData = new CashData;

        if ($type == self::IN_TYPE) {
            $bankAccountData->increasePending($bankCardType, $no, $amount, CashJournalData::CASH_JOURNAL_DOC_TYPE, CashJournalData::CASH_JOURNAL_DOC_STATUS, $date, $bankCard);

            //资金池 在途 增加
            $cashData->increasePending($no, $bankCard, $amount, JournalData::CASH_JOURNALDOC_TYPE, JournalData::CASH_JOURNALDOC_STATUS, $date);

        } else if($type == self::OUT_TYPE) {
            $bankAccountData->reduceCashIncreasePending($bankCardType, $no, $amount, $amount, CashJournalData::CASH_JOURNAL_DOC_TYPE, CashJournalData::CASH_JOURNAL_DOC_STATUS, $date, $bankCard);
            
            //资金池 在途 增加 余额减少
            $cashData->reduceCashIncreasePending($no, $bankCard, $amount, $amount, JournalData::CASH_JOURNALDOC_TYPE, JournalData::CASH_JOURNALDOC_STATUS, $date);
        }

        DB::commit();
        return $no;
    }

    /**
     * 成功 外部转账
     *
     * @param  $no 单号
     * @author zhoutao
     * @date   2017.8.21
     * 
     * 增加锁
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
            $bankCardType = $info->cash_journaldoc_bankcardtype;
            $type = $info->cash_journaldoc_type;
            $amount = $info->cash_journaldoc_amount;
            $bankCard = $info->cash_journaldoc_bankcard;
            $status = $info->cash_journaldoc_status;

            if ($status == self::APPLY_STATUS) {
                $bankAccountData = new BankAccountData;
                $cashData = new CashData;
                if ($type == self::IN_TYPE) {
                    $bankAccountData->increaseCashReducePending($bankCardType, $no, $amount, $amount, CashJournalData::CASH_JOURNAL_DOC_TYPE, CashJournalData::CASH_JOURNAL_DOC_STATUS, $date, $bankCard);
                    
                    //资金池 余额增加 在途减少
                    $cashData->reducePendingIncreaseCash($no, $bankCard, $amount, $amount, JournalData::CASH_JOURNALDOC_TYPE, JournalData::CASH_JOURNALDOC_STATUS, $date);
                } else if($type == self::OUT_TYPE) {
                    $bankAccountData->reducePending($bankCardType, $no, $amount, CashJournalData::CASH_JOURNAL_DOC_TYPE, CashJournalData::CASH_JOURNAL_DOC_STATUS, $date, $bankCard);
                    
                    //资金池 在途减少
                    $cashData->reducePending($no, $bankCard, $amount, JournalData::CASH_JOURNALDOC_TYPE, JournalData::CASH_JOURNALDOC_STATUS, $date);
                }
                $this->success($no, $date);
            }

            
        }
        
        
        DB::commit();
        $lk->unlock($key);
        return $no;
    }

    /**
     * 拒绝外部转账
     *
     * @param  $no 单号
     * @author zhoutao
     * @date   2017.8.21
     * 
     * 增加锁
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
            $bankCardType = $info->cash_journaldoc_bankcardtype;
            $type = $info->cash_journaldoc_type;
            $amount = $info->cash_journaldoc_amount;
            $bankCard = $info->cash_journaldoc_bankcard;
            $status = $info->cash_journaldoc_status;

            if ($status == self::APPLY_STATUS) {
                $bankAccountData = new BankAccountData;
                $cashData = new CashData;
                if ($type == self::OUT_TYPE) {
                    $bankAccountData->increaseCashReducePending($bankCardType, $no, $amount, $amount, CashJournalData::CASH_JOURNAL_DOC_TYPE, CashJournalData::CASH_JOURNAL_DOC_STATUS, $date, $bankCard);
                    
                    //资金池 在途减少 余额增加
                    $cashData->reducePendingIncreaseCash($no, $bankCard, $amount, $amount, JournalData::CASH_JOURNALDOC_TYPE, JournalData::CASH_JOURNALDOC_STATUS, $date);
                } else if($type == self::IN_TYPE) {
                    $bankAccountData->reducePending($bankCardType, $no, $amount, CashJournalData::CASH_JOURNAL_DOC_TYPE, CashJournalData::CASH_JOURNAL_DOC_STATUS, $date, $bankCard);
                    
                    //资金池 在途减少
                    $cashData->reducePending($no, $bankCard, $amount, JournalData::CASH_JOURNALDOC_TYPE, JournalData::CASH_JOURNALDOC_STATUS, $date);
                }
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
    private function success($no, $date)
    {
        $info = $this->getByNo($no);
        if (!empty($info)) {
            $info->cash_journaldoc_success = 1;
            $info->cash_journaldoc_checkuser = $this->session->userid;
            $info->cash_journaldoc_checktime = $date;
            $info->cash_journaldoc_status = self::SUCCESS_STATUS;
            $this->save($info);
        }
    }

    /**
     * 更新失败
     *
     * @param $no 单号
     * @param $date 时间
     */
    private function fail($no, $date)
    {
        $info = $this->getByNo($no);
        if (!empty($info)) {
            $info->cash_journaldoc_checkuser = $this->session->userid;
            $info->cash_journaldoc_checktime = $date;
            $info->cash_journaldoc_status = self::FAIL_STATUS;
            $this->save($info);
        }
    }
   
}
