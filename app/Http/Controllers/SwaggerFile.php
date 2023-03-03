<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwaggerFile extends Controller
{
    /**
     * all file.
     * @method get
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\GET(
     *  tags={"Storage Api file"},
     * path="/api/storage/client/file/list",
     * summary="get all file",
     * description="use token",
     * operationId="get all file",
     * security={ {"passport": {} }},
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
     *       @OA\Property(property="message", type="string", example="getdata fail")
     *        )
     *     )
     * )
     */
    function list() {
        # code...
    }
    /**
     * get file.
     * @method post
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\POST(
     *  tags={"Storage Api file"},
     * path="/api/storage/client/file/get",
     * summary="get file",
     * description="use token",
     * operationId="get file",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="file path to save",
     *              property="path",
     *              type="string",
     *              example="Admin/image/redis.png"
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
     *       @OA\Property(property="message", type="string", example="notfound")
     *        )
     *     )
     * )
     * ),
     */
    public function getfile()
    {
        # code...
    }
    /**
     * upload file.
     * @method post
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     * tags={"Storage Api file"},
     * description="upload File",
     * path="/api/storage/client/file/upload",
     * security={{"passport": {}}},
     * @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="file to upload",
     *              property="file",
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  format="binary",
     *              ),
     *          ),
     *          @OA\Property(
     *              description="file path to save",
     *              property="path",
     *              type="string",
     *          )
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
     *       example=
     *           {
     *               "message": "upload success",
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
     *       @OA\Property(property="message", type="string", example="upload fail"),
     *    ),
     * ),
     * )
     */
    public function upload()
    {
        # code...
    }
    /**
     * update file.
     * @method post
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *  tags={"Storage Api file"},
     * description="update File",
     * path="/api/storage/client/file/update/{id}",
     * security={{"passport": {}}},
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
     *             "message":"update success",
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
     *       @OA\Property(property="message", type="string", example="update fail"),
     *    ),
     * ),
     * )
     */
    public function update()
    {
        # code...
    }
    /**
     * delete file.
     * @method delete
     * @param object $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     * path="/api/storage/client/file/delete/{id}",
     * summary="delete file",
     * description="use token",
     * operationId="delete",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
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
     *       @OA\Property(property="message", type="string", example="delete success"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="delete fail")
     *        )
     *     )
     * )
     */
    public function delete()
    {
        # code...
    }
    /**
     * get trash
     * @method get
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/client/trash",
     * summary="trash file",
     * description="use token",
     * operationId="trash",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
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
     *       @OA\Property(property="message", type="string", example="getdata fail")
     *        )
     *     )
     * )
     */
    public function gettrash()
    {
        # code...
    }
    /**
     * clear file.
     * @method get
     * @param object $request
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/client/trash/clean",
     * summary="clean file",
     * description="use token",
     * operationId="clean",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="clean success"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="clean fail")
     *        )
     *     )
     * )
     */
    public function cleantrash()
    {
        # code...
    }

    /**
     * restore file.
     * @method get
     * @param object $request
     * @return \Illuminate\Http\Response
     * @OA\Get(
     * path="/api/storage/client/trash/restore/{id}",
     * summary="restore file",
     * description="use token",
     * operationId="restore",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
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
     *       @OA\Property(property="message", type="string", example="restore success"),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="notfound"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="restore fail")
     *        )
     *     )
     * ),
     */
    public function restore()
    {
        # code...
    }
    /**
     * @method delete
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     * path="/api/storage/client/file/forcedelete/{id}",
     * summary="forcedelete file",
     * description="use token",
     * operationId="forcedelete",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
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
     *       @OA\Property(property="message", type="string", example="forcedelete success"),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="notfound"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="forcedelete fail")
     *        )
     *     )
     * )
     */
    public function forcedelete()
    {
        # code...
    }
    /**
     * @method delete
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     * path="/api/storage/client/trash/delete/{id}",
     * summary="deletetrash file",
     * description="use token",
     * operationId="deletetrash",
     *  tags={"Storage Api file"},
     * security={ {"passport": {} }},
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
     *       @OA\Property(property="message", type="string", example="delete trash success"),
     *    ),
     * ),
     *  @OA\Response(
     *    response=404,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="trash not found"),
     *    ),
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Wrong",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="delete trash fail")
     *        )
     *     )
     * )
     */
    public function deleleTrash()
    {
        # code...
    }
}
