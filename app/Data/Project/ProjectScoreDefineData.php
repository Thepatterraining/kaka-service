<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目分值定义
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectScoreDefineData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectScoreDefine';

    protected $no = 'score_name';

}
