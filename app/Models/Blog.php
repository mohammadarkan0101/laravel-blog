<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'content',
        'image',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    protected static function handlePublished(Blog $blog): void
    {
        if ($blog->isPublished()) {
            $blog->published_at ??= now();
        } else {
            $blog->published_at = null;
        }
    }

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            $blog->slug = static::generateUniqueSlug($blog->title);
            static::handlePublished($blog);
        });

        static::updating(function (Blog $blog) {
            if ($blog->isDirty('title')) {
                $blog->slug = static::generateUniqueSlug($blog->title);
            }
            if ($blog->isDirty('status')) {
                static::handlePublished($blog);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}