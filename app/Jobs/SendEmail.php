<?php

namespace App\Jobs;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Job
{
    /**
     * The mail to be sent.
     *
     * @var Mailable
     */
    protected $mailable;

    protected $callback;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $mailable, $callback = null)
    {
        $this->mailable = $mailable;
        $this->callback = $callback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send($this->mailable, [], $this->callback);
        $this->mailable->sent();
    }
}
