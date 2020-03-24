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

class TrendData extends IDatafactory
{
    protected $modelclass = 'App\Model\Product\Trend';

    protected $no = 'proj_no';

    public function getCurves($coinType, $pageSize)
    {
        $where['proj_no'] = $coinType;

        $model = $this->newitem();
        $trends = $model->where($where)->orderBy('proj_time')->get();
        // $trends = $this->query($filters,$pageSize,1);
        return $trends;
    }
}
