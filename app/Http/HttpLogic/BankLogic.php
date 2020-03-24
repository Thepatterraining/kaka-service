<?php
namespace App\Http\HttpLogic;

use App\Http\HttpLogic\DictionaryLogic;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Data\User\UserBankCardData;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Data\Cash\FinanceBankData;
use App\Http\Adapter\Cash\FinanceBankAdapter;
use App\Data\Payment\PayBanklimitData;
 

class BankLogic
{
    public function getBank($id)
    {
        $bankdata = new BankData();
        $bankadapter = new BankAdapter();
        $diclogic = new DictionaryLogic();
        $bank = $bankdata->get($id);
        $item = $bankadapter->getFromModel($bank, false);
        $item["type"]=$diclogic->getDic("bank", $item["type"]);
        return $item;
    }


    public function getUserBankCardInfo($no)
    {
        $bkData = new UserBankCardData();
        $adp = new UserBankCardAdapter();

        $cardInfo = $bkData->getByNo($no);


        if ($cardInfo===null) {
            return null;
        }

        $cardItem = $adp->getDataContract($cardInfo);

        $cardItem["bank"]=$this->getBankInfo($cardItem["bank"]);

        return $cardItem;
    }

    /**
     * 查询银行信息
     */
    public function getBankInfo($id, $channelid = 5)
    {
        $bankdata = new BankData();
        $bankadapter = new BankAdapter();
        $bank = $bankdata->get($id);
        $item = $bankadapter->getFromModel($bank, false);
        $bankNo = array_get($item, 'no', 1);
        $financeBankData = new FinanceBankData();
        $financeBankAdapter = new FinanceBankAdapter();
        $bankInfo = $financeBankData->getByNo($bankNo);
        $bankLimitData = new PayBanklimitData;
        $pertop = $bankLimitData->getPertop($bankNo, $channelid);
        $daytop = $bankLimitData->getDaytop($bankNo, $channelid);
        $bankInfo = $financeBankAdapter->getDataContract($bankInfo, ['name','icon']);
        $bankInfo = array_add($bankInfo, 'pertop', $pertop);
        $bankInfo = array_add($bankInfo, 'daytop', $daytop);

        return $bankInfo;
        //return array_get($bankInfo, 'name');
    }

     /**
      * 查询银行信息
      */
    public function getBankName($id)
    {
        $bankdata = new BankData();
        $bankadapter = new BankAdapter();
        $bank = $bankdata->get($id);
        $item = $bankadapter->getFromModel($bank, false);
        $bankNo = array_get($item, 'no', 1);
        $financeBankData = new FinanceBankData();
        $financeBankAdapter = new FinanceBankAdapter();
        $bankInfo = $financeBankData->getByNo($bankNo);
        $bankInfo = $financeBankAdapter->getDataContract($bankInfo, ['name']);

        // return $bankInfo;
        return array_get($bankInfo, 'name');
    }

    /**
     * 查询银行支行名称
     */
    public function getBranchBankName($id)
    {   
        $bankdata = new BankData();
        $bankadapter = new BankAdapter();
        $bank = $bankdata->get($id);
        $item = $bankadapter->getFromModel($bank, false);
        return array_get($item, 'name');
    }



    public function getUserCardInfo($bankNo)
    {
         
        $bkData = new UserBankCardData();
        $adp = new UserBankCardAdapter();
        $cardInfo = $bkData->getByNo($bankNo);
        if ($cardInfo===null) {
            return null;
        }

        $cardItem = $adp->getDataContract($cardInfo);

        $cardItem["bank"]=$this->getBankDetail($cardItem["bank"]);

        return $cardItem;
    }



    
    public function getBankDetail($id)
    {
        $bankdata = new BankData();
        $bankadapter = new BankAdapter();
        $bank = $bankdata->get($id);
        $item = $bankadapter->getFromModel($bank);
        $bankNo = array_get($item, 'no', 1);
        $financeBankData = new FinanceBankData();
        $financeBankAdapter = new FinanceBankAdapter();
        $bankInfo = $financeBankData->getByNo($bankNo);
        $bankInfo = $financeBankAdapter->getDataContract($bankInfo);
         $item["type"]= array_get($bankInfo, 'name');
         return $item ;
        //return array_get($bankInfo, 'name');
    }
}
