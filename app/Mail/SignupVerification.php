<?php

namespace App\Mail;

use App\Models\Signup;

class SignupVerification extends PlainMail
{
    protected $signup;

    public function __construct(array $data)
    {
        $this->signup = $data['signup'];
    }

    public function getMailTo()
    {
        return $this->signup->email;
    }

    protected function getMailSubject()
    {
        return 'Welcome - please verify your email address';
    }

    public function getMailBody()
    {
        $link = $this->getVerificationLink();

        return '<p>Hi ' . $this->signup->first_name .
            ',</p><p>Welcome, ' .
            '.</p><p>To get started, you will need to <a href="' .
            $link .
            '" target="_blank">verify your email address and set your password</a>. Please visit the following url in your web browser:</p><br /><br /><p><strong><a href="' .
            $link . '" target="_blank">' . $link .
            '</a></p><br /><br /><p>If you have any trouble with verifying your email address and setting your password, please feel free to contact us.</p>';
    }

    private function getVerificationLink(): string
    {
        return config('app.url') . '/reset_password/' . encrypt(
            $this->signup->uuid . '~' .
                $this->signup->email . '~' .
                strtotime($this->signup->user->datetime_created) . '~' .
                time()
        );
    }


    public function sent()
    {
        $this->signup->status = Signup::STATUS_VERIFICATION_SENT;
        $this->signup->save();
    }
}
