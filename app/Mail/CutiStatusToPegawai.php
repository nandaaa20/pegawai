<?php

namespace App\Mail;

use App\Models\Cuti;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CutiStatusToPegawai extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cuti $cuti)
    {
    }

    public function build(): self
    {
        $cuti = $this->cuti->loadMissing('pegawai.user');

        return $this->subject('Status Pengajuan Cuti Anda')
            ->view('emails.cuti.status_pegawai', [
                'cuti' => $cuti,
            ]);
    }
}
