<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pengajuan $pengajuan)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->pengajuan->status === 'approved'
            ? '🎉 [PENGUMUMAN] Permohonan Magang Diterima & Surat Balasan (LoA) - SIMAG DISDIK SUMSEL'
            : '📌 [PEMBERITAHUAN] Hasil Seleksi Permohonan Magang - SIMAG DISDIK SUMSEL';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan_status',
            with: [
                'pengajuan' => $this->pengajuan,
            ],
        );
    }

    public function attachments(): array
    {
        try {
            $this->pengajuan->loadMissing('pesertas');

            if ($this->pengajuan->status === 'approved') {
                $pdf = Pdf::loadView('pdf.loa_pdf', ['pengajuan' => $this->pengajuan])
                    ->setPaper('a4', 'portrait');

                $filename = 'LoA_Surat_Balasan_' . str_replace(' ', '_', $this->pengajuan->nama_instansi ?? 'Magang') . '.pdf';

                return [
                    Attachment::fromData(fn () => $pdf->output(), $filename)
                        ->withMime('application/pdf'),
                ];
            }

            if ($this->pengajuan->status === 'rejected') {
                $pdf = Pdf::loadView('pdf.loa_penolakan_pdf', ['pengajuan' => $this->pengajuan])
                    ->setPaper('a4', 'portrait');

                $filename = 'Surat_Penolakan_' . str_replace(' ', '_', $this->pengajuan->nama_instansi ?? 'Magang') . '.pdf';

                return [
                    Attachment::fromData(fn () => $pdf->output(), $filename)
                        ->withMime('application/pdf'),
                ];
            }
        } catch (\Throwable $e) {
            // Jika render PDF gagal dalam attachment, kirim email tanpa lampiran
        }

        return [];
    }
}
