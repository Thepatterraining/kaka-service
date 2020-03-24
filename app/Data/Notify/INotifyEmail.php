<?php
namespace App\Data\Notify;

interface INotifyEmail
{

    public function notifyemailrun($address,$name,$notifyName,$attach);
}