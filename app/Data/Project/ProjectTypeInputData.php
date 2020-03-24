<?php
namespace App\Data\Project;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;

    /**
     * 项目的curd
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectTypeInputData
{
    /**
     * 获取要输入的数据
     */
    public function getInfoItemDefines($typeid)
    {
        $projectTypeItmeData = new ProjectTypeItemData;
        
        $items = $projectTypeItmeData->getInfoItemDefines($typeid);

        $projectTypeScoreData = new ProjectTypeScoreData;
        $scores = $projectTypeScoreData->getScores($typeid);

        $res = [];
        $res['items'] = $items;
        $res['scores'] = $scores;
        return $res;
    }
    
    /**
     * 创建项目
     */
    public function ConvertTypeInputs($inputs)
    {
        // dump($inputs);
        $projectInfoItmeDefineData = new ProjectInfoItemDefineData;
        $projectInfoItemData = new ProjectInfoItemData;
        $projectTypeItemData = new ProjectTypeItemData;
        $projectInfoData = new ProjectInfoData;
        $projectScoreItemData = new ProjectIsCoreItemData;
        $projectScoreDefineData = new ProjectScoreDefineData;
        $projectProceedsData = new ProjectProceedsData;
        $projectTagsData = new ProjectTagsData;
        $projectStatusData = new ProjectStatusData;
        $guidingPriceData = new ProjectGuidingPriceData;
        $projectAnnualRateData = new ProjectAnnualRateData;
        $projectCompanyData = new ProjectCompanyData;
        $projectShareHolderData = new ProjectShareHolderData;
        $projectHolderData = new ProjectHolderData;
        $projectShareHolderTypeData = new ProjectShareHolderTypeData;

        $coinType = $inputs['coinType'];
        $name = $inputs['name'];
        $scale = $inputs['scale'];
        $coinAmmount = $inputs['coinAmmount'];
        $startTime = $inputs['startTime'];
        $investsType = $inputs['investsType'];
        $status = $inputs['status'];
        $bonusType = $inputs['bonusType'];
        $bonusPeriods = $inputs['bonusPeriods'];
        $guidingPrice = $inputs['guidingPrice'];
        $holds = $inputs['holds'];
        $projectHoldType = $holds['type'];
        $projectHolderid = $holds['id'];
        $projectHoldLast = $holds['holdLast'];
        $projectType = $holds['type'];

        DB::beginTransaction();

        //计算项目总评分
        $scoreAmmount = 0;
        $scoreCount = 0;
        $scoreAvg = 0;
        foreach ($inputs['score'] as $input) {
            $scoreAmmount += $input;
            $scoreCount++;
        }
        $scoreAvg = $scoreCount == 0 ? 0 : $scoreAmmount / $scoreCount;
        $projectid = $projectInfoData->add($coinType, $name, $scale, $coinAmmount, $startTime, $investsType, $status, $scoreAvg, $bonusType, $bonusPeriods, $projectHoldType, $projectHolderid, $projectHoldLast, $projectType);

        if ($projectid > 0) {
             //项目详细
            foreach ($inputs['items'] as $key => $input) {
                $infoItemDefine = $projectInfoItmeDefineData->getByNo($key);
                if (!empty($infoItemDefine)) {
                    $infoItemDefineid = $infoItemDefine->id;
                    

                    $typeItem = $projectTypeItemData->getByNo($infoItemDefineid);
                    if (!empty($typeItem)) {
                        $groupid = $typeItem->item_group_id;
                        $projectInfoItemData->add($infoItemDefineid, $groupid, $input, $projectid);   
                    }
                    
                }
                
            }

            //评分
            $scoreIndex = 1;
            foreach ($inputs['score'] as $key => $input) {
                $scoreDefine = $projectScoreDefineData->getByNo($key);

                if (!empty($scoreDefine)) {
                    $scoreDefineid = $scoreDefine->id;
                    $projectScoreItemData->add($scoreDefineid, $input, $projectid, $scoreIndex);
                    $scoreIndex++;
                }
            }

            //添加项目收益类型
            foreach ($inputs['proceeds'] as $input) {
                $projectProceedsData->add($coinType, $input);
            }

            //添加项目标签
            foreach ($inputs['tags'] as $input) {
                $projectTagsData->add($coinType, $input);
            }

            //添加项目状态
            $projectStatusData->add($coinType, $status, $startTime);

            //添加项目指导价
            $guidingPriceData->add($coinType, $guidingPrice);
            //审核项目指导价
            $guidingPriceData->guidingPriceConfirm($coinType);

            //添加年化收益
            foreach ($inputs['annualRate'] as $annualRate) {
                $year = $annualRate['year'];
                $rate = $annualRate['rate'];
                $isHistory = $annualRate['isHistory'];
                $primary = $annualRate['primary'];
                $projectAnnualRateData->add($projectid, $year, $rate, $isHistory, $primary);
            }

            if ($projectHoldType == 1) {
                //公司
                $company = $projectCompanyData->get($projectHolderid);
                foreach ($holds['details'] as $hold) {
                    $holderid = $hold['id'];
                    $capital = $hold['capital'];
                    $name = $hold['holderTypeName'];
                    $shareBonus = $hold['shareBonus'];
                    $holder = $projectHolderData->get($holderid);
                    $type = 0;
                    if (!empty($holder)) {
                        $type = $holder->holder_type;
                    }
                    $projectShareHolderData->add($projectid, $holderid, $capital, $type, $name, $shareBonus);
                    $projectShareHolderTypeData->add($name, $shareBonus);
                }
                
            }

        }
        DB::commit();
    }

}
