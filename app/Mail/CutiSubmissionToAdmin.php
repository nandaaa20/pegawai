<?php

namespace App\Mail;

use App\Models\Cuti;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CutiSubmissionToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cuti $cuti)
    {
    }

    public function build(): self
    {
        $cuti = $this->cuti->loadMissing('pegawai.user');

        return $this->subject('Pengajuan Cuti Baru')
            ->view('emails.cuti.submission_admin', [
                'cuti' => $cuti,
            ]);
    }
}
