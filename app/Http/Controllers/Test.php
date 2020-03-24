<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Utils\Error;
use App\Http\Utils\Session;
use App\Data\TestData;
use App\Http\Controllers\Controller;
use Validator;

class Test extends Controller
{
    

 
    protected function run()
    {
        
        $item =$this->session->token;
        
 
        $this->Success($item);
    }
}
