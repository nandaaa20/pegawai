<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
