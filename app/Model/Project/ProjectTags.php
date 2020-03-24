<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTags extends Model
{
    use SoftDeletes;
    protected $table = "project_tags";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
