<?php
namespace App\Data\Queue;
use App\Data\Notify\NotifyDefineData;

/**
 * 通用业务处理类
 */
class Handler
{

    /**
     * 数据格式
     * { queuedata:
     * { key: 'created',
     *   time: '2017-11-22 16:26:37',
     *   event: 'App\\Model\\Monitor\\ErrorInfo',
     *   data:
     *    { dumpinfo: 's',
     *      token: 's',
     *      url: 's',
     *      created_id: 0,
     *      updated_at: '2017-11-22 16:26:37',
     *      created_at: '2017-11-22 16:26:37',
     *      id: 21288 },
     *   messagetype: '',
     *   source: null } }
     */
    public function HandleQueueData($q)
    {

        $interface = "App\\Data\\Queue\\IHandleData";
        $key = $q->event;
        $event = $q->key;
        $data = $q->data;
        $def_fac = new NotifyDefineData();
        $items = $def_fac->getDefines($key, $event);
        foreach($items as $handle){

            $deal_class = $handle->notify_specialclass;
            if(class_exists($deal_class) && class_implements($interface)) {
                $deal_obj = new $deal_class();
                $deal_obj->HandleData($q, []);
            }
        }
    }
}
