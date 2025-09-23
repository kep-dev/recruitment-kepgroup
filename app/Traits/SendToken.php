<?php

namespace App\Traits;

use Carbon\Carbon;
use GuzzleHttp\Client;

trait SendToken
{
    /**
     * Generate WhatsApp recruitment test message.
     *
     * @param  array  $data
     *  - name: string
     *  - job_title: string
     *  - company_name: string
     *  - token: string
     *  - link: string
     *  - active_from: Carbon|string|null
     *  - active_until: Carbon|string|null
     *  - duration: int|null
     *  - contact: string|null
     * @return string
     */
    public function generateWhatsappMessage(array $data): void
    {
        $activeFrom  = $data['active_from'] ? Carbon::parse($data['active_from'])->format('d M Y H:i') : '-';
        $activeUntil = $data['active_until'] ? Carbon::parse($data['active_until'])->format('d M Y H:i') : '-';

        $message =  <<<MSG
            Halo {$data['name']},

            Terima kasih telah melamar posisi *{$data['job_title']}* di {$data['company_name']}.
            Anda dijadwalkan untuk mengikuti *Tes Online Rekrutmen*.

            🔑 Token: *{$data['token']}*
            📅 Periode Tes: {$activeFrom} s/d {$activeUntil}

            Cara mengikuti tes:
            1. Buka link tes di atas.
            2. Masukkan token saat login.
            3. Pastikan perangkat dan koneksi internet stabil.
            4. Tes hanya bisa diakses sekali dalam periode yang ditentukan.

            Jika ada kendala, silakan hubungi tim HRD kami di {$data['contact']}.

            Selamat mengerjakan & semoga sukses!
        MSG;

        $this->whatsappApi($data['contact'], $message);
    }

    public function whatsappApi($no, $pesan)
    {

        $client = new Client();
        $response = $client->post('https://api.fonnte.com/send', [
            'headers' => [
                'Authorization' => 'Zwnz7j227gXwy3BhuR1f', // ganti TOKEN dengan token Anda
            ],
            'form_params' => [
                'target' => $no,
                'message' => $pesan,
                'countryCode' => '62', // opsional
            ],
        ]);
    }
}
