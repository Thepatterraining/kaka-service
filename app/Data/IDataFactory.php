<?php
namespace App\Data;

use Illuminate\Support\Facades\Log;
use App\Http\Utils\RaiseEvent;
use App\Http\Utils\Queue;
 

abstract class IDataFactory
{
    
    
    use RaiseEvent,Queue;

    protected $addedCreateUser = true;
    
    protected $session;
    protected $userid ;
    
    public function __construct($userid = null)
    {
        $this->session = resolve('App\Http\Utils\Session');
        if($userid != null) {
     
            $this->userid = $this->session->userid;
        }
        
    }
    protected $modelclass;
    
    
    private function chkVal($input)
    {
        
        $regMath = "/([a-z-A-Z])+([0-9]){19}/";
        if (is_numeric($input)) {
            return true;
        } else {
            return preg_match($regMath, $input);
        }
    }
 




    private function getQueryable($filter,$orderby)
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
                    if ($this->chkVal($val)) {
                        if ($tmp ==null) {
                            $tmp = $classname::where($col, $val);
                        } else {
                            $tmp = $tmp->where($col, $val);
                        }
                    } else {
                        if ($tmp ==null) {
                            $tmp = $classname::where($col, 'like', '%' . $val . '%');
                        } else {
                            $tmp = $tmp->where($col, 'like', '%'.$val.'%');
                        }
                    }
                }
            }
        }
        if ($tmp == null) {
            $tmp = $classname::where('id', '>', '0');
        }


        foreach($orderby as $orderKey=>$orderMethod) {
                $tmp = $tmp->orderBy($orderKey, $orderMethod);
        }
        return $tmp ;
        

    }
    public function query($filter,$pageSize,$pageIndex,$orderby=["id"=>"desc"])
    {
        
        

        $tmp =$this->getQueryable($filter, $orderby);
        $result = array();
        $result['totalSize'] = $tmp->count();
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        $result["pageCount"]= ($result['totalSize']-$result['totalSize']%$result["pageSize"])/$result["pageSize"] +($result['totalSize']%$result["pageSize"]===0?0:1);
        return $result;
    }

    public function getFirst($filter)
    {
          $tmp =$this->getQueryable($filter, $orderby = ["id"=>"desc"]);
          return $tmp->first();
    }
    public function queryAllWithoutPageturn($filter,$callback,...$params)
    {

             $pageIndex = 1;
        $pageSize = 100;
                $itemIndex=0;
            $result = $this->query($filter, $pageSize, $pageIndex);
        if($result["pageCount"]>0) {
            while($pageIndex<=($result["pageCount"])){
                
                
                foreach($result["items"] as $item){
             
                    $callback($item, $itemIndex, ...$params);
                           $itemIndex ++;
                 
                }
                $pageIndex ++;
                $result = $this->query($filter, $pageSize, $pageIndex);
                
            }
        }
    }
    //报表专用查询
    public function userquery($row,$filter,$pageSize,$pageIndex,$orderby=["id"=>"desc"])
    {
        
        

        $tmp =$this->getUserQueryable($filter, $orderby, $row);
        $result = array();
        $result['totalSize'] = $tmp->count();
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        $result["pageCount"]= ($result['totalSize']-$result['totalSize']%$result["pageSize"])/$result["pageSize"] +($result['totalSize']%$result["pageSize"]===0?0:1);
        return $result;
    }
    public function getUserQueryable($filter,$orderby,$row)
    {
        $classname = $this->modelclass;
      
        $tmp=$classname::wherebetween($row, [$filter['filters'][$row][0],$filter['filters'][$row][1]]);//->get();
        foreach($orderby as $orderKey=>$orderMethod) {
                $tmp = $tmp->orderBy($orderKey, $orderMethod);
        }
        return $tmp;
    }

    /**
     * whereIn查找
     *
     * @param   $in 条件
     * @param   $pageSize
     * @param   $pageIndex
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.5
     */
    public function WhereIn($in, $pageSize, $pageIndex)
    {
        $model = $this->newitem();
        $res = [];
        $tmp = null;
        if (is_array($in)) {
            foreach ($in as $col => $val) {
                if (is_array($val)) {
                    if ($tmp == null) {
                        $tmp = $model->whereIn($col, $val);
                    } else {
                        $tmp = $tmp->whereIn($col, $val);
                    }
                } else {
                    if ($tmp == null) {
                        $tmp = $model->where($col, $val);
                    } else {
                        $tmp = $tmp->where($col, $val);
                    }
                }
            }
        }
        $res['totalSize'] = $tmp->count();
        $res['items'] = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $res["pageIndex"]=$pageIndex;
        $res["pageSize"]=$pageSize;
        $res["pageCount"]= ($res['totalSize']-$res['totalSize']%$res["pageSize"])/$res["pageSize"] +($res['totalSize']%$res["pageSize"]===0?0:1);
        return $res;
    }
    

    
    
    /**
     * between 条件返回操作后的对象
     *
     * @param  $filter
     * @param  array  $between between
     *                         的条件
     * @return mixed 对象
     */
    public function whereBetween($filter, $between = array())
    {
        $classname =$this->modelclass;
        foreach ($filter as $col => $val) {
            $tmp = $classname::whereBetween($col, $between);
        }
        return $tmp;
    }
    
    /**
     * wehre orm的条件
     *
     * @param  null  $tmp   之前有过操作的对象
     * @param  array $where where 的条件
     * @return mixed 操作后的对象
     */
    public function where($tmp = null, $where = array())
    {
        $modelclass = $this->modelclass;
        if ($tmp == null) {
            return $modelclass::where($where);
        } else {
            return $tmp->where($where);
        }
    }
    
    /**
     * 求和
     *
     * @param  string $field 求和的字段
     * @param  null   $tmp   之前有过操作的对象
     * @return mixed 操作后的对象
     */
    public function sum($field, $tmp = null)
    {
        $modelclass = $this->modelclass;
        if ($tmp == null) {
            return $modelclass::sum($field);
        } else {
            return $tmp->sum($field);
        }
    }
    
    /**
     * 最后的分页get
     *
     * @param  $tmp 之前有过操作的对象
     * @param  int                             $pageIndex 分页的页码
     * @param  int                             $pageSize  每页的数量
     * @return array 返回数组
     */
    public function _query($tmp, $pageIndex = 1, $pageSize = 10)
    {
        $result = array();
        if ($tmp == null) {
            $tmp = $this->modelclass;
            $result['totalSize'] = $tmp::count();
            $tmp = $tmp::orderBy('id', 'desc');
        } else {
            $result['totalSize'] = $tmp->count();
            $tmp = $tmp->orderBy('id', 'desc');
        }
        $result['items'] =  $tmp->offset($pageSize*($pageIndex - 1))->limit($pageSize)->get();
        return $result;
    }
    public function get($id)
    {
        
        
        $modelclass  = $this->modelclass;
        return $modelclass::where('id', $id)->first();
    }
    
    /**
     * 查找一条记录
     *
     * @param  array $_where 查找条件
     * @return mixed 查找后的对象
     */
    public function find($_where = null)
    {
        $modelclass = $this->modelclass;
        if ($_where == null) {
            $first = $modelclass::first();
        } else {
            $first = $modelclass::where($_where)->first();
        }
        return $first;
    }
    /**
     * 查找一条记录
     *
     * @param  array $_where 查找条件
     * @return mixed 查找后的对象
     */
    public function findForUpdate($_where = null)
    {
        
        
        
        $modelclass = $this->modelclass;
        if ($_where == null) {
            $tmp = $modelclass::first();
            $first = $modelclass::where('id', $tmp->id)->lockforupdate()
            ->first();
        } else {
            $first = $modelclass::where($_where)->lockforupdate()
            ->first();
        }
        return $first;
    }
    
    /**
     * 查找字段
     *
     * @param  string $_field 要查找的字段
     * @param  array  $_where 查找条件
     * @return mixed 查找后的对象
     */
    public function getField($_field, $_where = null)
    {
        $modelclass =$this->modelclass;
        if ($_where == null) {
            return $modelclass::first($_field);
        } else {
            return $modelclass::where($_where)->first($_field);
        }
    }
    public function create($item)
    {
        
        if ($this->addedCreateUser && !empty($this->session)) {
            $item->created_id = $this->session->userid;
        }
        
        $item->save();
        return $item->id;
    }
    
    public function delete($id)
    {
        $modelclass = $this->modelclass;
        return $modelclass::where('id', $id)->delete();
    }
    
    protected $no = "id";
    public function getByNo($id)
    {
        $modelclass = $this->modelclass;
        $no = $this->no;
        return $modelclass::where($no, $id)->first();
    }
    public function save($item, $_where = null)
    {
        if ($_where == null) {
            return $item->save();
        } else {
        }
    }
    
    public function update($item, $_where = null)
    {
        if ($_where == null) {
            return $item->update();
        } else {
        }
    }
    public function newitem()
    {
        $modelclass = $this->modelclass;
        return new $modelclass();
    }
}
