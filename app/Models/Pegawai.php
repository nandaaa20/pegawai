<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'departemen',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_telepon',
        'alamat',
        'tanggal_masuk',
        'status_kepegawaian',
    ];

    public function cuti()
    {
        return $this->hasMany(\App\Models\Cuti::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(\App\Models\Kehadiran::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
