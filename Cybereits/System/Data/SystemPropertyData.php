<?php
namespace Cybereits\System\Data;

use Cybereits\Common\DAL\SqlModel;
use Cybereits\Common\DAL\IMySqlModelFactory ;

class SystemPropertyData extends IMySqlModelFactory {
  protected $modelclass = \Cybereits\System\Model\SystemProperty::class;
}