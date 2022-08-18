<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\SignupRepository;
use App\Models\Signup;
use App\Models\User;
use App\Jobs\SendEmail;
use App\Mail\SignupVerification;

class SignupService extends BaseService
{
    public function __construct(SignupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createSignup(array $data): Signup
    {
        $signup = Signup::make($data);
        $signup->status = Signup::STATUS_IN_PROGRESS;

        // transaction will auto rollback if any exception
        DB::transaction(function () use ($signup, $data) {
            $signup->save();

            $user = $this->createSignupUser($signup, $data);
            $user->signup()->save($signup);

            $this->sendSignupEmail($signup);
        });

        return $signup;
    }

    private function createSignupUser(Signup $signup, array $data): User
    {
        return User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => '',
        ]);
    }

    private function sendSignupEmail(Signup $signup): void
    {
        // Send the verification email to the new user
        SendEmail::dispatch(
                new SignupVerification([
                    'signup' => $signup,
                ])

        );
    }
}
