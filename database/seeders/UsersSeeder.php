<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/json/users.json'));
        $data = json_decode($json);

        foreach ($data as $item) {

            $array = [
                "name" => $item->name,
                "email" => $item->email,
                "password" => bcrypt($item->password)
            ];

            User::create($array);
        }
    }
}
