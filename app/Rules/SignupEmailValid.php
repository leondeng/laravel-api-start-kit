<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class SignupEmailValid implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!$this->isEmailValid($value)) {
            $fail('validation.custom.signup.EMAIL_INVALID')
                ->translate();
        }
    }

    private function isEmailValid(string $email): bool
    {
        return \MailChecker::isValid($email);
    }
}
