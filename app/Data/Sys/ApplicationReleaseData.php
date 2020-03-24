<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Data\Auth\AccessToken;

class ApplicationReleaseData extends IDatafactory
{
    protected $modelclass = 'App\Model\Sys\ApplicationRelease';
}