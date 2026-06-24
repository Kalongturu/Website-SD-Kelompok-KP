<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'phone',
        'avatar',
        'avatar_mime',
        'is_active',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * URL avatar. Foto yang diunggah disimpan sebagai DATA BINER (bytea) di kolom
     * `avatar_data`; keberadaannya ditandai oleh `avatar_mime` dan disajikan lewat
     * route `admin.profile.avatar`. Kolom `avatar` (varchar) tetap didukung untuk
     * URL eksternal (http/https). Null bila admin belum punya avatar (UI inisial).
     */
    public function avatarUrl(): ?string
    {
        if (Str::startsWith((string) $this->avatar, ['http://', 'https://'])) {
            return $this->avatar;
        }

        if (! empty($this->avatar_mime)) {
            return route('admin.profile.avatar') . '?v=' . optional($this->updated_at)->timestamp;
        }

        return null;
    }

    /**
     * Apakah admin punya avatar yang bisa dihapus (blob unggahan atau URL eksternal).
     */
    public function hasAvatar(): bool
    {
        return ! empty($this->avatar_mime) || ! empty($this->avatar);
    }

    /**
     * Inisial nama untuk avatar default (mis. "Budi Santoso" → "BS").
     */
    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $parts = array_filter($parts);

        if (empty($parts)) {
            return 'A';
        }

        $first = Str::substr($parts[0], 0, 1);
        $last  = count($parts) > 1 ? Str::substr(end($parts), 0, 1) : '';

        return Str::upper($first . $last);
    }
}
