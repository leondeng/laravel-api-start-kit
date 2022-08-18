<?php

namespace Api\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Services\SignupService;
use Api\Requests\CreateSignupRequest;
use App\Http\Resources\SignupResource;
use App\Rules\SignupEmailUnique;
use App\Rules\SignupEmailValid;

class SignupController extends Controller
{
    public function checkEmail(string $email)
    {
        Validator::validate([
            'email' => $email,
        ], [
            'email' => [
                'bail',
                'email',
                new SignupEmailUnique,
                new SignupEmailValid,
            ],
        ]);

        return $this->okResponse(['email' => $email]);
    }

    public function store(CreateSignupRequest $request, SignupService $service)
    {
        $signup = $service->createSignup($request->validated());

        return $this->okResponse(
            new SignupResource(
                $service->find($signup->id)
            )
        );
    }
}
