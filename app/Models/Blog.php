<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable(['title', 'user_id', 'content', 'image', 'status', 'slug', 'published_at'])]

class Blog extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    protected function handlePublished(): void
    {
        if ($this->isPublished()) {
            $this->published_at ??= now();
        } else {
            $this->published_at = null;
        }
    }

    protected static function booted(): void
    {
        static::saving(function (Blog $blog) {
            if ($blog->isDirty('title') || !$blog->exists) {
                $blog->slug = static::generateUniqueSlug(
                    $blog->title, 
                    $blog->id
                );
            }

            $blog->handlePublished();
        });
    }

    protected static function generateUniqueSlug(string $title, ?string $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}