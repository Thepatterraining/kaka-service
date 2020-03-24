<?php

namespace App\Http\Controllers;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


abstract class QueryController extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];

 
    abstract function getData();
    abstract function getAdapter();
    protected function getMergeFilters($array)
    {

        return $array;

    }
    protected function getItem($attr)
    {

 
        return $attr;
    }
    /**
     * 查询管理员信息
     *
     * @param   $pageIndex
     * @param   $pageSize
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $request = $this->request->all();
        $data = $this->getData();
        $adapter =$this->getAdapter();

        if(array_key_exists('querydic', $request)) {
            

            $items["dics"]=$adapter-> getDics();
            $items['support_graphql']=true;
            return $this->Success($items);
            
                    
        
        }

        $filers = $adapter->getFilers($request);
        $filers = $this->getMergeFilters($filers);
        $item = $data->query($filers, $request['pageSize'], $request['pageIndex']);
     
        $dics = null;
        if(array_key_exists("dics", $request)) {
            $dics = $request["dics"];
        }

       

        $res = [];
        foreach ($item['items'] as $val) {
            $arr = $adapter->getDataContract($val, $dics, true);
            $res[] = $this->getItem($arr);
        }
        $item['items'] = $res;
        $item['support_graphql']=true;
        return $this->Success($item);
    }



    public function getJobData($filters,$callback,...$param)
    {
        $data = $this->getData();
        $adapter =$this->getAdapter();
        $req ["filters"] = $filters;
         $qfilters = $adapter->getFilers($req);
         $data->queryAllWithoutPageturn(
             $qfilters, function ($item,$index,$callback,$adapter,...$param) {
                $contract = $adapter->getDataContract($item, null, true);
                $contract = $this->getItem($contract);
                $callback($contract, $index, ...$param);
             }, $callback, $adapter, ...$param
         );
    }

    public function getDocs()
    {
        $adapter = $this->getAdapter()->getDics();

    }
}
