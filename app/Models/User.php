<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignable sesuai migration
    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',   // 'admin' | 'guru'
        'status', // 'active' | 'inactive'
    ];

    // Sembunyikan password saat serialisasi
    protected $hidden = [
        'password',
    ];

    // Casts
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // tetap hash password
        ];
    }

    // Accessor/Mutator agar kompatibel dengan kode lama yang pakai "name" dan "email"
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nama'] = $value;
    }

    // Catatan: di schema tidak ada email, jadi map "email" ke "username" untuk kompatibilitas tampilan
    public function getEmailAttribute(): ?string
    {
        return $this->attributes['username'] ?? null;
    }

    public function setEmailAttribute($value): void
    {
        $this->attributes['username'] = $value;
    }

    // Helper role sederhana sesuai kolom enum 'role'
    public function hasRole(string $name): bool
    {
        return ($this->role ?? null) === $name;
    }

    
    // Initials untuk UI (pakai 'nama')
    public function initials(): string
    {
        return Str::of($this->name ?? '')
            ->explode(' ')
            ->take(2)
            ->map(fn ($w) => Str::substr($w, 0, 1))
            ->implode('');
    }
}