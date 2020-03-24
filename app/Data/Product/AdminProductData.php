<?php
namespace App\Data\Product;

use App\Data\IDataFactory;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\UserCashBuyData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;
use App\Data\Item\InfoData as ItemData;
use App\Http\Adapter\Item\InfoAdapter as ItemAdapter;
use App\Data\User\CoinAccountData;
use App\Data\Sys\LockData;
use Illuminate\Support\Facades\DB;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use App\Data\Activity\RegVoucherData;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use App\Data\Cash\UserRechargeData;

class AdminProductData extends IDatafactory
{

    /**
     * 审核通过
     *
     * @param  $productNo 产品单号
     * @author zhoutao
     */
    public function agree($productNo)
    {
        $data = new InfoData;
        $data->saveStatus($productNo, InfoData::$PRODUCT_STATUS_ONE);
    }

    /**
     * 审核拒绝
     *
     * @param  $productNo 产品单号
     * @author zhoutao
     */
    public function refuse($productNo)
    {
        $data = new InfoData;
        $data->revoke($productNo);
    }

    /**
     * 修改产品
     *
     * @param  $productNo 产品单号
     * @param  $data  修改的数据
     * @author zhoutao
     */
    public function saveProduct($productNo,$data)
    {
        if (!empty($data)) {
            $infodata = new InfoData;
            $product = $infodata->getByNo($productNo);
            $adapter = new InfoAdapter;
            $adapter->saveToModel(false, $data, $product);
            $infodata->save($product);

            if (array_key_exists('price', $data)) {
                //修改卖单表价格
                $price = $data['price'];
                $sellData = new TranactionSellData;
                $sellNo = $product->product_sellno;
                $sellInfo = $sellData->getByNo($sellNo);
                if ($sellInfo->sell_status == TranactionSellData::NEW_SELL_STATUS) {
                    $toUserShowPrice = $price;
                    $showCoinScale = $sellInfo->sell_scale;
                    $price = $toUserShowPrice / $showCoinScale;
                    $sellCashFeetype = $sellInfo->sell_feetype;
                    
                    switch ($sellCashFeetype) {
                    case CoinSellData::$SELL_FEE_TYPE_FREE:
                        $showCoinPrice = $price;
                        break;
                    case CoinSellData::$SELL_FEE_TYPE_IN:
                        //价内
                        $showCoinPrice = $price;
                        break;
                    case CoinSellData::$SELL_FEE_TYPE_OUT:
                        //价外
                        $showCoinPrice = $price * (1 + $sellCashFeeRate);
                        break;
                    default:
                        break;
                    }
                    $feePrice = $showCoinPrice * $showCoinScale;
                    $sellInfo->sell_limit = $price;
                    $sellInfo->sell_showcoinprice = $showCoinPrice;
                    $sellInfo->sell_touser_showprice = $toUserShowPrice;
                    $sellInfo->sell_touser_feeprice = $feePrice;
                    $sellData->save($sellInfo);
                }
                
            }

        }
        $this->agree($productNo);
        $product = $infodata->getByNo($productNo);
        return $product;
    }

    /**
     * 终止产品
     *
     * @param $productNo 产品单号
     */
    public function termination($productNo)
    {
        $data = new InfoData;
        $data->revoke($productNo);
    }
}
