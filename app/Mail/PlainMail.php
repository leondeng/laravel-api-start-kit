<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlainMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
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
        $this->from($this->getMailFrom(), $this->getMailFromName());

        $to = $this->getMailTo();
        if (is_string($to)) {
            $to = explode(', ', $to);
        }
        $this->to($to, $this->getMailToName());

        $this->subject($this->getMailSubject());

        $bcc = $this->getBcc();
        if ($bcc) {
            if (is_array($bcc)) {
                $this->bcc([$bcc]);
            } else {
                $this->bcc($bcc);
            }
        }

        $replyTo = $this->getReplyTo();
        if ($replyTo) {
            if (is_array($replyTo)) {
                $this->replyTo([$replyTo]);
            } else {
                $this->replyTo($replyTo);
            }
        }

        return $this->html($this->getMailBody());
    }

    /**
     * Logic after mail has been sent.
     *
     * @return void
     */
    public function sent()
    {
    }

    protected function getMailFrom()
    {
        return $this->data['from'] ?? 'webmaster@email.com';
    }

    protected function getMailFromName()
    {
        return $this->data['from_name'] ?? $this->getMailFrom();
    }

    protected function getMailTo()
    {
        return $this->data['to'];
    }

    protected function getMailToName()
    {
        return NULL;
    }

    protected function getMailSubject()
    {
        return $this->data['subject'] ?? '';
    }

    protected function getMailBody()
    {
        return $this->data['body'] ?? '';
    }

    protected function getBcc()
    {
        return $this->data['bcc'] ?? NULL;
    }

    protected function getReplyTo()
    {
        return $this->data['reply_to'] ?? NULL;
    }
}
