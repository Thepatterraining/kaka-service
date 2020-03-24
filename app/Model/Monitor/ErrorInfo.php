<?php
namespace App\Model\Monitor;
/**
 * 系统错误的状态类
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorInfo extends Model
{
    //
    use SoftDeletes;
    protected $table = "monitor_error";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
