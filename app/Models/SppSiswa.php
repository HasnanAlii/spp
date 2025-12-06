<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppSiswa extends Model
{
    protected $table = 'spp_siswas';

    protected $fillable = [
        'siswa_id',
        'spp_master_id',
        'nama_spp',
        'tipe',
        'total_tagihan',
        'sisa_tagihan',
        'status',
        'tahun_ajaran',
    ];

    /**
     * Relasi ke tabel siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke table spp_master (template jenis SPP)
     */
    public function master()
    {
        return $this->belongsTo(Spp::class, 'spps_id');
    }

    /**
     * Relasi ke pembayaran SPP siswa
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'spp_siswa_id');
    }
}
