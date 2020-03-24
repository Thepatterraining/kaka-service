<?php
namespace App\Observers;

use App\Data\Auth\MakeConfigEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventObserver
{
    /**
     * 监听建立操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function created($data)
    {

        $jobClass = get_class($data);
        //类名判空
        if(!class_exists($jobClass)) {
            return ;
        }

        $makeConfigEvent=new MakeConfigEvent();

        $makeConfigEvent->handle();
    }
    /**
     * 监听更新操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function updated($data)
    {

        $jobClass = get_class($data);
        //类名判空
        if(!class_exists($jobClass)) {
            return ;
        }

        $makeConfigEvent=new MakeConfigEvent();

        $makeConfigEvent->handle();
    }

     /**
      * 监听删除操作
      *
      * @param   $data 监听数据
      * @return  mixed
      * @author  liu
      * @version 0.1
      */
    public function deleted($data)
    {
        $jobClass = get_class($data);
        //类名判空
        if(!class_exists($jobClass)) {
            return ;
        }

        $makeConfigEvent=new MakeConfigEvent();
        $makeConfigEvent->handle();
    }
}