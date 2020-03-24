<?php
namespace App\Data\Utils;

use App\Data\Sys\ErrorData;

/**
 * 判断银行卡号
 *
 * @author zhoutao
 * @date   2017.11.27
 */
class CheckBankCard
{
    private $res = [
        'code' => 0,
        'msg' => '',
        'success' => true,
    ];

    const MIN_LEN = 16;
    const MAX_LEN = 19;

    /**
     * 判断银行卡号
     *
     * @param  $bankCard 银行卡号
     * @author zhoutao
     * @date   2017.11.27
     */
    public function check($bankCard)
    {
        $this->checkLen($bankCard);
        if ($this->res['success'] === false) {
            return $this->res;
        }
        
        $this->checkBankCardNum($bankCard);
        if ($this->res['success'] === false) {
            return $this->res;
        }
    }

    /**
     * 判断银行卡号长度是否正确
     *
     * @param  $bankCard 银行卡号
     * @author zhoutao
     * @date   2017.11.27
     */
    private function checkLen($bankCard)
    {
        if (strlen($bankCard) > self::MAX_LEN || strlen($bankCard) < self::MIN_LEN) {
            $this->res['code'] = ErrorData::$BANK_CARD_FALSE;
            $this->res['success'] = false;
        }
    }

    /**
     * 判断银行卡号是否是数字
     *
     * @param  $bankCard 银行卡号
     * @author zhoutao
     * @date   2017.11.27
     */
    private function checkBankCardNum($bankCard)
    {
        $bankCard = str_replace(' ', '', $bankCard);
        if (!is_numeric($bankCard)) {
            $this->res['code'] = ErrorData::$BANK_CARD_FALSE;
            $this->res['success'] = false;
        }
    }

}
