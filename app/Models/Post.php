<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $title
 * @property string $content
 * @property bool $published
 * @property int $image_id
 */
class Post extends Model
{
    use HasFactory;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
    protected $fillable = [
        'title',
        'content',
        'published'
    ];

    protected $casts = [
        'image_id' => 'integer',
        'published' => 'boolean'
    ];

    public function image() : BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
