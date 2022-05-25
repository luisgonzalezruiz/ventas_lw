<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'     => 'Usuario Administrador',
                'email'    => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'phone'    => '00000000',
                'status'   => 'ACTIVE',
                'profile'    => 'ADMIN'

            ],
            [
                'name'     => 'Usuario empleado',
                'email'    => 'juan@gmail.com',
                'password' => bcrypt('12345678'),
                'phone'    => '00000000',
                'status'   => 'ACTIVE',
                'profile'    => 'EMPLOYEE'
            ]
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}

