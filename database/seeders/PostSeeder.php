<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'description' => 'First Post',
            'image'       => 'test.png',
            'user_id'     => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
