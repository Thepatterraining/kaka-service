<?php
namespace Cybereits\Http;

/**
 * the base adapter class
 * ver 0.1
 * geyunfei@kakamf.com
 * Feb 22nd,2017
 */
abstract class IAdapter
{
    protected $mapArray;
    protected $dicArray;
    protected $fmtArray ; 


    /**
     * id, user_idno 
     * maparray [
     *    "id"=>"user_idno"
     *
     * ],
     * fmtArray [
     *     "id"=>"ltrm($item,3)"
     * ]
     */
    public function getFromModel($model, $boolId = true, $items = null)
    {
        $contract = array();
        if ($boolId==true) {
            $contract['id'] = $model->id;
        }
        foreach ($this->mapArray as $key => $value) {
            $contract[$key] = $model->$value;
        }

        if ($this->dicArray!=null &&is_array($this->dicArray) && count($this->dicArray)>0) {
            $dicfac = new DictionaryLogic();
            foreach ($this->dicArray as $key => $dic) {
                if (array_key_exists($key, $this->mapArray)) {
                    $contract[$key]= $dicfac->getDic($dic, $contract[$key]);
                }
            }
        }

        if($this->fmtArray != null && is_array($this->fmtArray) &&count($this->fmtArray)>0) {

            foreach ($this->fmtArray as $key => $fmt){

                if(array_key_exists($key, $contract)) {
                    $contract [$key]= $this->getFmt($contract[$key], $fmt);
                }


            }
        }

        $result = $this->fromModel($contract, $model, $items);





        if($result != null) {
            return $result;
        } else {
            return $contract;
        }
    }
    protected function fromModel($contract, $model, $items)
    {
    }
    public function getDataContract($model, $properties = null, $getId = false)
    {
        if ($model == null) {
            return null;
        }
        $item = array();
        if ($getId) {
            $item ['id']=$model->id;
        }
        
        if ($properties == null) {
            $item = $this->getFromModel($model, $getId);
        } else {
            foreach ($properties as $key) {
                if (array_key_exists($key, $this->mapArray)) {
                    $col = $this->mapArray[$key];
                    $item[$key] = $model->$col;
                }
            }
        }

          
        if($this->fmtArray != null && is_array($this->fmtArray) &&count($this->fmtArray)>0) {

            foreach ($this->fmtArray as $key => $fmt){

                if(array_key_exists($key, $item)) {
                    $item [$key]= $this->getFmt($item[$key], $fmt);
                }


            }
        }

        
        return $item;
    }
    public function saveToModel($boolId, $contract, $model, $items = null)
    {
        if ($boolId==true) {
            $model->id = $contract->id ;
        }
        foreach ($this->mapArray as $key => $value) {
            if (array_key_exists($key, $contract)) {
                if (is_array($contract[$key])===false) {
                    $model->$value = $contract[$key];
                }
            }
        }
        $this->toModel($contract, $model, $items);
    }
    protected function toModel($contract, $model, $items)
    {
    }
    public function getFilers($option)
    {
        $filter = array();

        if (array_key_exists('filters', $option) && $option['filters']!=null) {
            foreach ($this->mapArray as $key => $value) {
                if (array_key_exists($key, $option['filters'])) {
                    $filter[$value]=$option['filters'][$key];
                }
            }
            return $filter;
        } else {
            return [];
        }
    }

    /**
     * getFilers的改写版本
     *
     * @param   $option
     * @return  array
     * @author  zhoutao
     * @version 0.1
     */
    public function getFilersTo($option)
    {
        $filter = array();
        if ($option['filters']!=null) {
            foreach ($this->mapArray as $key => $value) {
                if (array_key_exists($key, $option['filters'])) {
                    $filter[$key]=$option['filters'][$key];
                }
            }
            return $filter;
        }
    }

    public function getItem($request)
    {
        
     
        return $this->getData($request, "item");
    }

    public function getQueryFilter($request)
    {
        return IAdapter::getContract(QueryOption, $request);
    }
    private static function getContract($contract, $request)
    {

        $classInfo = new ReflectionObject($contract);
        $properties = $classInfo->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $param) {
            $name = $param->getName();
            $contract->$name = $request->input($name);
        }
    }

    public function getData($request, $data = "data")
    {
        
        $item = array();
        foreach ($this->mapArray as $key => $value) {
            if (array_key_exists($key, $request->input($data))) {
                $item[$key] = $request->input($data . '.' . $key);
            }
        }
 
        return $item;
    }


    public function getDics()
    {
        $array = $this->mapArray;
        return array_keys($array);
    }

    private function getFmt($item,$fmt)
    {
        if (empty($item)) {
            return $item;
        }
        $phpstr = "return ".$fmt.";";
         
        $msg = eval($phpstr);
        return $msg;
    }

}
