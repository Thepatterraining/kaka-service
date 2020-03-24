<?php
namespace Cybereits\Common;
use Illuminate\Support\Facades\DB;
use Exception;
class CommonException extends Exception
{
    public $Msg ;
    public $Code ;

    public function __construct($msg, $code, Exception $previous = null)
    {
        $this->Msg = $msg ;
        $this->Code = $code ;
        DB::rollback();
        parent::__construct($msg, $code, $previous);
    }
}
