<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Report;
use Illuminate\Support\Facades\Storage;
use App\Data\User\UserData;
use App\Http\Adapter\AdapterFac;
use App\Data\Sys\LogData;
use App\Data\Report\ReportSumsDayData;

use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  
use Illuminate\Support\Facades\DB; 

class UserDayReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:report_user_daily';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make User Day Report';
    
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
        $headers=["列名","上期用户基数","增长数","到周期结束数量","上期用户活跃基数","增长活跃","当前活跃","开始时间","结束时间"];
        $userSumsReport=new ReportSumsDayData();
        $this->info("用户信息日报汇总");
        $users=$userSumsReport->getReport()->toArray();
        $this->table($headers, $users);
        $tablename="report_users_daily";
        dd($this->create_table($tablename, $users));
    }

    public function create_table($table_name,$arr_field)  
    {  
        $tmp = $table_name;  
        $va = $arr_field;  
  
        $value_str= array();  
        $id = 1;  
        foreach($va as $key => $value){
            $report=DB::select("select * from $tmp where id=?", [$id]); 
            if(count($report)<1) {  
  
                $content = implode(",", $value);  
                $content2 = explode(",", $content);  
                foreach ( $content2 as $key => $val ) {  
                    $value_str[] = "'$val'";  
                }  
                $news = implode(",", $value_str);  
                $news = "$id,".$news;  
                DB::insert("insert into $tmp values ($news)");  
                //$value_str = '';  
                $value_str= array();  
                $id = $id + 1;  
            }  
        }  
        return 1;  
    }  
}
