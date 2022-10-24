<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
trait StorageTrait
{
    public function uploadFile($folder, $file)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('/public/'.$folder, $fileNameHash);
        $file_type = $file->getClientOriginalExtension();
        $dataUploadTrait = [
            'folder' => $folder,
            'type' => $folder .'/'.$file_type,
            'name' => $fileNameOrigin,
            'hash' => $fileNameHash,
            'path' => $filePath,
        ];
        return $dataUploadTrait;
    }
}
