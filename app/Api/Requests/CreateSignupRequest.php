<?php

namespace Api\Requests;

use App\Rules\SignupEmailUnique;
use App\Rules\SignupEmailValid;

class CreateSignupRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'bail',
                'email',
                'max:255',
                new SignupEmailUnique,
                new SignupEmailValid,
            ],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'web_site' => 'string|nullable|max:255',
        ];
    }
}
