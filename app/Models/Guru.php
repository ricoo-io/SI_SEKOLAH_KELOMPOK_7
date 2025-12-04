<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'id_user',
        'nip',
        'nama',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function isWaliKelas(): bool
    {
        return in_array($this->status, ['wali_kelas', 'keduanya']);
    }

    public function isGuruMapel(): bool
    {
        return in_array($this->status, ['guru_mapel', 'keduanya']);
    }
}