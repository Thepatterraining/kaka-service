<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class NewsTypeData extends IDatafactory
{

    protected $modelclass = 'App\Model\Sys\NewsType';

    protected $no = "news_no";

}
