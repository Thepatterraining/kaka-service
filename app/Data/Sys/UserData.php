<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class UserData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\User';

    public function getUser($userid)
    {
        $where['id'] = $userid;
        return $this->findForUpdate($where);
    }

    /**
     * 查询时间段内用户数据
     *
     * @param   $startTime 开始时间
     * @param   $endTime 结束时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserWhereTime($row,$startTime, $endTime)//,$filter,$pageSize,$pageIndex)
    {
        $model = $this->newitem();
        $res = $model->whereBetween($row, [$startTime,$endTime])->get();
        return $res;
    }
    
    public function getMaxId($datetime)
    {
        $model = $this->modelclass;
        $item =  $model::where('created_at', '<=', $datetime)->orderBy('id', 'desc')->first();
        if($item!=null) {
            return $item->id;
        }
        else
        {
            return 0 ; 
        }
    }
    /**
     * 查询历史用户数量
     *
     * @param   $date 开始时间
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getMaxIdDay($date)
    {
        $model = $this->modelclass;
        $item =  $model::where('created_at', '<=', $date)->whereNull('deleted_at')->count();
        return $item;
    }
    public function getAllId($datetime)
    {
        $model = $this->modelclass;
        $item =  $model::where('created_at', '<=', $datetime)->orderBy('id', 'desc')->get();
        if(!$item->isEmpty()) {
            return $item;
        }
        else
        {
            return 0 ; 
        }
    }
}
