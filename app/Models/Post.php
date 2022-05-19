<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $title
 * @property string $content
 * @property bool $published
 * @property int $image_id
 * @property-read User $author
 * @property-read Collection $comments
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
        'published',
        'user_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'image_id' => 'integer',
        'published' => 'boolean'
    ];

    public function image() : BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
