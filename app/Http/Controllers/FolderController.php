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

class FolderController extends Controller
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
     * get list folder
     * @method GET
     * @param Request $request
     * @return Response
     */
    public function list()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $files = $user->files;
            $folders = [];
            if ($files) {
                foreach ($files as $file) {
                    $folders[] = $file->folder;
                }
            }
            return response()->json([
                "message" => trans('res.getdata.success'),
                "content" => $folders,
            ]);
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.getdata.fail'),
            ], 500);
        }
    }
    /**
     * check folder exists
     * @method POST
     * @param Request $request
     * @param string $name
     * @return Response
     */
    public function exists(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
            }
            $folderName = $request->name;
            $folderExist = $user->files()->where('folder', $folderName)->get();
            if (count($folderExist) > 0) {
                return response()->json([
                    "message" => trans('res.folderExists'),
                ], 200);
            } else {
                return response()->json([
                    "message" => trans('res.notfound'),
                ], 404);
            }
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.getdata.fail'),
            ], 500);
        }
    }
    /**
     * create new folder
     * @method POST
     * @param Request $request
     * @param string $name
     * @return Response
     */
    public function create(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
                $username = $user->name;
            } else {
                $username = $user->username;
            }
            $folderName = $request->name;
            $folderExist = $user->files()->where('folder', $folderName)->get();
            if (count($folderExist) > 0) {
                return response()->json([
                    "message" => trans('res.folderExists'),
                ], 409);
            } else {
                $folder = Storage::disk('public')->createDirectory($username . "/" . $folderName);
                return response()->json([
                    'message' => trans('res.add.success'),
                    'content' => $folderName,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.add.fail'),
            ], 500);
        }

    }
    /**
     * rename a folder
     * @method POST
     * @param Request $request
     * @param string $name
     * @param string $newname
     * @return Response
     */
    public function rename(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
                $username = $user->name;
            } else {
                $username = $user->username;
            }
            $folderName = $request->name;
            $newFoldername = $request->newname;
            $folderExist = $user->files()->where('folder', $folderName)->get();
            if (!count($folderExist) > 0) {
                return response()->json([
                    "message" => trans('res.notfound'),
                ], 409);
            } else {
                foreach ($folderExist as $file) {
                    $newpath = $username . "/" . $newFoldername . "/" . $file->name;
                    Storage::disk('public')->move($file->path, $newpath);
                    $newurl = Storage::disk('public')->url($newpath);
                    $file->url = $newurl;
                    $file->folder = $newFoldername;
                    $file->path = $newpath;
                    $file->save();
                }
                Storage::disk('public')->deleteDirectory($username . "/" . $folderName);
                $files = $user->files()->where('folder', $folderName)->get();
                return response()->json([
                    'message' => trans('res.rename.success'),
                    'content' => $files
                ]);
            }
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.add.fail'),
            ], 500);
        }

    }
    /**
     * get file of folder
     * @method POST
     * @param Request $request
     * @param string $name
     * @return Response
     */
    public function getfile(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
                $username = $user->name;
            } else {
                $username = $user->username;
            }
            $folderName = $request->name;
            $folderExist = $user->files()->where('folder', $folderName)->get();
            if (!count($folderExist) > 0) {
                return response()->json([
                    "message" => trans('res.notfound'),
                ], 404);
            } else {
                return response()->json([
                    'message' => trans('res.getdata.success'),
                    'content' => $folderExist,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.getdata.fail'),
            ], 500);
        }
    }
    /**
     * delte a folder
     * @method DELETE
     * @param Request $request
     * @param string $name
     * @return Response
     */
    public function delete(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                $user = $this->client->getClient();
                $username = $user->name;
            } else {
                $username = $user->username;
            }
            $folderName = $request->name;
            $folderExist = $user->files()->where('folder', $folderName)->get();
            if (count($folderExist) > 0) {
                return response()->json([
                    "message" => trans('res.notfound'),
                ], 404);
            } else {
                foreach ($folderExist as $file) {
                    Storage::disk('public')->delete($file->path);
                    $file->forceDelete();
                }
                Storage::disk('public')->deleteDirectory($username . "/" . $folderName);
                return response()->json([
                    'message' => trans('res.delete.success'),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Message :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'message' => trans('res.delete.fail'),
            ], 500);
        }
    }
}
