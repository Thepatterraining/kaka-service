<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\SqlUtil;

class MakeAdapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:adapter {table} {contract}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a adapter file';
        
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
        //
        
        $adapterDir =   "app//Http//Adapter//";
        $sqlUtil=new SqlUtil();
        $table = $this->argument('table');
        $contract = $this->argument('contract');
        $sqlUtil=new SqlUtil();
        $contractdef = $sqlUtil->getSqlDefine($table);
        $className = explode('/', $contract);
        
        
        $myfile = fopen($adapterDir.$contract."Adapter.php", "w");
        
        fwrite($myfile, "<?php\r\n");
        fwrite($myfile, "namespace App\\Http\\Adapter\\".$className[0].";\r\n");
        fwrite($myfile, "\r\n");
        fwrite($myfile, "use App\\Http\\Adapter\\IAdapter;\r\n\r\n");
        fwrite($myfile, "/**\r\n*Code Generate By KaKa Lazy Tools.\r\n*@todo Code Review Required And Leave Your NAME under.\r\n*@author your name.<youremail@kakamf.com>\r\n*@version 0.0.1\r\n**/\r\n");
        fwrite($myfile, "class ".$className[1]."Adapter extends IAdapter{\r\n");
            fwrite($myfile, "\tprotected \$mapArray = [\r\n");
            $has_write = false;
        foreach ($contractdef as $key => $col) {
            if (array_key_exists("col", $col)) {
                fwrite($myfile, "\t\t".($has_write?",\"":" \"").$col["name"]."\"=>\"".$col["col"]."\"\r\n");
                $has_write=true;
            }
        }
            
            fwrite($myfile, "\t];\r\n");
            
            $has_write=false;
        foreach ($contractdef as $key => $col) {
            if (array_key_exists("cols", $col)) {
                if ($has_write==false) {
                    fwrite($myfile, "\tprotected \$langArray=[\r\n");
                }
                fwrite($myfile, "\t\t".($has_write?",\"":" \"").$col["name"]."\"=>[\r\n");
                $has_write=true;
                $has_colwrite = false;
                $collang = $col["cols"];
                foreach ($collang as $lang => $langcol) {
                    fwrite($myfile, "\t\t\t".($has_colwrite?",\"":" \"").$lang."\"=>\"".($langcol["col"])."\"\r\n");
                    $has_colwrite=true;
                }
                fwrite($myfile, "\t\t]\r\n");
            }
        }
            
        if ($has_write) {
            fwrite($myfile, "\t];\r\n");
        }
        
        fwrite($myfile, "\tprotected function fromModel(\$contract,\$model,\$items){\r\n");
        fwrite($myfile, "\t}\r\n");
        fwrite($myfile, "\tprotected function toModel(\$contract,\$model,\$items){\r\n");
        $vardef = "";
        $ifcommand = "\t\tif(count(\$items)>0){\r\n";
        foreach ($contractdef as $key => $col) {
            if (array_key_exists('pros', $col)) {
                $vardef= $vardef."\t\t$".$key."=\"".$key."\";\r\n";
                $ifcommand =$ifcommand. "\t\t\tif(\$items[\$".$key."]!= null){\r\n";
               
               



                $ifcommand=$ifcommand."\t\t\t}\r\n";
            }
        }

        fwrite($myfile, "\t}\r\n");
        fwrite($myfile, "}\r\n");
        fclose($myfile);
        $this->info('the file '.$adapterDir.$contract."Adapter.php"." has been created");
    }
}
