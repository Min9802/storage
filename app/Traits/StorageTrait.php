<?php
namespace App\Traits;

use App\Models\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
trait StorageTrait
{
    public function uploadFile($path = null, $file)
    {
        $user = auth()->user();
        if(!$user){
            $user = Client::getClient();
            $username = $user->name;
        }else{
            $username = $user->username;
        }
        $name = $file->getClientOriginalName();
        $nameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $pathFile =  Storage::disk('public')->putFileAs($username.'/'.$path, $file, $nameHash);
        $type = $file->getMimeType();
        // $filePath = $file->storeAs('/public/'.$folder, $fileNameHash);
        // $type = $file->getMimeType();
        $dataUploadTrait = [
            'folder' => $path,
            'type' => $type,
            'name' => $name,
            'hash' => $name ?? $nameHash,
            'path' => $pathFile,
        ];
        return $dataUploadTrait;
    }
}
