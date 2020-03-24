<?php
namespace App\Data\Auth;

use Illuminate\Support\Facades\DB;

class MakeConfigEvent
{
    public function handle()
    {
        //查询所有通知model
        $result=DB::select("select event_model,event_observer from event_define where event_model is not null or event_observer is not null group by event_model,event_observer");

        if(empty($result)) {
            return ;
        }
        //若文件存在则删除
        if(file_exists("config//event.php")) {
            unlink("config//event.php");
        }
        //创建文件
        $myfile = fopen("config//event.php", "w");
        fwrite($myfile, "<?php\r\n");
        fwrite($myfile, "return [\r\n");

        //循环写入model名称
        foreach($result as $value)
        {
            if($value->event_model!=null) {
                fwrite($myfile, "    '".$value->event_model."'"."=>"."'".$value->event_observer."',\r\n");
            }
        }
        fwrite($myfile, "];");
        fclose($myfile);
        return true;
    }
}