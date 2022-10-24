<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFileRequest;
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

class FileManagerController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    use StorageTrait;
    private $filesystem;
    private $client;
    public function __construct(FileSystem $filesystem, Client $client )
    {
        $this->filesystem = $filesystem;
        $this->client = $client;
    }
    /**
     * upload file.
     * @method post
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     * tags={"Storage"},
     * description="upload File",
     * path="/api/storage/upload",
     * security={{"api_key":{}}},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *          description="file to upload",
     *          property="file",
     *          type="array",
     *      @OA\Items(
     *          type="string",
     *          format="binary",
     *      ),
     *     )
     *    )
     *   )
     * ),
      * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *       example=
     *           {
     *               "message": "res.upload.success",
     *               "file":{
     *                  "id": 1,
     *                  "name":
     *                  "image400x700.png",
     *                  "name":
     *                  "jx3m8NPBgy.png",
     *                  "type": "image",
     *                  "path": "public/image/jx3m8NPBgy.png",
     *                  "status": 0,
     *                  "created_at": "2022-09-29T17:03:15.000000Z",
     *                  "updated_at": "2022-09-29T17:13:16.000000Z",
     *                  "deleted_at": null,
     *                  "url": "http://domain.com/storage/image/jx3m8NPBgy.png",
     *               }

     *           }
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.upload.fail"),
     *    ),
     * ),
     * )
     */
    public function upload(UploadFileRequest $request)
    {
        $user = auth()->user();
        if(!$user){
            $user = $this->client->getClient();
        }

        $file = $request->file('file');
        if (!$file) {
            return response()->json([
                'message' => 'res.invalid.file',
            ], 400);
        }
        try {
            DB::beginTransaction();
            $extension = $file->extension();
            $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
            $videoExtensions = ["webm", "mp4", "ogv"];
            $audioExtensions = ['mp3'];
            $debExtensions = ['deb'];
            if (collect($imageExtensions)->contains($extension)) {
                $folder = "image";
            }
            if (collect($videoExtensions)->contains($extension)) {
                $folder = "video";
            }
            if (collect($audioExtensions)->contains($extension)) {
                $folder = "audio";
            }
            if (collect($debExtensions)->contains($extension)) {
                $folder = "deb";
            }
            $fileInfo = $this->uploadFile($folder, $file);

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
                'message' => 'res.upload.success',
                'content' => $fileuploaded,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.upload.fail',
            ], 500);
        }
    }
    /**
     * update file.
     * @method post
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     * tags={"Storage"},
     * description="update File",
     * path="/api/storage/update/{id}",
     * security={{"api_key":{}}},
     * @OA\Parameter(
     *    required=true,
     *    name="id",
     *    in="path",
     *    description="id file",
     *    example="1"
     * ),
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *          description="file to upload",
     *          property="file",
     *          type="array",
     *      @OA\Items(
     *          type="string",
     *          format="binary",
     *      ),
     *     )
     *    )
     *   )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *       example=
     *           {
     *             "message":"res.update.success",
     *              "file":{
     *                  "id": 1,
     *                  "name":
     *                  "image400x700.png",
     *                  "name":
     *                  "jx3m8NPBgy.png",
     *                  "type": "image",
     *                  "path": "public/image/jx3m8NPBgy.png",
     *                  "status": 0,
     *                  "created_at": "2022-09-29T17:03:15.000000Z",
     *                  "updated_at": "2022-09-29T17:13:16.000000Z",
     *                  "deleted_at": null,
     *                  "url": "http://domain.com/storage/image/jx3m8NPBgy.png",
     *              }
     *           }
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.update.fail"),
     *    ),
     * ),
     * )
     */
    public function update(UploadFileRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if(!$user){
                $user = $this->client->getClient();
            }
            $file = $request->file('file');
            $fileChange = $this->filesystem->find($id);
            if (!$fileChange) {
                return response()->json([
                    'message' => 'res.notfound.file',
                ], 404);
            }
            $folder = $fileChange->folder;
            $fileInfo = $this->uploadFile($folder, $file);
            if($fileInfo){
                Storage::delete($fileChange->path);
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
                'message' => 'res.update.success',
                'content' => $fileChange,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.update.fail',
                'content' => false
            ], 500);
        }
    }
    /**
     * get file.
     * @method post
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\POST(
     * path="/api/storage/getfile",
     * summary="get file",
     * description="use token",
     * operationId="get file",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     *  @OA\Parameter(
     *      description="Parameter with mutliple examples",
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="string"),
     *      @OA\Examples(example="string", value="public/image/xygU1JNO6L.png", summary="string path file"),
     *  ),
     * @OA\RequestBody(
     *    required=true,
     *    description="path file",
     *    @OA\JsonContent(
     *       required={"filepath"},
     *       @OA\Property(property="filepath", type="string", example="public/image/xygU1JNO6L.png"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *       example=
     *           {
     *               "id": 1,
     *               "name":
     *               "image400x700.png",
     *               "name":
     *               "jx3m8NPBgy.png",
     *               "type": "image",
     *               "path": "public/image/jx3m8NPBgy.png",
     *               "status": 0,
     *               "created_at": "2022-09-29T17:03:15.000000Z",
     *               "updated_at": "2022-09-29T17:13:16.000000Z",
     *               "deleted_at": null,
     *               "url": "http://domain.com/storage/image/jx3m8NPBgy.png",
     *               "pivot": {
     *                   "user_id": 1,
     *                   "file_id": 1
     *               }
     *           }
     *    )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.notfound.file")
     *        )
     *     )
     * )
     * ),
     */
    public function getfile(GetFileRequest $request)
    {

        $user = auth()->user();
        if(!$user){
            $user = $this->client->getClient();
        }
        $files = $user->files;
        $trashs = $user->files()->onlyTrashed()->get();
        $hashName = $request->hash;
        try {
            $file = $files->where('hash', '=', $hashName)->first();
            if(!$file){
                $file = $trashs->where('hash', '=', $hashName)->first();
            }
            return response()->json([
                'message' => 'res.getdata.success',
                'content' => $file
            ]);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.notfound.file',
                'content' => false
            ], 404);
        }

    }
    /**
     * all file.
     * @method get
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     *
     * @OA\GET(
     * path="/api/storage/getall",
     * summary="get all file",
     * description="use token",
     * operationId="get all file",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *     example={
     *           {
     *               "id": 1,
     *               "name":
     *               "image400x700.png",
     *               "name":
     *               "jx3m8NPBgy.png",
     *               "type": "image",
     *               "path": "public/image/jx3m8NPBgy.png",
     *               "status": 0,
     *               "created_at": "2022-09-29T17:03:15.000000Z",
     *               "updated_at": "2022-09-29T17:13:16.000000Z",
     *               "deleted_at": null,
     *               "url": "http://domain.com/storage/image/jx3m8NPBgy.png",
     *               "pivot": {
     *                   "user_id": 1,
     *                   "file_id": 1
     *               }
     *           },
     *           {
     *               "id": 2,
     *               "name":
     *               "image2_400x700.png",
     *               "name":
     *               "jx3m8NPBgy.png",
     *               "type": "image",
     *               "path": "public/image/jx3m8NPBgy.png",
     *               "status": 0,
     *               "created_at": "2022-09-29T17:03:15.000000Z",
     *               "updated_at": "2022-09-29T17:13:16.000000Z",
     *               "deleted_at": null,
     *               "url": "http://domain.com/storage/image/jx3m8NPBgy.png",
     *                "pivot": {
     *                   "user_id": 1,
     *                   "file_id": 2
     *               }
     *           }
     *       }
     *   ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.getdata.fail")
     *        )
     *     )
     * )
     */
    public function allfile(Request $request)
    {
        try {
            $user = auth()->user();
            if(!$user){
                $user = $this->client->getClient();
            }
            $files = $user->files;
            return response()->json([
                'message' => 'res.getdata.success',
                'content' => $files
            ]);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.getdata.fail',
                'content' => false
            ], 500);
        }
    }
    /**
     * delete file.
     * @method delete
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     * path="/api/storage/delete/{id}",
     * summary="delete file",
     * description="use token",
     * operationId="delete",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     * @OA\Parameter(
     *    required=true,
     *    name="id",
     *    in="path",
     *    description="id file",
     *    example="1"
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.delete.success"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.delete.fail")
     *        )
     *     )
     * )
     */
    public function delete(Request $request, $id)
    {
        $file = $this->filesystem->find($id);
        if (!$file) {
            return response()->json([
                'message' => 'res.notfound.file',
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
                'message' => 'res.delete.success',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.delete.fail',
            ], 500);
        }
    }
    /**
     * clear file.
     * @method get
     * @param object $request
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/clear",
     * summary="clear file",
     * description="use token",
     * operationId="clear",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.clear.success"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.clear.fail")
     *        )
     *     )
     * )
     */
    public function clear()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if(!$user){
                $user = $this->client->getClient();
            }
            $files = $user->files;

            $ids = [];
            foreach ($files as $file) {
                if (!Storage::get($file->path)) {
                    $file->delete();
                }
            }
            $trashs = $user->files()->onlyTrashed()->get();

            foreach ($trashs as $trash) {
                if (!Storage::get($trash->path) && !Storage::get('trash/' . $trash->hash)) {
                    $ids[] = $trash->id;
                    $trash->forceDelete();
                }
            }
            $idAfter = $files->whereNotIn('id', $ids)->pluck('id');
            $user->files()->sync($idAfter);
            DB::commit();
            return response()->json([
                'message' => 'res.clear.success',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.clear.fail',
            ], 500);
        }
    }
    /**
     * get trash
     * @method get
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/trash",
     * summary="trash file",
     * description="use token",
     * operationId="trash",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *     example={
     *           {
     *               "id": 1,
     *               "name":
     *               "image400x700.png",
     *               "name":
     *               "jx3m8NPBgy.png",
     *               "type": "image",
     *               "path": "public/image/jx3m8NPBgy.png",
     *               "status": 0,
     *               "created_at": "2022-09-29T17:03:15.000000Z",
     *               "updated_at": "2022-09-29T17:13:16.000000Z",
     *               "deleted_at": "2022-09-29T19:56:14.000000Z",
     *               "pivot": {
     *                   "user_id": 1,
     *                   "file_id": 1
     *               }
     *           },
     *           {
     *               "id": 2,
     *               "name":
     *               "image2_400x700.png",
     *               "name":
     *               "jx3m8NPBgy.png",
     *               "type": "image",
     *               "path": "public/image/jx3m8NPBgy.png",
     *               "status": 0,
     *               "created_at": "2022-09-29T17:03:15.000000Z",
     *               "updated_at": "2022-09-29T17:13:16.000000Z",
     *               "deleted_at": "2022-09-29T19:56:14.000000Z",
     *                "pivot": {
     *                   "user_id": 1,
     *                   "file_id": 2
     *               }
     *           }
     *       }
     *   ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.getdata.fail")
     *        )
     *     )
     * )
     */
    public function trash()
    {
        try {
            $user = auth()->user();
            if(!$user){
                $user = $this->client->getClient();
            }
            $trashs = $user->files()->onlyTrashed()->get();
            return response()->json($trashs);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.getdata.sfail',
            ], 500);
        }
    }
    /**
     * restore file.
     * @method get
     * @param object $request
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/restore/{id}",
     * summary="restore file",
     * description="use token",
     * operationId="restore",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     * * @OA\Parameter(
     *    required=true,
     *    name="id",
     *    in="path",
     *    description="id file",
     *    example="1"
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.clear.success"),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.notfound.trash"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.clear.fail")
     *        )
     *     )
     * ),
     */
    public function restore(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if(!$user){
                $user = $this->client->getClient();
            }
            $trashs = $user->files()->onlyTrashed()->get();
            $trash = $trashs->find($id);
            if ($trash) {
                $move = Storage::move('trash/' . $trash->hash, 'public/' . $trash->folder . '/' . $trash->hash);
                $trash->restore();
            } else {
                return response()->json([
                    'message' => 'res.notfound.trash',
                ], 404);
            }
            DB::commit();
            return response()->json([
                'message' => 'res.restore.success',
            ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.restore.fail',
            ], 500);
        }
    }
    /**
     * @method delete
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     * path="/api/storage/forcedelete/{id}",
     * summary="forcedelete file",
     * description="use token",
     * operationId="forcedelete",
     * tags={"Storage"},
     * security={ {"api_key": {} }},
     * @OA\Parameter(
     *    required=true,
     *    name="id",
     *    in="path",
     *    description="id file",
     *    example="1"
     * ),
     *  @OA\Response(
     *    response=200,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.forcedelete.success"),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.notfound.trash"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="res.forcedelete.fail")
     *        )
     *     )
     * )
     */
    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            if(!$user){
                $user = $this->client->getClient();
            }
            $trashs = $user->files()->onlyTrashed()->get();
            $trash = $trashs->find($id);
            if (!$trash) {
                return response()->json([
                    'message' => 'res.notfound.trash',
                ], 404);

            }
            if (Storage::get('trash/' . $trash->hash)) {
                Storage::delete('trash/' . $trash->hash);
            }
            $trash->forceDelete();
            DB::commit();
            return response()->json([
                'message' => 'res.forceDelete.success',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => 'res.delete.fail',
            ], 500);
        }
    }
}
