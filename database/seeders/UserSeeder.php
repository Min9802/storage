<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $table = new User;
        $table->truncate();
        $data = [
            'username' => "Admin",
            'name' => "Admin",
            'email' => "Hieumin9802@gmail.com",
            'password' => Hash::make('Min230298'),
            // 'token' => "QS2RBkNZx5iWGdnDLr37y9jaPC0whIM4AzefKT8bmVHsv1EolY"
        ];
        $table->create($data);
    }
    public function random($lenght)
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $randStr = substr(str_shuffle($str), 0, $lenght);
        return $randStr;
    }
}
