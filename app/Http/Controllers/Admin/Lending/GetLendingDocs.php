<?php

namespace App\Http\Controllers\Admin\Bonus;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetLendingDocs extends QueryController
{
    public function getData()
    {
        return new \App\Data\Lending\LendingDocInfoData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Lending\LendingDocInfoAdapter;
    }
}
