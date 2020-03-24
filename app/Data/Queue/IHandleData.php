<?php
namespace App\Data\Queue;

interface IHandleData
{
    function HandleData($data,$params);
}