<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\System\Resource\Data\ResourceGroupData;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Project\ProjectInfoData;
use App\Data\Sys\ModelData;

class GetProjectResource extends Controller
{

    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型",
    ];


    /**
     * @api {post} token/project/getprojectresource 查询项目资源
     * @apiName getprojectresource
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型 KKC-BJ0001
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinType : 'KKC-BJ0001'
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     * {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *       'name' : '一号房产',
     *       'coinType' : 'KKC-BJ0001',
     *       'resources' : {
     *              {
     *              'group':"房产图片",
     *              'items':{
     *                      {
     *                          'type':"jpg",
     *                          'text':"户型图",
     *                          'url':"/upload/KKC-BJ0001/huxingtu.jpg"
     *                      },
     *                      {
     *                          'type':"jpg",
     *                          'text':"外景图",
     *                          'url':"/upload/KKC-BJ0001/waijing.jpg"
     *                      },
     *                      {
     *                          'type':"jpg",
     *                          'text':"内景图",
     *                          'url' :"/upload/KKC-BJ0001/neijing.jpg"
     *                       }
     *                   }
     *               },
     *               {
     *                  'group':"房产权证"，
     *                  'items':{
     *                      {
     *                          'type':"jpg",
     *                          'text':"购房合同",
     *                          'url':"/upload/KKC-BJ0001/hetong1.jpg"
     *                      },
     *                      {
     *                          'type':"jpg",
     *                          'text':"房产证",
     *                          'url':"/upload/KKC-BJ0001/fangchanzheng1.jpg"
     *                      },
     *                      {
     *                          'type':"jpg",
     *                          'text':"公证文件",
     *                          'url':"/upload/KKC-BJ0001/taxiangquanzheng.jpg"
     *                      }
     *                  }
     *              }
     *           }
     *       }
     *   }
     */
    // public function run()
    // {
    //     $request = $this->request->all();

    //     $res = [
    //         'name' => '一号房产',
    //         'coinType' => 'KKC-BJ0001',
    //         'resources' => [
    //             [
    //                 'group'=>"房产图片",
    //                 'items'=>[
    //                     [
    //                         'type'=>"jpg",
    //                         'text'=>"户型图",
    //                         'url'=>"/upload/KKC-BJ0001/huxingtu.jpg"
    //                     ],
    //                     [
    //                         'type'=>"jpg",
    //                         'text'=>"外景图",
    //                         'url'=>"/upload/KKC-BJ0001/waijing.jpg"
    //                     ],
    //                     [
    //                         'type'=>"jpg",
    //                         'text'=>"内景图",
    //                         'url'=>"/upload/KKC-BJ0001/neijing.jpg"
    //                     ]
    //                 ]
    //             ],
    //             [
    //                 'group'=>"房产权证",
    //                 'items'=>[
    //                     [
    //                         'type'=>"jpg",
    //                         'text'=>"购房合同",
    //                         'url'=>"/upload/KKC-BJ0001/hetong1.jpg"
    //                     ], 
    //                     [
    //                         'type'=>"jpg",
    //                         'text'=>"房产证",
    //                         'url'=>"/upload/KKC-BJ0001/fangchanzheng1.jpg"
    //                     ],
    //                     [
    //                         'type'=>"jpg",
    //                         'text'=>"公证文件",
    //                         'url'=>"/upload/KKC-BJ0001/taxiangquanzheng.jpg"
    //                     ]
    //                 ]
    //             ]
    //         ]
    //     ];
    //     return $this->Success($res);
    // }
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coinType'];

        $projectInfoData=new ProjectInfoData();
        $resourceGroupData=new ResourceGroupData();
        $resourceIndexData=new ResourceIndexData();
        $modelData=new ModelData();

        $itemInfo=$projectInfoData->newitem()->where('project_no', $coinType)->first();
        $itemId=$itemInfo->id;
        $itemName=$itemInfo->project_name;
        $modelId=$modelData->getModelIdByModel($itemInfo);

        $res['coinType']=$coinType;
        $res['name']=$itemName;
        $res['resources']=$resourceGroupData->getResourceItem($modelId, $itemId);
        return $this->Success($res);
    }
}
