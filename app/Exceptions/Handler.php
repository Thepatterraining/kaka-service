<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use App\Mail\DBErrorReport;
use App\Data\Sys\LogData;
use App\Http\Utils\RaiseEvent;
use App\Data\Monitor\SystemBug;

class Handler extends ExceptionHandler
{
    use RaiseEvent;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class//,
    //    \Illuminate\Validation\ValidationException::class,
    ];
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
       $this->_saveBug($exception);
    }

    private function _saveBug($exception)
    {
	//dump($exception);
        if($this->_report == false) {
     	    parent::report($exception);
             $debugFac = new SystemBug();
            $url = "";
            if (array_key_exists("REQUEST_URI", $_SERVER)) {
                $url  = $_SERVER["REQUEST_URI"];
            }
            $dumpinfo=$exception->getMessage().$exception->getFile().$exception->getLine().$exception->getTraceAsString();//"wrong..";
            $debugFac -> addBug("", $url, $dumpinfo);
		 info($dumpinfo);
            $this->RaisQueueEvent();
            $this->_report = true;
        }
    }

    private $_report = false ;

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $this->_saveBug($exception);
        return response()->json(["code"=>-1,"msg"=>"unkown msg ,please view log db"], 200);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
