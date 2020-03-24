<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InvitationCodeData;
use App\Http\Adapter\Activity\InvitationCodeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetUserInvitationCode extends QueryController
{
    public function getData()
    {
        return new  InvitationCodeData();
    }

    public function getAdapter()
    {
        return new InvitationCodeAdapter();
    }
}
