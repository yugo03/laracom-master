<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $email;
    public $iam;
    public $inquiryMessage;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->customerName = $data['name'];
        $this->email = $data['email'];
        $this->iam = $data['iam'];
        $this->inquiryMessage = $data['message'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email, $this->customerName)
            ->subject('お問い合わせ - ' . config('app.name'))
            ->view('emails.inquiry.send')
            ->with([
                'from' => $this->customerName,
                'inquiryMessage' => $this->inquiryMessage,
            ]);
    }
}
