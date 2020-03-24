<?php
namespace App\Data\Region;

use App\Data\IDataFactory;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;

class CountryData extends IDatafactory
{
    protected $modelclass = 'App\Model\Region\Country';
}
