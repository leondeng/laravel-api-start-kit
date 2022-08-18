<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\User;

class SignupEmailUnique implements InvokableRule
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
        if (!$this->isEmailUnique($value)) {
            $fail('validation.custom.signup.EMAIL_ALREADY_REGISTERED')
                ->translate();
        }
    }

    private function isEmailUnique(string $email): bool
    {
        return !User::whereRaw('LCASE(email) = "' . strtolower($email) . '"')
            ->exists();
    }
}
