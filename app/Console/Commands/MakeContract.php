<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Console\Commands\SqlUtil;

class MakeContract extends Command
{
   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:contract {table} {contract}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a datacontract class for curd operation file';

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

        $contractDir =  "app//Http//DataContract//";
        $sysdataDir =   "app//Http//Data//";
        $controllerDir= "app//Http//DataContract//";
        $adapterDir =   "app//Http//Adapter//";
        $sqlUtil=new SqlUtil();
        $table = $this->argument('table');
        $contract = $this->argument('contract');
        $contractdef = $sqlUtil->getSqlDefine($table);
        $myfile = fopen("app//Http//DataContract//".$contract."Gurd.php", "w");
        fwrite($myfile, "<?php\r\n");
        fwrite($myfile, "namespace App\\Http\\DataContract;\r\n");
        fwrite($myfile, "\r\n");
        fwrite($myfile, "/**\r\n*Code Generate By Soway Lazy Tools.\r\n*@todo Code Review Required And Leave Your NAME under.\r\n*@author your name.<youremail@bjsoway.com>\r\n*@version 0.0.1\r\n**/\r\n");
        fwrite($myfile, "class ".$contract."Gurd{\r\n");
        foreach ($contractdef as $key => $col) {
            fwrite($myfile, "\t/**\r\n");
            fwrite($myfile, "\t *@var ".$col["type"]." ".$col["name"]."\r\n");
            fwrite($myfile, "\t **/\r\n");
            fwrite($myfile, "\tpublic $".$col["name"].";\r\n");
        }
        fwrite($myfile, "}\r\n");
        fclose($myfile);
        $this->info('the file:'."app//Http//DataContract//".$contract."Gurd.php"." has been created");
    }
}
