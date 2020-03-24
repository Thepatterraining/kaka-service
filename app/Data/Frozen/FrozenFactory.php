<?php
namespace App\Data\Frozen; 
use App\Data\Frozen\DefaultFrozen ;
use App\Data\Coin\FrozenData;

/**
 * 冻结工厂
 *
 * @author zhoutao
 * @date   2017.11.10
 */
class FrozenFactory
{

    private $_frozenFac = [
        FrozenData::LENDING_DOC_TYPE => 'App\Data\Frozen\LendingFrozen',
    ];

    public function CreateFrozen($frozenType)
    {

        if (array_key_exists($frozenType, $this->_frozenFac)) {
            $result = new $this->_frozenFac[$frozenType];
        } else {
            $result = new DefaultFrozen;
        }
        $result->load_data($frozenType);
        return $result ;

    }
}