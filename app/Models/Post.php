<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Post",
 *     description="A blog post model",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Unique identifier"),
 *     @OA\Property(property="title", type="string", description="Title of the post"),
 *     @OA\Property(property="content", type="string", description="Content of the post"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
 * )
 */
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content'];
}
