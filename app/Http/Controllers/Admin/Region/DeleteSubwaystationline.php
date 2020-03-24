<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaystationlineData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaystationlineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class GetSubwaystationline extends Controller
{
    protected $validateArray=[
        "data.lineid"=>"required",
        "data.name"=>"required",
        "data.index"=>"required",
        "data.stationid"=>"required",
        "data.stationName"=>"required",
    ];

    protected $validateMsg = [
        "data.name.required"=>"请输入线路名",
        "data.lineid.required"=>"请输入线路id",
        "data.index.required"=>"请输入顺序",
        "data.stationid.required"=>"请输入站点id",
        "data.stationName.required"=>"请输入站点名称",
    ];

    /**
     * 添加地铁站
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new SubwaystationlineData();
        $adapter = new SubwaystationlineAdapter();

        $data->delete($id);
        
        $this->Success();
    }
}
