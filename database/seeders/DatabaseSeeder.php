<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // เรียกใช้ seeders
        $this->call([
            UserSeeder::class,
            TopicSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
