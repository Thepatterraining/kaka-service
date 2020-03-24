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

class SaveAuthGroup extends Controller
{

    protected $validateArray=[
        "groupid"=>"required",
        "data.groupName"=>"required",
        "data.groupNote"=>"required",
    ];

    protected $validateMsg = [
        "groupid.required"=>"请输入管理组id",
        "data.groupName.required"=>"请输入管理组名称",
        "data.groupNote.required"=>"请输入管理组描述",
    ];

    /**
     * 修改管理组信息
     *
     * @param $groupid 管理组id
     */
    public function run()
    {
        $id = $this->request->input('groupid');

        $data = new AuthGroupData;
        $adapter = new AuthGroupAdapter;
        $model = $data->get($id);
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $model);
        $data->save($model);

        $info = $adapter->getDataContract($model);

        return $this->Success($info);
    }
}
