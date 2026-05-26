<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/json/media.json'));
        $data = json_decode($json);

        foreach ($data as $item) {

            $array = [
                "title" => $item->title,
                "url" => $item->url
            ];

            Media::create($array);
        }
    }
}
