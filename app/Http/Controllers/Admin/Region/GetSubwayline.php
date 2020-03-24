<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaylineData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaylineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class GetSubwayline extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入地铁线id",
    ];

    /**
     * 添加地铁线路
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new SubwaylineData();
        $adapter = new SubwaylineAdapter();

        $subwayline = $data->get($id);
        $subwayline = $adapter->getDataContract($subwayline);
        
        $this->Success($subwayline);
    }
}
