<?php
namespace App\Http\Validation;

use Illuminate\Support\Facades\DB;
use App\Utils\Error;

/**
 * 验证一个单据的状态是否符合要求
 *
 * @author    geyunfei(geyunfei@kakamf.com)
 * @version   0.1
 * @copyright Mar 8th,2017
 * CHEERS FOR LADY'S DAY
 * 参数 第一个 单据类型，第二个，单据状状态
 * 其中第一个
 * recharge -- 充值
 * withdrawal -- 提现
 * sell -- 卖单
 * buy --  买单
 */
class Document
{

    private $mapInfo = [
          "recharge"=>["cash_recharge","cash_recharge_no","cash_recharge_status"],
          "withdrawal"=>["cash_withdrawal","cash_withdrawal_no","cash_withdrawal_status"],
          "sell"=>["transaction_sell","sell_no","sell_status"],
          "buy"=>["transaction_buy","buy_no","buy_status"],
          "coinrecharge"=>["coin_rechage","coin_recharge_no","coin_recharge_status"],
          "coinwithdrawal"=>["coin_withdrawal","coin_withdrawal_no","coin_withdrawal_status"],
          "activityinfo"=>["activity_info","activity_no","activity_status"],
          "news"=>["sys_news","news_no","news_type"],
          "product"=>["product_info","product_no","product_status"],
          "bank"=>["finance_bank","bank_no","bank_ischeck"],
          "3rdindoc"=>["sys_3rd_pay_incomedocs","income_no","income_status"],
          "bonus"=>["proj_bonus","bonus_no","bonus_status"],
          "usercashfrozen"=>["user_cashfreezondoc","usercash_freezondoc_no","usercash_freezondoc_status"],
          "syscashjournaldoc"=>["syscash_journaldoc","syscash_journaldoc_no","syscash_journaldoc_status"],
          "cashjournaldoc"=>["cash_journaldoc","cash_journaldoc_no","cash_journaldoc_status"],
          "bonusPlan"=>["proj_bonus_plan","bonusplan_no","bonusplan_status"],
          "coinAddress"=>["coin_addressinfo","coin_address","coin_status"],
            ];
    public function validate($attribute, $value, $parameters, $validator)
    {
        $session = resolve('App\Http\Utils\Session');
        $len = count($parameters);
        if ($len ===0) {
            //至少要有一个参数
            $session->error = 802004;
            return false;
        } else {
            if (array_key_exists($parameters[0], $this->mapInfo)) {//参数未定义，为错
                $info = $this->mapInfo[$parameters[0]];
                $tmp = DB::table($info[0])->where($info[1], $value);
                if ($len>1) {
                    $index = 1;

                    while ($index<$len) {
                        if ($index > 1) {
                            $tmp = $tmp->orwhere($info[2], $parameters[$index]);
                        } else {
                            $tmp = $tmp->where($info[2], $parameters[$index]);
                        }
                        $index++;
                    }
                }
                $count = $tmp->count();
                if ($count!=0) {
                        return true;
                }
                       
                $session->error = 802006;
                return false;
            }
            $session->error = 802005;
            return false;
        }
    }

    public function replace($message, $attribute, $rule, $parameters)
    {
        return "";
    }
}
