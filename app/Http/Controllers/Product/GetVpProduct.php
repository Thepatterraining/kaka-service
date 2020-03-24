<?php

namespace App\Http\Controllers\Product;

use App\Data\User\UserVpData;
use App\Http\Adapter\User\UserVpAdapter;
use App\Http\Controllers\Controller;

class GetVpProduct extends Controller
{

    protected $validateArray=[
       
    ];

    protected $validateMsg = [
        
    ];

    /**
     *
     * @api {post} product/getvpproduct 查询是不是vp
     * @apiName getvpProduct
     * @apiGroup Product
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : token,
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : true
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new UserVpData();
        $adapter = new UserVpAdapter();

        $userid = $this->session->userid;
        $vpInfo = $data->getUser($userid);

        if (empty($vpInfo)) {
            return $this->Success(false);
        } else {
            if ($data->isEnable($userid) === false) {
                return $this->Success(false);
            } else {
                return $this->Success(true);
            }
        }
    }
}
