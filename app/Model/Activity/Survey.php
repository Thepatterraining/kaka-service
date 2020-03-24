<?php
namespace App\Model\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey  extends Model
{
    use SoftDeletes;
    protected $table = "activity_survey_info";
    protected $dates = ["created_at","updated_at","deleted_at"];
}