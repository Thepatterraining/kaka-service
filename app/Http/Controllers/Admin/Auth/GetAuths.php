<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\QueryController;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;
use App\Data\Auth\AuthGroupItemData;
use App\Data\Sys\ErrorData;
use App\Data\Auth\ItemData;
use App\Http\Adapter\Auth\ItemAdapter;

class GetAuths extends QueryController
{

    public function getData()
    {
        return new ItemData;
    }

    public function getAdapter()
    {
        return new ItemAdapter;
    }
}
