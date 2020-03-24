<?php 
namespace App\Observers;
use App\Http\Model\Resource\ResourceBannerpic;
// use App\Data\MessageQueue\RabbitMQ;

class TestObserver extends ModelObserver
{
    protected $event_queue="";
    public function created($data)
    {
        return true;
    }
    public function saved($data)
    {
       // dump($attributes['banner_resourceid']);
        // dump($original['banner_resourceid']);
        return true;
    }
}
