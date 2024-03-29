<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 2,
                'title' => Role::ROLES['Admin'],
            ],
            [
                'id' => 3,
                'title' => Role::ROLES['User'],
            ],
            [
                'id' => 1,
                'title' => Role::ROLES['Super'],
            ],
        
        ];

        Role::insert($roles);
    }
}
