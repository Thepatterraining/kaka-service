<?php
namespace Cybereits\Resource\Data;

use Cybereits\Resource\IStoreData;

class ResourceMongoStoreData implements IStoreData
{
    protected $model_class = \Cybereits\Resource\Model\ResourceMongoStore::class;

    public function NewItem()
    {
        $class = $this->model_class;
        $item = new $class;
        return $item;
    }
    public function Create($item)
    {
        $item->save();
    }

    public function Get($id)
    {
        $class = $this->model_class;
        return $class::where(["_id"=>$id])->first();
    }
    public function StoreFile($file_path)
    {
        $bucket = \DB::connection('mongodb')->getMongoDB()->selectGridFSBucket();
        $resource = fopen($file_path, "a+");
        $file_id = $bucket->uploadFromStream($file_path, $resource,["metadata"=>["content_type"=>mime_content_type($file_path)]]);
        return $file_id;
    }
    public function StoreFileContent($filetype, $resource)
    {
        $bucket = \DB::connection('mongodb')->getMongoDB()->selectGridFSBucket();
        $file_id = $bucket->uploadFromStream($filetype, $resource);
        return $file_id;
        }
    public function GetFile($file_id)
    {
        $bucket = \DB::connection('mongodb')->getMongoDB()->selectGridFSBucket();
        $file_id = new \MongoDB\BSON\ObjectID($file_id);
        $file_metadata = $bucket->findOne(["_id" => $file_id]);
        $path = $file_metadata->filename;
        $downloadStream = $bucket->openDownloadStream($file_id);
        $stream = stream_get_contents($downloadStream, -1);
        $content_type =$file_metadata["metadata"]["content_type"];
        return (Object)[
            "content_type"=>$content_type,
            "stream"=>$stream,
        ];
    }
}
