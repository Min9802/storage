<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFileRequest;
use App\Http\Requests\MoveFileRequest;
use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\Client;
use App\Models\FileSystem;
use App\Traits\StorageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    use StorageTrait;
    private $filesystem;
    private $client;
    public function __construct(FileSystem $filesystem, Client $client)
    {
        $this->filesystem = $filesystem;
        $this->client = $client;
    }
     /**
     * get list files
     * @method GET
     * @param Request $request
     * @return Response
     */
    function list(Request $request) {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $files = $user->files;
            return response()->json([
                'message' => trans('res.getdata.success'),
                'content' => $files,
            ]);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.getdata.fail'),
                'content' => false,
            ], 500);
        }
    }
    /**
     * get file
     * @method POST
     * @param Request $request
     * @param string $path
     * @return Response
     */
    public function get(GetFileRequest $request)
    {

        $user = auth()->user();
        if (!$user) {
            $user = $this->client->getClient();
        }
        $files = $user->files;
        $trashs = $user->files()->onlyTrashed()->get();
        $path = $request->path;

        try {
            $file = $files->where('path', '=', $path)->first();
            if (!$file) {
                $file = $trashs->where('path', '=', $path)->first();
            }
            return response()->json([
                'message' => trans('res.getdata.success'),
                'content' => $file,
            ]);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.getdata.fail'),
                'content' => false,
            ], 404);
        }

    }

    /**
     * upload file
     * @method POST
     * @param Request $request
     * @param file $file
     * @param string $path
     * @return Response
     */
    public function upload(UploadFileRequest $request)
    {
        $user = auth()->user();
        if (!$user) {
            $user = $this->client->getClient();
        }
        $path = $request->path;
        $file = $request->file('file');
        if (!$file) {
            return response()->json([
                'message' => trans('res.invalidfile'),
            ], 400);
        }
        try {
            DB::beginTransaction();
            if (!$path) {
                $extension = $file->extension();
                $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
                $videoExtensions = ["webm", "mp4", "ogv"];
                $audioExtensions = ['mp3'];
                $debExtensions = ['deb'];
                if (collect($imageExtensions)->contains($extension)) {
                    $path = "image";
                }
                if (collect($videoExtensions)->contains($extension)) {
                    $path = "video";
                }
                if (collect($audioExtensions)->contains($extension)) {
                    $path = "audio";
                }
                if (collect($debExtensions)->contains($extension)) {
                    $path = "deb";
                }
            }
            $fileInfo = $this->uploadFile($path, $file);
            $fileupload = [
                'folder' => $fileInfo['folder'],
                'type' => $fileInfo['type'],
                'path' => $fileInfo['path'],
                'name' => $fileInfo['name'],
                'hash' => $fileInfo['hash'],
                'url' => url(Storage::url($fileInfo['path'])),
            ];
            $fileuploaded = $this->filesystem->create([
                'folder' => $fileInfo['folder'],
                'type' => $fileupload['type'],
                'name' => $fileupload['name'],
                'hash' => $fileupload['hash'],
                'path' => $fileupload['path'],
                'url' => $fileupload['url'],
            ]);
            $user->files()->attach($fileuploaded->id);
            DB::commit();
            return response()->json([
                'message' => trans('res.upload.success'),
                'content' => $fileuploaded,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.upload.fail'),
            ], 500);
        }
    }
    /**
     * update file
     * @method POST
     * @param Request $request
     * @param integer $id
     * @param file $file
     * @return Response
     */
    public function update(UploadFileRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $file = $request->file('file');
            $path = $request->path;
            $fileChange = $this->filesystem->find($id);
            if (!$fileChange) {
                return response()->json([
                    'message' => trans('res.notfound'),
                ], 404);
            }
            $folder = $fileChange->folder;
            $fileInfo = $this->uploadFile($folder, $file);
            if ($fileInfo) {
                Storage::disk('public')->delete($fileChange->path);
            }
            $fileupload = [
                'type' => $fileInfo['type'],
                'folder' => $fileInfo['folder'],
                'path' => $fileInfo['path'],
                'name' => $fileInfo['name'],
                'hash' => $fileInfo['hash'],
                'url' => url(Storage::url($fileInfo['path'])),
            ];
            $fileChange->update([
                'type' => $fileupload['type'],
                'folder' => $fileInfo['folder'],
                'name' => $fileupload['name'],
                'hash' => $fileupload['hash'],
                'path' => $fileupload['path'],
                'url' => $fileupload['url'],
            ]);
            DB::commit();
            return response()->json([
                'message' => trans('res.update.success'),
                'content' => $fileChange,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.update.fail'),
                'content' => false,
            ], 500);
        }
    }
    public function rename(RenameFileRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
                $username  = $user->name;
            }else{
                $username = $user->username;
            }
            $path = $request->path;
            $newname = $request->newname;
            $file = $user->files()->where('path', $path)->first();
            if(!$file){
                return response()->json([
                    'message' => trans('res.notfound'),
                ],404);
            }else{
                $folder = $file->folder;
                $newpath = $username . '/' . $folder . '/' . $newname;
                $renamed = Storage::disk('public')->copy($path, $newpath );
                if($renamed){
                    Storage::disk('public')->delete($path);
                }else{
                    return response()->json([
                        'message' => trans('res.rename.fail'),
                    ], 500);
                }
                $urlnew = Storage::disk('public')->url($newpath);
                $file->path  = $newpath;
                $file->url  = $urlnew;
                $file->name = $newname;
                $file->hash = $newname;
                $file->save();
            }
            DB::commit();
            return response()->json([
                'message' => trans('res.rename.success'),
                'content' => $file
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.rename.fail'),
            ], 500);
        }
    }
    public function move(MoveFileRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
                $username  = $user->name;
            }else{
                $username = $user->username;
            }
            $path = $request->path;
            $newpath = $request->newpath;
            $file = $user->files()->where('path', $path)->first();
            if(!$file){
                return response()->json([
                    'message' => trans('res.notfound'),
                ],404);
            }else{
                $folder = $file->folder;
                $filename = $file->name;
                $newpath = $username . '/' . $newpath . '/' . $filename;
                $moved = Storage::disk('public')->copy($path, $newpath );
                if($moved){
                    Storage::disk('public')->delete($path);
                }else{
                    return response()->json([
                        'message' => trans('res.move.fail'),
                    ], 500);
                }
                $urlnew = Storage::disk('public')->url($newpath);
                $file->path  = $newpath;
                $file->url  = $urlnew;
                $file->save();
            }
            DB::commit();
            return response()->json([
                'message' => trans('res.move.success'),
                'content' => $file
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.move.fail'),
            ], 500);
        }
    }
    /**
     * clean trash
     * @method GET
     * @param Request $request
     * @return Response
     */
    public function clean()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            // $files = $user->files;

            // $ids = [];
            // foreach ($files as $file) {
            //     if (!Storage::get($file->path)) {
            //         $file->delete();
            //     }
            // }
            $trashs = $user->files()->onlyTrashed()->get();

            foreach ($trashs as $trash) {
                if (!Storage::get($trash->path) && !Storage::get('trash/' . $trash->hash)) {
                    $ids[] = $trash->id;
                    $trash->forceDelete();
                }
            }
            // $idAfter = $files->whereNotIn('id', $ids)->pluck('id');
            // $user->files()->sync($idAfter);
            DB::commit();
            return response()->json([
                'message' => trans('res.clean.success'),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.clean.fail'),
            ], 500);
        }
    }
    /**
     * get trash
     * @method GET
     * @param Request $request
     * @return Response
     */
    public function listtrash()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $trashs = $user->files()->onlyTrashed()->get();
            return response()->json($trashs);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.getdata.fail'),
            ], 500);
        }
    }
    /**
     * restore file
     * @method GET
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function restore(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $trashs = $user->files()->onlyTrashed()->get();
            $trash = $trashs->find($id);
            if ($trash) {
                $move = Storage::move('trash/' . $trash->hash, 'public/' . $trash->folder . '/' . $trash->hash);
                $trash->restore();
            } else {
                return response()->json([
                    'message' => trans('res.notfound'),
                ], 404);
            }
            DB::commit();
            return response()->json([
                'message' => trans('res.restore.success'),
            ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.restore.fail'),
            ], 500);
        }
    }
    /**
     * delete a file
     * @method DELETE
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $file = $this->filesystem->find($id);
        if (!$file) {
            return response()->json([
                'message' => trans('res.notfound'),
            ], 404);
        }
        try {
            DB::beginTransaction();
            $getFile = Storage::get($file->path);
            if ($getFile) {
                Storage::move($file->path, 'trash/' . $file->hash);
            }
            $file->delete();
            DB::commit();
            return response()->json([
                'message' => trans('res.delete.success'),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.delete.fail'),
            ], 500);
        }
    }
    /**
     * force delete file
     * @method DELETE
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function forcedelete($id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $files = $user->files()->get();
            $file = $files->find($id);
            if (!$file) {
                return response()->json([
                    'message' => trans('res.notfound'),
                ], 404);

            }
            if (Storage::get('trash/' . $file->hash)) {
                Storage::delete('trash/' . $file->hash);
            }
            $file->forceDelete();
            DB::commit();
            return response()->json([
                'message' => trans('res.forceDelete.success'),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.forceDelete.fail'),
            ], 500);
        }
    }
    /**
     * delete trash
     * @method DELETE
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function deletetrash($id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $trashs = $user->files()->onlyTrashed()->get();
            $trash = $trashs->find($id);
            if (!$trash) {
                return response()->json([
                    'message' => trans('res.notfound'),
                ], 404);

            }
            if (Storage::get('trash/' . $trash->hash)) {
                Storage::delete('trash/' . $trash->hash);
            }
            $trash->forceDelete();
            DB::commit();
            return response()->json([
                'message' => trans('res.delete.success'),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.delete.fail'),
            ], 500);
        }
    }

}
