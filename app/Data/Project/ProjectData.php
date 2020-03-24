<?php
namespace App\Data\Project;

use App\Data\IDataFactory;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Project\ProjectInfoAdapter;
use App\Http\Adapter\Project\ProjectInvestsTypeDefineAdapter;
use App\Http\Adapter\Project\ProjectTagsAdapter;
use App\Http\Adapter\Project\ProjectStatusAdapter;
use App\Http\Adapter\Project\ProjectProceedsAdapter;
use App\Http\Adapter\Project\ProjectAnnualRateAdapter;
use App\Http\Adapter\Project\ProjectInfoItemAdapter;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Sys\ModelData;
use App\Http\Controllers\Project\GetProject;
use App\Http\Adapter\Project\ProjectTypeAdapter;
use App\Data\User\UserTypeData;

    /**
     * 项目管理
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectData
{

    /**
     * 查询项目详细
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getProject($coinType)
    {
        $res = [];

        $projectInfoData = new ProjectInfoData;
        $investsTypeDefineData = new ProjectInvestsTypeDefineData;
        $projectTagsData = new ProjectTagsData;
        $projectStatusData = new ProjectStatusData;
        $projectProceedsData = new ProjectProceedsData;
        $projectAnnualRateData = new ProjectAnnualRateData;
        $transSellData = new TranactionSellData;
        $projectInfoItemData = new ProjectInfoItemData;
        $projectTypeData = new ProjectTypeData;

        $projectInfoAdapter = new ProjectInfoAdapter;
        $investsTypeDefineAdapter = new ProjectInvestsTypeDefineAdapter; 
        $projectTagsAdapter = new ProjectTagsAdapter;
        $projectStatusAdapter = new ProjectStatusAdapter;
        $projectProceedsAdapter = new ProjectProceedsAdapter;
        $projectAnnualRateAdapter = new ProjectAnnualRateAdapter;
        $projectInfoItemAdapter = new ProjectInfoItemAdapter;
        $projectTypeAdapter = new ProjectTypeAdapter;

        $projectInfo = $projectInfoData->getByNo($coinType);
        $modelData=new ModelData();
        $modelId=$modelData->getModelIdByModel($projectInfo);

        $infoArray = ['name','coinType','score','scale','investsTypeid', 'holdLast', 'bonusType', 'honusPeriods', 'id', 'type'];
        $info = $projectInfoAdapter->getDataContract($projectInfo, $infoArray);
        $projectid = $info['id'];
        $info['holdLast'] = date('Y年m月d日', strtotime($info['holdLast']));

        //查询收益类型
        $investsTypeid = $info['investsTypeid'];
        $investsTypeDefine = $investsTypeDefineData->get($investsTypeid);
        $investsType = $investsTypeDefineAdapter->getDataContract($investsTypeDefine);
        
        //查询标签
        $tags = [];
        $projectTags = $projectTagsData->getTagsByNo($coinType);
        foreach ($projectTags as $tag) {
            $tag = $projectTagsAdapter->getDataContract($tag);
            $tags[] = array_get($tag, 'tagName', '');
        }

        //查询项目状态
        $projectStatus = $projectStatusData->getStartStatusByNo($coinType);
        $status = $projectStatusAdapter->getDataContract($projectStatus);

        //查询收益类型
        $proceeds = $this->getProceeds($coinType);
        
        //查询平均年化
        $annualrate = $this->getAnnualRates($coinType);

        //查询类型
        $type = [];
        $projectType = $projectTypeData->get($info['type']);
        $type = $projectTypeAdapter->getDataContract($projectType, ['id','name']);

        //查询属性
        $projectInfoItems = $projectInfoItemData->getItemsByNo($coinType);
        $projectInfoItemArray = ['name','value','pre','suf','itemGroupName'];
        $infoItems = [];
        $detailsItems = [];
        $details = [];
        foreach ($projectInfoItems as $projectInfoItem) {
            $infoItem = $projectInfoItemAdapter->getDataContract($projectInfoItem, $projectInfoItemArray);
            $detailsItems[$infoItem['itemGroupName']][] = $infoItem;
        }
        foreach ($detailsItems as $key => $val) {
            $infoItems['group'] = $key;
            $infoItems['items'] = $val;
            $details[] = $infoItems;
        }

        //最低买入价格
        $currentPrice = $transSellData->getCurrentPrice($coinType);

        //查询分红
        $bonusInfo = $this->getBonusInfo($info['bonusType']);
        $bonusInfo['bonusPeriods'] = intval($info['honusPeriods']);

        //查询图片
        $resourceIndexData = new ResourceIndexData;
        $imgUrl = $resourceIndexData->getUrl($modelId, $projectid, ResourceIndexData::OVERVIEW_IMG);

        $res = $info;
        $res['type'] = $type;
        $res['investsType'] = $investsType;
        $res['tags'] = $tags;
        $res['status']['id'] = array_get($status, 'statusid', 0);
        $res['status']['name'] = array_get($status, 'statusName', '');
        $res['proceeds'] = $proceeds;
        $res['annualrate'] = $annualrate;
        $res['currentPrice'] = $currentPrice;
        $res['details'] = $details;
        $res['bonusInfo'] = $bonusInfo;
        $res['img_url'] = $imgUrl;
        return $res;    
        
    }

    /**
     * 查询年化收益
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.18
     * 
     * 改成返回数组
     * @author zhoutao
     * @date   2017.10.19
     */
    public function getAnnualRates($coinType)
    {
        $projectAnnualRateData = new ProjectAnnualRateData;
        $projectAnnualRateAdapter = new ProjectAnnualRateAdapter;

        $projectAnnualRates = $projectAnnualRateData->getAnnualRatesByNo($coinType);
        $annualRateArray = ['rate','year','isHistory'];
        $annualRateSum = 0;
        $annualRateCount = 0;
        $annualRates = [];
        $history = [];
        $value = [];
        $rate = [];
        $isHistory = 1;
        foreach ($projectAnnualRates as $projectAnnualRate) {
            $annualRate = $projectAnnualRateAdapter->getDataContract($projectAnnualRate, $annualRateArray);
            if ($annualRate['isHistory'] == 0) {
                $isHistory = 0;
            }
            $annualRateSum += $annualRate['rate'];
            $annualRateCount++;
            $rate[] = $annualRate['rate'];
            $history[] = $annualRate;
        }

        $value[] = $projectAnnualRateData->getAvgAnnualRateByNo($coinType);
        $annualRates['value'] = $value;
        $annualRates['history'] = $history;
        return $annualRates;
    }

    /**
     * 查询收益类型
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.18
     */
    public function getProceeds($coinType)
    {
        $projectProceedsData = new ProjectProceedsData;
        $projectProceedsAdapter = new ProjectProceedsAdapter;

        $proceeds = [];
        $projectProceeds = $projectProceedsData->getProceedsByNo($coinType);
        $projectProceedArray = ['id','name','note'];
        foreach ($projectProceeds as $projectProceed) {
            $proceed = $projectProceedsAdapter->getDataContract($projectProceed, $projectProceedArray);
            $proceeds[] = $proceed;
        }
        return $proceeds;
    }

    /**
     * 查询可交易区间
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 修改项目指导价的获取
     * @author zhoutao
     * @date   2017.10.20
     * 
     * 增加区间配置
     * @author zhoutao
     * @date   2018.3.23 
     */ 
    public function getInterval($coinType)
    {
        $projectGuidingPriceData = new ProjectGuidingPriceData;
        $guidingPrice = $projectGuidingPriceData->getGuidingPrice($coinType);
        $res = [];
        $res['start'] = 0;
        $res['end'] = 0;
        //获取 区间 配置
        $userTypeData = new UserTypeData;
        $session = resolve('App\Http\Utils\Session');
        $sysConfigs = $userTypeData->getData($session->userid);
        if (!empty($guidingPrice)) {
            $res['start'] = intval(bcmul($guidingPrice->project_guidingprice, $sysConfigs[UserTypeData::SELL_INTERVAL_MIN], 2));
            $res['end'] = intval(bcmul($guidingPrice->project_guidingprice, $sysConfigs[UserTypeData::SELL_INTERVAL_MAX], 2));
        }
        return $res;
    }

    /**
     * 判断价格在可交易区间
     *
     * @param  $coinType 代币类型
     * @param  $price 价格
     * @author zhoutao
     * @date   2017.10.19
     */ 
    public function checkInterval($coinType, $price)
    {
        $interval = $this->getInterval($coinType);
        if (bccomp($interval['start'], $price, 2) === 1 || bccomp($price, $interval['end'], 2) === 1) {
            return false;
        }
        return true;
    }

    /**
     * 查询分红信息
     *
     * @param  $bonusid projectBonus.id
     * @author zhoutao
     * @date   2017.10.20
     * 
     * 修改成数据库查询所有bonusType并排序
     * @author zhoutao
     * @date   2017.11.3
     */
    private function getBonusInfo($bonusid)
    {
        $bonusInfo = [];
        $projectBonusTypeData = new ProjectBonusTypeData;
        $bonus = $projectBonusTypeData->get($bonusid);
        $bonusTypes = $projectBonusTypeData->getBonusTypes();
        if (empty($bonus)) {
            $bonusInfo['name'] = '';
            $bonusInfo['rightConform'] = '';
            $bonusInfo['rightDiviend'] = '';
            $bonusInfo['bonusRate'] = '';
            $bonusInfo['bonusCyc'] = [];
            return $bonusInfo;
        }
        $name = $bonus->bonus_name;
        $rightConform = $bonus->bonus_confirminfo;
        $rightDiviend = $bonus->bonus_diviendinfo;
        $bonusRate = $bonus->bonus_rate;
        foreach ($bonusTypes as $key => $bonusType) {
            $bonusCyc[$key]['name'] = $bonusType->bonus_cyc;
            $bonusCyc[$key]['select'] = false;
            if ($bonusType->bonus_cyc == $bonus->bonus_cyc) {
                $bonusCyc[$key]['select'] = true;
            }
        }

        $bonusInfo['name'] = $name;
        $bonusInfo['rightConform'] = $rightConform;
        $bonusInfo['rightDiviend'] = $rightDiviend;
        $bonusInfo['bonusRate'] = $bonusRate;
        $bonusInfo['bonusCyc'] = $this->getBonusCycs($bonusCyc);
        return $bonusInfo;
    }

    /**
     * 只显示3个
     *
     * @param  $bonusCycs
     * @author zhoutao
     * @date   2017.11.14
     */
    private function getBonusCycs($bonusCycs)
    {
        $count = count($bonusCycs);
        if ($count <= 3) {
            return $bonusCycs;
        }
        $count -= 1;
        $arr = [];
        foreach ($bonusCycs as $key => $bonusCyc) {
            if ($bonusCyc['select']) {
                if ($key <= $count - 2) {
                    $arr[] = $bonusCycs[$key];
                    $arr[] = $bonusCycs[$key + 1];
                    $arr[] = $bonusCycs[$key + 2];
                } else if ($key == $count - 1) {
                    $arr[] = $bonusCycs[$key - 1];
                    $arr[] = $bonusCycs[$key];
                    $arr[] = $bonusCycs[$key + 1];
                } else if ($key == $count) {
                    $arr[] = $bonusCycs[$key - 2];
                    $arr[] = $bonusCycs[$key - 1];
                    $arr[] = $bonusCycs[$key];
                }
            }
            
        }
        return $arr;
    }

}
