<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password')
        ]);

        Post::factory()->count(5)->for($user)->create();
    }
}
