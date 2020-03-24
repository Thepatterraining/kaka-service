<?php
namespace App\Http\Validation;

class Test
{
    public function validate($attribute, $value, $parameters, $validator)
    {

           
        var_dump($parameters[0]);
        var_dump($attribute);
 
        return $value == 'foo';
    }

    public function replace($message, $attribute, $rule, $parameters)
    {
        return "wrong!!!";
    }
}
