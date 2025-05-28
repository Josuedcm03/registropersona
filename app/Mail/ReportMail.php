<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function build()
    {
        return $this->subject(___('Report Mail'))
            ->view('emails.report')
            ->with([
                'reportData' => $this->reportData,
            ]);
    }


}
