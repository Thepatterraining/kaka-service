<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectInfoItemDefine extends Model
{
    use SoftDeletes;
    protected $table = "project_infoitemdefine";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
