<?php

namespace App\Http\Controllers\Admin\Bonus;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetBonusList extends QueryController
{
    public function getData()
    {
        return new \App\Data\Bonus\ProjBonusData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Bonus\ProjBonusAdapter;
    }
}
