<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class CompanyData extends IDatafactory
{
   

    protected $modelclass = 'App\Model\Sys\Company';

    protected $no = 'company_no';
}
