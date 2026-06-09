<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasUuids, HasRoles, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::lower($value)
        );
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getRoleAttribute(): string
    {
        return $this
            ->getRoleNames()
            ->map(fn($role) => Str::title($role))
            ->implode(', ');
    }

    public function isActive(): bool
    {
        return (bool) $this->status;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
