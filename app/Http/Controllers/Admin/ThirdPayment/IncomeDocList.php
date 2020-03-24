<?php
namespace App\Http\Controllers\Admin\ThirdPayment;

use App\Http\Controllers\QueryController;
use App\Http\Adapter\ThirdPayment\ThirdPaymentIndocAdapter;
use App\Data\Payment\PayIncomedocsData;

class IncomeDocList extends QueryController
{

    function getData()
    {
        return new PayIncomedocsData();
    }
    function getAdapter()
    {
        return new ThirdPaymentIndocAdapter();
    }

    function getItem($contract)
    {
 
        return $contract;
    }
}
