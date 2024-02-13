<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [

                'name' => 'SUPORTE example',
                'email' => 'suporte@example.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '21985852845',

            ],
        ];

        User::insert($users);
    }
}
