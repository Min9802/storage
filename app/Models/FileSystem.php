<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 * title="FileSystem",
 * description="FileSystem model",
 *       @OA\Property(
 *           property="id",
 *           type="int"
 *       ),
 *       @OA\Property(
 *           property="name",
 *           type="string"
 *       ),
 *        @OA\Property(
 *           property="file_name",
 *           type="string"
 *       ),
 *       @OA\Property(
 *           property="type",
 *           type="string"
 *       ),
 *        @OA\Property(
 *           property="path",
 *           type="string"
 *       ),
 *        @OA\Property(
 *           property="status",
 *           type="int"
 *       ),
 *        @OA\Property(
 *           property="created_at",
 *           type="string"
 *       ),
 *        @OA\Property(
 *           property="updated_at",
 *           type="string"
 *       ),
 *        @OA\Property(
 *           property="deleted_at",
 *           type="string"
 *       ),
 *         @OA\Property(
 *           property="url",
 *           type="string"
 *       ),
 *          @OA\Property(
 *           property="pivot",
 *           type="object"
 *       ),
 * @OA\Xml( * name="FileSystem" * )
 *  )
 **/
class FileSystem extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
}
