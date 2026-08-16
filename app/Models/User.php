<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'email_verified_at', 'password', 'phone', 'image', 'status', 'google_id', 'otp', 'otp_expires_at'])]
#[Hidden(['password', 'remember_token', 'otp', 'otp_expires_at'])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasUuids, HasRoles, SoftDeletes, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::squish($value)
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower(trim($value)),
        );
    }
    
    protected function roleNames(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getRoleNames()
                ->map(fn ($role) => Str::title($role))
                ->implode(', ')
        );
    }

    protected function initials(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::of($this->name)
                ->explode(' ')
                ->take(2)
                ->map(fn ($word) => Str::of($word)->substr(0, 1)->upper())
                ->implode('')
        );
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', true);
    }

    public function isActive(): bool
    {
        return $this->status;
    }

    public function sendEmailVerificationNotification(): void
    {
        $otp = random_int(100000, 999999);

        $this->forceFill([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        $this->notify(new CustomVerifyEmail($otp));
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}