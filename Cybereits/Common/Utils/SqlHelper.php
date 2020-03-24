<?php
namespace Cybereits\Common\Utils;

use Illuminate\Support\Facades\DB;

class SqlHelper
{

    private $sqlMap = array(
        "int"=>"int",
        "varchar"=>"string",
        "text"=>"string",
        "datetime"=>"datetime",
        "char"=>"string",
        "tinyint"=>"bool",
        "bigint"=>"long",
        "decimal"=>"decimal"

    );
    public function getSqlDefine($table)
    {
        
        $langArray = array(
            "cn"=>"zh-cn",
            "en"=>"en-us"
        );
        $appCols = array(
        "created_at"=>false,
        "updated_at"=>false,
        "deleted_at"=>false,
        );
        $tmp =  DB::connection()->select('show columns from '.$table);
        $realTable = "";
        $tableStruct = explode('_', $table);
        if (count($tableStruct)>1) {
            $realTable = $tableStruct[count($tableStruct)-1];
        } else {
            $realTable = $table;
        }
        $haveId = false;
        foreach ($tmp as $col) {
            $colField = $col->Field;
            $column = $col->Field;
           
            $is_app_col=false;
            if (array_key_exists($colField, $appCols)===true) {
                $appCols[$colField]=true;
                $is_app_col=true;
            }
             
            if ($is_app_col) {
                continue;
            }
            $colField= explode('_', $colField);
            $cols_type = explode('(', $col->Type);
            $col_type="";
            if (count($cols_type)>0) {
                $col_type=$this->sqlMap[$cols_type[0]];
            } else {
                $col_type = $col->Type;
            }
            //echo "???";
            switch (count($colField)) {
            case 0:
                //unimpossible;
                break;
            case 1:
                //id .
                //echo 'add';
                $key = $colField[0];
                $contractdef[$key]= array(
                "name"=>$colField[0],
                "type"=>$col_type,
                "col"=>$column
                    );
                    //echo 'ok';
                break;
            case 2:
                // internal var ;
                if ($realTable == $colField[0]) {
                    $contractdef[$colField[1]] = array(

                    "name"=>$colField[1],
                    "type"=>$col_type,
                    "col" =>$column
                    );
                } else {
                    /// echo "1";
                    if (array_key_exists($colField[0], $contractdef)==false) {
                        $contractdef[$colField[0]] = array();
                    }
                    $varArray = $contractdef[$colField[0]];
                    $varArray ["name"] = $colField[0];
                    $varArray ["type"]=$col_type;
                    $varArray ["col"]= $column;
                    $contractdef[$colField[0]]=$varArray;
                }


                break;
            case 3:
                if ($realTable == $colField[0]) {
                    if (array_key_exists($colField[1], $contractdef)==false) {
                        $contractdef[$colField[1]]=array();
                    }
                       $varArray = $contractdef[$colField[1]] ;
                    if (array_key_exists($colField[2], $langArray)==true) {
                        $varArray["name"]=$colField[1];
                        $varArray["type"] =$col_type;
                        if (array_key_exists("cols", $varArray)==false) {
                            $varArray["cols"]=array();
                        }
                        $langs = $varArray["cols"];
                        $lang_def = $langArray[$colField[2]];
                        if (array_key_exists($lang_def, $langs)==false) {
                            $langs[$lang_def] = array(
                            "col"=>$column,
                            "type"=>$col_type
                            );
                        }
                        $varArray ["cols"]=$langs;
                    }
                       $contractdef[$colField[1]]  = $varArray;
                } else {
                    //multi type
                    $varname = $colField[0];
                    $mulname = $colField[1];
                    $lang = $colField[2];
                    if (array_key_exists($varname, $contractdef)==false) {
                        $contractdef[$varname]=array(
                        "name"=>$varname,
                        );
                    }
                    $varArray = $contractdef[$varname];
                    if (array_key_exists("pros", $varArray)==false) {
                        $varArray["pros"]=array();
                    }
                    $pros = $varArray["pros"];
                    if (array_key_exists($mulname, $pros)==false) {
                        $pros[$mulname] = array(
                               
                        );
                    }

                    $mularray = $pros[$mulname];
 
                        
                        
                    if (array_key_exists($lang, $langArray)==true) {
                        $mularray ["name"]=$mulname;
                        // $mularray ["type"] =$col_type;
                             
                        if (array_key_exists("cols", $mularray)==false) {
                            $mularray ["cols"]=array();
                        }
                           
                        $langs = $mularray ["cols"];
                        $lang_def = $langArray[$lang];
                        if (array_key_exists($lang_def, $langs)==false) {
                            $langs[$lang_def] = array(
                            "col"=>$column,
                            "type"=>$col_type
                            );
                        }
                        $mularray ["cols"]=$langs;
                    }



                    $pros[$mulname]=$mularray;

                    $varArray["pros"]=$pros;
                    //$varArray["name"]=$varname;
                    $contractdef[$varname] = $varArray;
                }
                break;
            default:
                break;
            }
        }
        
        return $contractdef;
    }

    public function checkTableIsExists($table)
    {
        $table = DB::connection()->select('show tables like "'.$table.'"');

        return count($table) === 0 ?false:true;
    }
}
