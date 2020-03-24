<?php

namespace Cybereits\Common\DAL;

use Illuminate\Support\Facades\Log;
use App\Http\Utils\RaiseEvent;
use App\Http\Utils\Queue;

abstract class IMySqlModelFactory
{
    protected $modelclass;
    protected $addedCreateUser = false ;
    
    public function Create($item)
    {
        if ($this->addedCreateUser && !empty($this->session)) {
            $item->created_id = $this->session->userid;
        }
      
        $item->save();
        return $item->id;
    }
    public function Delete($id)
    {
        $modelclass = $this->modelclass;
        return $modelclass::where('id', $id)->delete();
    }
    public function Get($id)
    {
        return $this->GetFirst([
            "id" => $id
        ]);
    }
    public function Save($item, $_where = null)
    {
        if ($_where == null) {
            return $item->save();
        } else {
        }
    }
    public function Update($item, $_where = null)
    {
        if ($_where == null) {
            return $item->update();
        } else {
        }
    }
    public function Newitem()
    {
        $modelclass = $this->modelclass;
        return new $modelclass();
    }
    public function GetFirst($filter)
    {
        $query =  $this->_query($filter);
        return $query->first();
    }
    public function CheckIsExists($filter)
    {
        $modelclass = $this->modelclass;
        $query_cxt = null;
        foreach ($filter as $col => $value) {
            if ($query_cxt === null) {
                $query_cxt = $modelclass::where($col, $value);
            } else {
                $query_cxt = $query_cxt->where($col, $value);
            }
        }
        return $query_cxt -> first() !== null;
    }
    public function Query($filter)
    {
        return $this->_query($filter)->get();
    }
    public function GetList()
    {
        $modelclass = $this->modelclass;
        return $modelclass::get();//->orderby ('id','desc');
    } 
    
    public function queryWithPaging($filter,$pageSize,$pageIndex,$orderby=["id"=>"desc"])
    {
        
        

        $tmp =$this->_query($filter, $orderby);
        $result = array();
        $result['totalSize'] = $tmp->count();
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        $result["pageCount"]= ($result['totalSize']-$result['totalSize']%$result["pageSize"])/$result["pageSize"] +($result['totalSize']%$result["pageSize"]===0?0:1);
        return $result;
    }
    protected function _query($filter, $orderby=[])
    {
        $compareOP = ["<","<=",">",">=","="];
        $classname = $this->modelclass;
        $tmp = null;

 
        if (count($filter)) {
            foreach ($filter as $col => $val) {
                if (is_array($val)) {
                    if (in_array($val[0], $compareOP)) {
                        if ($tmp ==null) {
                            $tmp = $classname::where($col, $val[0], $val[1]);
                        } else {
                            $tmp = $tmp->where($col, $val[0], $val[1]);
                        }
                    } else {
                        if ($tmp ==null) {
                            $tmp = $classname::whereBetween($col, $val);
                        } else {
                            $tmp = $tmp->whereBetween($col, $val);
                        }
                    }
                } else {
                    if ($tmp ==null) {
                        $tmp = $classname::where($col, $val);
                    } else {
                        $tmp = $tmp->where($col, $val);
                    }
                }
            }
        }
        if ($tmp == null) {
            $tmp = $classname::where('id', '>', '0');
        }
        foreach ($orderby as $orderKey=>$orderMethod) {
            $tmp = $tmp->orderBy($orderKey, $orderMethod);
        }
       
        return $tmp ;
    }
}
