<?php

namespace App\Repositories;

use App\Models\Signup;

class SignupRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Signup::class;
    }
}
