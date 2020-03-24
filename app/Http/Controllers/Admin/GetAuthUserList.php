<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetAuthUserList extends QueryController
{

    public function getData()
    {
        return new  UserData();
    }

    public function getAdapter()
    {
        return new UserAdapter();
    }
}
