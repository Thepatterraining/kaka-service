<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;

class GetCashFreezonDocs extends QueryController
{

    public function getData()
    {
        return new \App\Data\User\CashFreezonDocData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\User\CashFreezonDocAdapter;
    }
}
