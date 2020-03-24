<?php
namespace Cybereits\Resource;


/**
 * 存储文件的接口
 * @author 老拐 <geyunfei@kakamf.com>
 * @version 0.1
 * @date Feb 27th,2018
 */
interface IStoreData {
  /**
   * 保存文件
   */
  public function StoreFile($filename);
  /**
   * 保存文件内容
   */
  public function StoreFileContent($filetype,$filecontent);

  /**
   * 得到文件
   */
  public function GetFile($fileid);
}