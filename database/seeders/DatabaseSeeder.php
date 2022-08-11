<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('comments')->truncate();

        User::factory(10)->create();

        User::factory()
            ->has(Comment::factory(3))
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
    }
}
