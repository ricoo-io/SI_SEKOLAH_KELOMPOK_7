<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'nip',
        'password',
        'role',
        'wali_kelas',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed', 
        ];
    }

    // Relationship dengan Guru
    public function guru()
    {
        return $this->hasOne(Guru::class, 'id_user');
    }

    // Accessors untuk 'name' (karena banyak code Laravel expect 'name')
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nama'] = $value;
    }

    // Accessor untuk 'username' → gunakan 'nip' sebagai username
    public function getUsernameAttribute(): ?string
    {
        return $this->attributes['nip'] ?? null;
    }

    // Role checks
    public function hasRole(string $name): bool
    {
        return ($this->role ?? null) === $name;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isWaliKelas(): bool
    {
        return $this->wali_kelas === 'True';
    }

    // Helper methods
    public function initials(): string
    {
        return Str::of($this->nama ?? '')
            ->explode(' ')
            ->take(2)
            ->map(fn ($w) => Str::upper(Str::substr($w, 0, 1)))
            ->implode('');
    }
}