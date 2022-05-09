<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $candidate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($candidate = null)
    {
        $this->candidate = $candidate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Cảm ơn bạn đã gửi CSV')
            ->with([
                'candidate' => $this->candidate
            ])
            ->markdown('emails.candidate_created');
    }
}
