<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwaggerFolder extends Controller
{
    /**
     * @method get
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/client/folder/list",
     * summary="get folder list",
     * description="use token",
     * operationId="folderlist",
     * tags={"Storage Api folder"},
     * security={ {"passport": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *     example={
     *          "message": "Get data success",
     *          "folders": {
     *              "image",
     *              "audio"
     *          }
     *       }
     *   ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="getdata fail")
     *        )
     *     )
     * )
     */
    public function folderlist()
    {
        # code...
    }
    /**
     * @method post
     * @return \Illuminate\Http\Response
     * @OA\POST(
     * path="/api/storage/client/folder/exist",
     * summary="Check folder exist",
     * description="use token",
     * operationId="folderexists",
     * tags={"Storage Api folder"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="name folder",
     *              property="name",
     *              type="string",
     *              example="image"
     *          ),
     *     )
     *   )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *     oneOf={
     *         @OA\Schema(ref="#/components/schemas/FileSystem"),
     *     },
     *     example={
     *          "message": "Folder Exists",
     *       }
     *   ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="not found")
     *        )
     *     )
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="getdata fail")
     *        )
     *     )
     * )
     */
    public function folderExist()
    {
        # code...
    }
    /**
     * @method post
     * @return \Illuminate\Http\Response
     * @OA\POST(
     * path="/api/storage/client/folder/create",
     * summary="Add new folder",
     * description="use token",
     * operationId="createfolder",
     * tags={"Storage Api folder"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="name folder",
     *              property="name",
     *              type="string",
     *              example="image"
     *          ),
     *     )
     *   )
     * ),
     *  @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="object",
     *          example={
     *              "message": "Add success",
     *              "folder": "image"
     *          }
     *      ),
     *    ),
     * ),
     *  @OA\Response(
     *    response=409,
     *    description="Conflict",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="string",
     *          example={
     *              "message": "Folder exists",
     *          }
     *      ),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Add folder fail")
     *        )
     *     )
     * )
     */
    public function folderCteate()
    {
        # code...
    }
    /**
     * @method post
     * @return \Illuminate\Http\Response
     * @OA\POST(
     * path="/api/storage/client/folder/rename",
     * summary="Rename a folder",
     * description="use token",
     * operationId="renamefolder",
     * tags={"Storage Api folder"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="name folder",
     *              property="name",
     *              type="string",
     *              example="image"
     *          ),
     *          @OA\Property(
     *              description="name folder",
     *              property="newname",
     *              type="string",
     *              example="images"
     *          ),
     *     )
     *   )
     * ),
     *  @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="object",
     *          example={
     *              "message": "Rename success",
     *              "folder": "image"
     *          }
     *      ),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Conflict",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="string",
     *          example={
     *              "message": "Folder not found",
     *          }
     *      ),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Rename folder fail")
     *        )
     *     )
     * )
     */
    public function folderRename()
    {
        # code...
    }
    /**
     * @method post
     * @return \Illuminate\Http\Response
     * @OA\POST(
     * path="/api/storage/client/folder/getfile",
     * summary="Get file in folder",
     * description="use token",
     * operationId="getfilefolder",
     * tags={"Storage Api folder"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="name folder",
     *              property="name",
     *              type="string",
     *              example="image"
     *          ),
     *     )
     *   )
     * ),
     *  @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="object",
     *          example={
     *              "message": "get data success",
     *              "files": {
     *                       {
     *                          "id": 3,
     *                          "name": "redis.png",
     *                          "folder": "image",
     *                          "type": "image/png",
     *                          "hash": "redis.png",
     *                          "path": "Admin/image/redis.png",
     *                          "url": "http://127.0.0.1:8001/storage/Admin/image/redis.png",
     *                          "status": 0,
     *                          "created_at": "2023-03-02T17:30:13.000000Z",
     *                          "updated_at": "2023-03-02T17:30:13.000000Z",
     *                          "deleted_at": null,
     *                          "pivot": {
     *                          "user_id": "1",
     *                          "file_id": 3
     *                       }
     *                   }
     *              }
     *          }
     *      ),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Conflict",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="string",
     *          example={
     *              "message": "Folder not found",
     *          }
     *      ),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="get data fail")
     *        )
     *     )
     * )
     */
    public function getfileFolder()
    {
        # code...
    }
    /**
     * @method delete
     * @return \Illuminate\Http\Response
     * @OA\DELETE(
     * path="/api/storage/client/folder/delete",
     * summary="Delete folder",
     * description="use token",
     * operationId="deleteFolder",
     * tags={"Storage Api folder"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="name folder",
     *              property="name",
     *              type="string",
     *              example="image"
     *          ),
     *     )
     *   )
     * ),
     *  @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="object",
     *          example={
     *              "message": "delete success",
     *          }
     *      ),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Conflict",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="string",
     *          example={
     *              "message": "Folder not found",
     *          }
     *      ),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Delete folder fail")
     *        )
     *     )
     * )
     */
    public function deleteFolder()
    {
        # code...
    }
}
