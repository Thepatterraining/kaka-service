<?php

namespace App\Http\Controllers\Admin\Region;

use App\Data\Region\SubwaystationData;
use App\Data\Activity\ItemData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Region\SubwaystationAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\GroupItemData;

class DeleteSubwaystation extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入地铁站id",
    ];

    /**
     * 删除地铁站
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $id = $this->request->input('id');

        $data = new SubwaystationData();
        $adapter = new SubwaystationAdapter();

        $data->delete($id);
        
        $this->Success();
    }
}
