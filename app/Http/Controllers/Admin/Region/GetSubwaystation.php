<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaystationData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaystationAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class GetSubwaystation extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入地铁站id",
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

        $data = new SubwaystationData();
        $adapter = new SubwaystationAdapter();

        $subwaystation = $data->get($id);
        $subwaystation = $adapter->getDataContract($subwaystation);
        
        $this->Success($subwaystation);
    }
}
