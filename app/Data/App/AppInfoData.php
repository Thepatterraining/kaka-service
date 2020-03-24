<?php
namespace App\Data\App;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class AppInfoData extends IDatafactory
{
    protected $modelclass = 'App\Model\App\AppInfo';

    protected $no = 'appid';
}
