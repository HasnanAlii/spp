<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model

{
    use HasFactory;

    
    protected $fillable = [
        'nama', 'kelas', 'telp', 'status', 'jenis_kelamin',
        'tanggal_lahir', 'alamat', 'telp_orangtua', 'angkatan'
    ];

    public function spp()
    {
        return $this->hasMany(Spp::class, 'id_siswa');
    }
    
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_siswa');
    }
public function user()
{
    return $this->hasOne(User::class, 'name', 'nama');
}



}