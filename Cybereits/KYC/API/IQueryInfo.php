<?php
namespace Cybereits\Modules\KYC\API;
interface IQueryInfo {
  public  function QueryMobileInfo($mobile);
  public  function QueryIpInfo($ip);
  public function QueryIDInfo($idno);
}