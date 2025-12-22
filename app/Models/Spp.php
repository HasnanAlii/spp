<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = 'spps';

    protected $fillable = [
        'nama_spp',
        'tipe',
        'nominal',
        'tahun_ajaran',
        'kelas',
        'gelombang'
    ];

    public function sppSiswa()
    {
        return $this->hasMany(SppSiswa::class, 'spps_id');
    }
}
