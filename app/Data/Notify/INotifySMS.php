<?php
namespace App\Data\Notify;

//2017.8.23 更新通知接口 liu
interface INotifySMS
{

    public function SMSnotifycreatedrun($data);
    public function SMSnotifysavedrun($data);
    public function SMSnotifydeletedrun($data);
}