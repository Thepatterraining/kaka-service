<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\DistrictData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\DistrictAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class DeleteDistrict extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入区id",
    ];

    /**
     * 删除区
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new DistrictData();
        $adapter = new DistrictAdapter();

        $data->delete($id);
        
        $this->Success();
    }
}
