<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $recipient = Setting::select('content')
            ->where('name','Systemowy adres email')
            ->first();

        return $this->subject('Wiadomość z serwisu Liga Mistrzów BSR')
            ->to($recipient['content'])
            ->view('mail.contact')->with('data', $this->data);
    }
}
