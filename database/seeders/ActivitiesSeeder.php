<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/json/activities.json'));
        $data = json_decode($json);

        foreach ($data as $item) {

            $array = [
                "title" => $item->title,
                "description" => $item->description,
                "img" => $item->img,
                "link" => $item->link
            ];

            Activity::create($array);
        }
    }
}
