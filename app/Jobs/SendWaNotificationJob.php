<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Siswa;

class SendWaNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $backoff = 60;

    public $siswa;
    public $pesan;

    public function __construct(Siswa $siswa, string $pesan)
    {
        $this->siswa = $siswa;
        $this->pesan = $pesan;
    }

    public function handle()
    {
        $raw = $this->siswa->telp ?? '';

        // Normalisasi nomor sederhana
        $telp = preg_replace('/\D+/', '', $raw);
        if (strpos($raw, '+62') === 0) {
            $telp = preg_replace('/^\+/', '', $raw);
            $telp = preg_replace('/\D+/', '', $telp);
        }
        if (preg_match('/^0+/', $telp)) {
            $telp = preg_replace('/^0+/', '62', $telp);
        }
        if (!preg_match('/^62/', $telp)) {
            $telp = '62' . ltrim($telp, '0');
        }
        $payload = [
            'target' => $telp,
            'message' => $this->pesan,
            'countryCode' => '62',
        ];


        try {
            $response = Http::withHeaders([
                'Authorization' => 'L9PaGYokqbue5GHechJR',
                'Accept' => 'application/json',
            ])->timeout(30)
            ->post('https://api.fonnte.com/send', $payload);


        } catch (\Throwable $e) {
            throw $e;
        }

    }


}
