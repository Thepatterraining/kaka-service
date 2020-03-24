<?php
namespace App\Data\User;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\RegVoucherData;
use App\Data\Sys\ConfigData;
use App\Model\User\User;
use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\User\CashAccountData;
use App\Data\Auth\AccessToken;

/**
 * user operation
 *
 * @author  geyunfei (geyunfei@kakamf.com)
 * @version 0.1
 */

class UserTypesData extends IDatafactory
{

    protected $modelclass = 'App\Model\User\UserTypes';
}
