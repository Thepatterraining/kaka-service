<?php

namespace Tests\Unit;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;
use App\Libs\ExcelMaker;

use App\Data\User\UserData;
class ExcelTest extends TestCase
{
    public function testBasicTest()
    {

            
        $maker = new ExcelMaker();
        $i = 1;
        for($col =1;$col<100;$col++){
            dump($col . "  ".$maker->getCol($col));
        }


        $userFac = new UserData();

        $users = $userFac->query([], 100, 1);


        $saveCol = [
            '姓名'=>'user_name',
            '手机'=>'user_mobile',
            '上次登录时间'=>'user_lastlogin'
        ];

        dump($users);

        $maker->saveModelToExcel($saveCol, $users['items'], 'test.xlsx');


    }
}