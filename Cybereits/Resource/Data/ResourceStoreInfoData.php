<?php
namespace Cybereits\Resource\Data;

use Cybereits\Common\DAL\IMySqlModelFactory;

class ResourceStoreInfoData extends IMySqlModelFactory {

  /**
   * 保存资源
   *
   * @author 老拐 <geyunfei@kakamf.com>
   * @date   Feb 26th,2018
   * @param  byte bytes 要存储的二进制数据
   * @param  type object 资源的类型
   * @param  modelid bigint 数据的id 
   * @param  attachdata array 附加的数据    
   */
  public function StoreResource($bytes,$type,$modelid,$attachdata){

  }

  public function GetResourceList($modelclass ,$modeid){

  }

  public function GetResourceListDefine($modelclass,$modelid){
    
  }
}