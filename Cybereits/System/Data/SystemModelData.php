<?php
namespace Cybereits\System\Data;

use Cybereits\Common\DAL\SqlModel;
use Cybereits\Common\DAL\IMySqlModelFactory ;

class SystemModelData extends IMySqlModelFactory {
  protected $modelclass = \Cybereits\System\Model\SystemModel::class;
}