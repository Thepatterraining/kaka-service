<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;


/**
 * 判断账户在途是否为负
 *
 * @author zhoutao
 * @date   2017.10.12
 */
class CheckAccount
{
    const ERROR_MSG = '账户异常，请联系管理员';
    private $session;
    public function __construct(Session $session)
    {

        $this->session = $session;
    }
    use Error;

    //protected $result ;
    /**
     * 判断账户在途是否为负
     *
     * @author zhoutao
     * @date   2017.10.12
     */
    public function handle($request, Closure $next)
    {
            $tokenFac = new AccessToken();
            $accessToken= $request->input("accessToken");

            $cashAccountData = new CashAccountData;
            $coinAccountData = new CoinAccountData;
           
        if ($accessToken == null) {
            $this->Error(ErrorData::$TOKEN_NOT_FOUND);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        } else {
            $userid = $tokenFac->checkAccessToken($accessToken)["userid"];
            $this->session->token=$accessToken;
            if ($userid === null) {
                $this->Error(ErrorData::$TOKEN_TIMEOUT);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } elseif ($userid ==  0) {
                $this->Error(ErrorData::$USER_NOT_LOGIN);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } else {
                $uid = $userid;
                $this->session->userid=$uid;
                
                try {
                    //查询现金
                    $cashAccountInfo = $cashAccountData->getByNo($uid);
                    if (empty($cashAccountInfo)) {
                        throw new \Exception(self::ERROR_MSG);
                    }
                
                    if ($cashAccountInfo->account_pending < 0) {
                        throw new \Exception(self::ERROR_MSG);
                    }
                    //查询代币
                    $coinAccounts = $coinAccountData->getInfo($uid);
                    foreach ($coinAccounts as $coinAccount) {
                        if ($coinAccount->usercoin_pending < 0) {
                            throw new \Exception(self::ERROR_MSG);
                        }
                    }
                } catch (\Exception $e) {
                    return response(
                        json_encode(
                            $e,
                            JSON_UNESCAPED_UNICODE
                            |JSON_PRETTY_PRINT
                            |JSON_NUMERIC_CHECK
                        )
                    );
                }
                 return $next($request);
            }
        }
    }
}
