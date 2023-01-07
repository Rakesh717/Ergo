<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'name' => 'Rakesh Thapa',
                'email' => 'vc76it23@vedascollege.edu.np',
            ],
            [
                'name' => 'Sambit Rimal',
                'email' => 'vc76it31@vedascollege.edu.np',
            ],
            [
                'name' => 'Utsav Karki',
                'email' => 'vc76it41@vedascollege.edu.np',
            ],
        ];

        foreach ($users as $user) {
            if (User::query()->where('email', $user['email'])->exists()) continue;

            User::factory()->withPersonalTeam()->create($user);
        }
    }
}
