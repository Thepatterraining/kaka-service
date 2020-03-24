<?php
namespace Cybereits\Common\DAL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * 基本的业务处理类
 */

class SqlModel extends Model {
  use SoftDeletes;
  protected $dates = ["created_at","updated_at","deleted_at"];
}