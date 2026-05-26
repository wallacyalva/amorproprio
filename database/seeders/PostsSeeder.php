<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/json/posts.json'));
        $data = json_decode($json);

        foreach ($data as $item) {

            $array = [
                "user_name" => $item->user_name,
                "staff" => $item->staff,
                "message" => $item->message,
                "img" => $item->img
            ];

            Post::create($array);
        }
    }
}
