<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
// use App\Data\Notify\DefineData;

use App\Console\Commands\SqlUtil;

    /**
     * 更新event配置文件
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
class MakeConfigEvent extends Command
{
   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update config event file';

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
        // $defineData=new DefineData();
        $result=DB::select("select event_model from event_define group by event_model");
        dump($result);
        if(empty($result)) {
            return ;
        }

        if(file_exists("config//event.php")) {
            unlink("config//event.php");
        }
        $myfile = fopen("config//event.php", "w");
        fwrite($myfile, "<?php\r\n");
        fwrite($myfile, "return [\r\n");
        dump($result); 

        foreach($result as $value)
        {
            if($value->event_model!=null) {
                fwrite($myfile, "    '".$value->event_model."',\r\n");
            }
        }
        fwrite($myfile, "];");
        fclose($myfile);
        $this->info('the file:'."config//event.php"." has been updated");
    }
}
