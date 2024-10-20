<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VaccineScheduleNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $registration;
    /**
     * Create a new message instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }
    public function build()
    {
        return $this->subject('Your COVID Vaccine Schedule')
            ->view('emails.vaccination_scheduled')
            ->with([
                'name' => $this->registration->name,
                'vaccineCenter' => $this->registration->vaccineCenter->name,
                'vaccinationDate' => $this->registration->scheduled_date,
            ]);
    }
}
