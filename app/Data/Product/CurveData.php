<?php
namespace App\Data\Product;

use App\Data\IDataFactory;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;

class CurveData extends IDatafactory
{
    public function getCurves()
    {
        $Curves = [];
        for ($i = 0; $i < 10; $i++) {
            $month = 2 + $i;
            $time = '2016-' . $month . '-1';
            $Curves[$i] = [
                'price'=>rand(10000, 99999),
                'datetime'=>date('Y-m-d H:i:s', strtotime($time))
            ];
        }
        return $Curves;
    }
}
