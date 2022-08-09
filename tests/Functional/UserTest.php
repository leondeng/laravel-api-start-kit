<?php namespace Tests\Functional;

use App\Models\User;

class UserTest extends TestCase
{
    public function testFindUser()
    {
        $user = User::find(11);

        $this->assertEquals('test@example.com', $user->email);
    }
}
