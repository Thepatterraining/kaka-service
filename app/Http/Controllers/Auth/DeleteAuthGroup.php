<?php

namespace App\Http\Controllers\Auth;

use App\Data\Item\InfoData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Http\Adapter\App\UserInfoAdapter;
use App\Data\Activity\GroupData;
use App\Http\Adapter\Activity\GroupAdapter;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupAdapter;
use App\Data\Auth\AuthGroupItemData;

class DeleteAuthGroup extends Controller
{

    protected $validateArray=[
        "groupid"=>"required",
    ];

    protected $validateMsg = [
        "groupid.required"=>"请输入管理组id",
    ];

    /**
     * 删除管理组信息
     *
     * @param $groupid 管理组id
     */
    public function run()
    {   
        $id = $this->request->input('groupid');

        $data = new AuthGroupData;
        $groupItemData = new AuthGroupItemData;
        $groupUsers = $groupItemData->getUsers($id);
        if (!$groupUsers->isEmpty()) {
            return $this->Error(\App\Data\Sys\ErrorData::$AUTH_GROUP_USER_REQUIRED);
        }
        
        $data->delete($id);

        return $this->Success();
    }
}
