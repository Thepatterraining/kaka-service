<?php
namespace Cybereits\Common\Event;

class EventHandler
{


  /**
   * { event: 'created',
   *   time: '2017-12-23 05:50:33',
   *   model: 'Cybereits\\Modules\\KYC\\Model\\EmailCheck',
   *   data:
   *      { email: 'geyunfei@gmail.com',
   *        checkcode: 123456,
   *        verify: false,
   *        timeout: '17-12-23 05:50:32',
   *        sendcount: 1,
   *        updated_at: '2017-12-23 05:50:32',
   *        created_at: '2017-12-23 05:50:32',
   *        id: 146,
   *        queueKey: 'created' },
   * }
   */
    public function Handle($queueData)
    {
        $event = $queueData->event;
        $model = $queueData->model;
        $data =  $queueData->data;

        $cfg = config("handler");
        if (array_key_exists($model, $cfg) === true) {
            $setting = $cfg [$model];
            if (array_key_exists($event, $setting) === true) {
                $handleClasses = $setting [$event];
                foreach ($handleClasses as $handleClass) {
                    
                    $interface = class_implements($handleClass);
                    if (array_key_exists("Cybereits\Common\Event\IHandleLogic", $interface)) {
                        $handleObj = new $handleClass;
                        $handleObj -> Handle($data);
                    }
                }
            }
        }
    }
}
