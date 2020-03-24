<?php
namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use App\Console\Commands\SqlUtil;
use Illuminate\Support\Facades\DB;

class DeployJobItem extends Model
{

    const createStr ="CREATE TABLE `kk_deploy_jobitem` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `item_name` varchar(255) DEFAULT '',
            `item_type` varchar(30) DEFAULT 'JS01',
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `item_success` bit(1) DEFAULT NULL,
            `item_status` varchar(30) DEFAULT '' ,    
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

      const TYPE_SQL =  'JS01';
      const TYPE_BASH = 'JS02';

      const STATUS_INIT = "JST01";
      const STATUS_EXCUTE="JST02";
      const STATUS_SUCCESS = "JST03";
      const STATUS_FAIL = "JST04";


    protected $table = "kk_deploy_jobitem";
    protected $dates = ["created_at","updated_at","deleted_at"];


    public static function CheckTable()
    {

    
        $sqlHelper = new SqlUtil();
        return $sqlHelper->checkTableIsExists("kk_deploy_jobitem");
    }

    public static function CreateTable()
    {

        DB::connection()->statement(DeployJobItem::createStr);
    }


    public static function getJobItem($name)
    {
          $item = DeployJobItem::where('item_name', $name)->first();
            return $item;
    }
    public static function newItem($name, $type = DeployJobItem::TYPE_SQL)
    {
        $item = new DeployJobItem();
        $item->item_name = $name;
        $item->item_success = 0;
        $item->item_status=DeployJobItem::STATUS_INIT;
        $item->item_type = $type;
        $item->save();
        return $item;
    }
}
