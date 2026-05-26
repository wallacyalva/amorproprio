<?php

namespace Database\Seeders;

use App\Models\Text;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TextsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/json/texts.json'));
        $data = json_decode($json);

        foreach ($data as $item) {

            $array = [
                "name" => $item->name,
                "content" => $item->content
            ];

            Text::create($array);
        }
    }
}
