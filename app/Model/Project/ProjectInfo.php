<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectInfo extends Model
{
    use SoftDeletes;
    protected $table = "project_info";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
