<?php

namespace Cybereits\Common\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Cybereits\Common\Utils\SqlHelper;
use Cybereits\Common\Model\DeployJobItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class Deploy  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sys:deploy';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'excute deploy job';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sqlHelper = new SqlHelper();
        $this->info("check the deploy job");
        if (DeployJobItem::CheckTable()===true) {
            $this->info("the deploy table is OK");
        } else {
            // $this->info("begin create deploy table");
            DeployJobItem::CreateTable();
        }
        //$this->info($result);
        // $this->info("current work directory:".__DIR__);
        $dir = __DIR__;
        $dir = $dir . "/../../../sql_scripts";
        $files=scandir($dir);
        sort($files);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filename = $dir.'/'.$file;
                $item = DeployJobItem::getJobItem($file);
                if ($item!=null) {
                    if ($item -> item_status == DeployJobItem::STATUS_SUCCESS) {
                        //  $this->info("the {$file} has been appied .");
                        continue;
                    }
		    continue;
                } else {
                    $item = DeployJobItem::newItem($file);
                }
                
                $item->item_status = DeployJobItem::STATUS_EXCUTE;
                $item->save();
                $this->info("begin excute {$file}.");
                $handle = fopen($filename, 'r');
                $str =  fread($handle, filesize($filename));
                $sqls = explode(";", $str);
              
                try {
                    DB::beginTransaction();
                    foreach ($sqls as $sql) {
                        if (trim($sql)!= "") {
                            DB::connection()->statement($sql);
                        }
                    }
                    DB::commit();
                } catch (QueryException  $e) {
                    $this->comment("error . please view log file");
                    
                    Log::info($e);
                    DB::rollback();
                    continue;
                }
                
                $this->comment("success");
                
                
                $item->item_status = DeployJobItem::STATUS_SUCCESS;
                $item->save();
            }
        }
        $dir = __DIR__;
        $dir = $dir . "/../../../bash";
        $files=scandir($dir);
        sort($files);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filename = $dir.'/'.$file;
                $item = DeployJobItem::getJobItem($file);
                if ($item!=null) {
                    if ($item -> item_status == DeployJobItem::STATUS_SUCCESS) {
                        $this->info("the {$file} has been appied .");
                        continue;
                    }
                } else {
                    $item = DeployJobItem::newItem($file, DeployJobItem::TYPE_BASH);
                }
                
                $item->item_status = DeployJobItem::STATUS_EXCUTE;
                $item->save();
                $this->info("begin excute bash file {$file}.");
                passthru("bash ".$filename);
                $this->comment("success");
                
                
                $item->item_status = DeployJobItem::STATUS_SUCCESS;
                $item->save();
            }
        }
    }
}
