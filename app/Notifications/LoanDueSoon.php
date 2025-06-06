<?php

namespace App\Notifications;

use App\Models\PeminjamanDetail; // Import model PeminjamanDetail
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanDueSoon extends Notification
{
    use Queueable;

    protected $loanDetail;

    /**
     * Create a new notification instance.
     */
    public function __construct(PeminjamanDetail $loanDetail)
    {
        $this->loanDetail = $loanDetail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Kita akan mengirim notifikasi ke database
        return ['database']; 
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Ini adalah data yang akan disimpan di kolom 'data' pada tabel notifications
        return [
            'loan_detail_id' => $this->loanDetail->id,
            'book_title' => $this->loanDetail->buku->judul,
            'due_date' => $this->loanDetail->tanggal_harus_kembali_item,
            'message' => "Buku '{$this->loanDetail->buku->judul}' akan jatuh tempo dalam 3 hari pada tanggal " . \Carbon\Carbon::parse($this->loanDetail->tanggal_harus_kembali_item)->format('d F Y') . "."
        ];
    }
}