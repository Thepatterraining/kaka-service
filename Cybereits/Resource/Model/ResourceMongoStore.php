<?php
namespace Cybereits\Resource\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ResourceMongoStore extends Eloquent {
  protected $connection = 'mongodb';
  protected $collection = "resource_collection";
}