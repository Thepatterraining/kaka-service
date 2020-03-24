<?php
namespace App\Http\Contract;

use App\Http\Contract\BasicOption;

class QueryOption extends BasicOption
{
    public $pageSize;
    public $pageIndex;
    public $filters;
}
