<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class AccountData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\Account';
}
