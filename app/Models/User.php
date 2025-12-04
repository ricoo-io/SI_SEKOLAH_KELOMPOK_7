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
        'username',
        'password',
        'role',
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

    // Accessors
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nama'] = $value;
    }

    public function getUsernameAttribute(): ?string
    {
        return $this->attributes['username'] ?? null;
    }

    public function setUsernameAttribute($value): void
    {
        $this->attributes['username'] = $value;
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

    // Helper methods menggunakan relasi guru
    public function isWaliKelas(): bool
    {
        if (!$this->isGuru() || !$this->guru) {
            return false;
        }
        return in_array($this->guru->status, ['wali_kelas', 'keduanya']);
    }

    public function isGuruMapel(): bool
    {
        if (!$this->isGuru() || !$this->guru) {
            return false;
        }
        return in_array($this->guru->status, ['guru_mapel', 'keduanya']);
    }

    public function getGuruType(): ?string
    {
        if (!$this->isGuru() || !$this->guru) {
            return null;
        }
        return $this->guru->status;
    }

    public function initials(): string
    {
        return Str::of($this->nama ?? '')
            ->explode(' ')
            ->take(2)
            ->map(fn ($w) => Str::upper(Str::substr($w, 0, 1)))
            ->implode('');
    }
}